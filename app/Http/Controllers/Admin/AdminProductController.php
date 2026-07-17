<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\SerializableClosure;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class AdminProductController extends Controller
{
    public function index(Request $request)
    {
        //Institute products with pagination and select and alias fields
        $instituteFilter = $request->input('institute_filter');
        $instituteQuery = Product::with('user')->selectRaw('products.id as product_id, products.*')->join('users', 'products.user_id', '=', 'users.id')->where('users.role', 'admin')->whereIn('products.category',['institute', 'vital_boost']);

        // "Vital Boost only" filter for the Institute list.
        if ($instituteFilter === 'vital_boost') {
            $instituteQuery->where('products.product_type', 'vital_boost');
        }

        $instituteProducts = $instituteQuery->paginate(10)->withQueryString();

        // Multi-active guard: the public /vital-boost page shows only the first active
        // Vital Boost product, so surface a warning when more than one is active.
        $activeVitalBoostProducts = Product::where('product_type', 'vital_boost')->where('status', 'active')->get(['id', 'name']);
        $activeVitalBoostCount = $activeVitalBoostProducts->count();
        $activeVitalBoostNames = $activeVitalBoostProducts->pluck('name')->implode(', ');

        //Collaborator products wtih select and alias fields 
        $collaboratorProducts = Product::with('user')->selectRaw('products.id as product_id, products.*')->join('users', 'products.user_id', '=', 'users.id')->where('users.role', 'collaborator')->where('products.category','collaborator')->paginate(10);

        //Member products
        $memberProducts = Product::with('user')->selectRaw('products.id as product_id, products.*')->where('products.category', 'member_exclusive')->paginate(10);

        //Users
        $users = User::whereIn('role', ['admin', 'collaborator'])->get();


        return view('admin.product.index', compact('instituteProducts', 'collaboratorProducts', 'memberProducts', 'users', 'instituteFilter', 'activeVitalBoostCount', 'activeVitalBoostNames'));
    }

    public function create()
    {

    }

    /**
     * Keep Vital Boost product type and category locked together: a Vital Boost
     * type forces the Vital Boost category and vice-versa. This is the server-side
     * guarantee behind the coupled dropdowns, so the invariant holds even if the
     * form is bypassed.
     *
     * @return array{0:?string,1:?string} [product_type, category]
     */
    private function coupleVitalBoost(?string $productType, ?string $category): array
    {
        if ($productType === 'vital_boost') {
            $category = 'vital_boost';
        } elseif ($category === 'vital_boost') {
            $productType = 'vital_boost';
        }

        return [$productType, $category];
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name'     => 'required|string|max:255',
            'product_type'     => 'required|string',
            'price'            => 'required|numeric|min:0',
            'stock_quantity'   => 'required|integer|min:0',
            'product_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        //Add validation for check slug
        $slug = Str::slug($request->product_name);
        $slugCount = Product::where('slug', $slug)->count();
        if($slugCount > 0){
            return redirect()->back()->with('error', 'Product with the same name & slug already exists. Please choose a different name.')->withInput();
        }

        //Add validation for check SKU
        $skuCount = Product::where('sku', $request->sku)->count();
        if($skuCount > 0){
            return redirect()->back()->with('error', 'Product with the same SKU already exists. Please choose a different SKU.')->withInput();
        }
        
        if($slugCount == 0 && $skuCount == 0){
            [$productType, $category] = $this->coupleVitalBoost($request->product_type, $request->category);
            $product = Product::create([
                'user_id' => $request->user_id,
                'sku' => $request->sku,
                'product_type' => $productType,
                'category' => $category,
                'name' => $request->product_name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'weight' => $request->weight ?? 0,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'shipping_template' => $request->shipping_template,
                'requires_shipping' => $request->has('requires_shipping') ? 1 : 0,
                'status' => 'active'
            ]);

            // Check if images exist
            if ($request->hasFile('product_images')) {
                $i = 1;
                foreach ($request->file('product_images') as $image) {
                    // Generate unique filename
                    $imageName = time().'_'.Str::random(10).'.'.$image->extension();

                    // Store image
                    //$image->storeAs('public/product_images', $imageName);
                    $image->move(public_path('product_images'), $imageName);

                    // Save image in DB
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);

                    if ($i == 1) {
                        $product->image = $imageName;
                        $product->save();
                    }

                    $i++;
                }
            }

            return redirect()->route('admin.products')->with('success', 'Product has been added successfully.');
        }
    }

    public function show($id)
    {
        $productDetail = Product::findOrFail($id);

        //Product images
        $productImages = ProductImage::where('product_id', $id)->get();

        //Total Sales
        $totalSales = OrderItem::where('product_id', $id)->sum('total');

        //Users
        $users = User::whereIn('role', ['admin', 'collaborator'])->get();

        return view('admin.product.show', compact('productDetail','productImages','totalSales', 'users'));
    }


    public function edit($id)
    {
        $productDetail = Product::findOrFail($id);

        //Product images
        $productImages = ProductImage::where('product_id', $id)->get();

        return view('admin.product.show', compact('productDetail','productImages'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'sku'              => 'required|string|unique:products,sku,'.$id,
            'category'         => 'required',
            'product_type'     => 'required|string',
            'product_name'     => 'required|string|max:255',
            'description'      => 'required',
            'price'            => 'required|numeric|min:0',
            'stock_quantity'   => 'required|integer|min:0',
            'weight'           => 'required|numeric|min:0',
            'length'           => 'required|numeric|min:0',
            'width'            => 'required|numeric|min:0',
            'height'           => 'required|numeric|min:0',
            'product_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        /*if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('product_images/'.$product->image))) {
                unlink(public_path('product_images/'.$product->image));
            }
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('product_images'), $imageName);
            $product->image = $imageName;
        }*/

        //Add validation for check slug
        $slug = Str::slug($request->product_name);
        $slugCount = Product::where('slug', $slug)->where('id', '!=', $id)->count();
        if($slugCount > 0){
            return redirect()->back()->with('error', 'Product with the same name & slug already exists. Please choose a different name.')->withInput();
        }
        
        //Add validation for check SKU
        $skuCount = Product::where('sku', $request->sku)->where('id', '!=', $id)->count();
        if($skuCount > 0){
            return redirect()->back()->with('error', 'Product with the same SKU already exists. Please choose a different SKU.')->withInput();
        }
        
        if($slugCount == 0 && $skuCount == 0){
            [$productType, $category] = $this->coupleVitalBoost($request->product_type, $request->category);
            //Update product
            $product->update([
                'user_id' => $request->user_id,
                'sku' => $request->sku,
                'product_type' => $productType,
                'category' => $category,
                'name' => $request->product_name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'weight' => $request->weight ?? 0,
                'length' => $request->length,
                'width' => $request->width,
                'height' => $request->height,
                'shipping_template' => $request->shipping_template,
                'requires_shipping' => $request->has('requires_shipping') ? 1 : 0
            ]);

            // Check if images exist
            if ($request->hasFile('product_images')) {
                $i = 1;
                foreach ($request->file('product_images') as $image) {
                    // Generate unique filename
                    $imageName = time().'_'.Str::random(10).'.'.$image->extension();

                    // Store image
                    //$image->storeAs('public/product_images', $imageName);
                    $image->move(public_path('product_images'), $imageName);

                    // Save image in DB
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image' => $imageName,
                    ]);

                    if ($i == 1) {
                        $product->image = $imageName;
                        $product->save();
                    }

                    $i++;
                }
            }

            return redirect()->back()->with('success', 'Product has been updated successfully.');
        }
    }

   public function destroy($id)
    {
        $product = Product::findOrFail($id);

        //Delete image from product_images folder
        if ($product->image && file_exists(public_path('product_images/'.$product->image))) {
            unlink(public_path('product_images/'.$product->image));
        }

        $product->delete();
        return redirect()->route('admin.products')->with('success', 'Product has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        // Multi-active guard: warn when activating a Vital Boost product while another
        // Vital Boost product is already active (the public page shows only the first).
        $warning = null;
        if ($request->status === 'active' && $product->product_type === 'vital_boost') {
            $otherActive = Product::where('product_type', 'vital_boost')
                ->where('status', 'active')
                ->where('id', '!=', $product->id)
                ->count();
            if ($otherActive > 0) {
                $warning = 'There are now ' . ($otherActive + 1) . ' active Vital Boost products. The public Vital Boost page shows only the first active one — keep just one active to avoid confusion.';
            }
        }

        return response()->json(['success' => true, 'warning' => $warning]);
    }

    public function removeImage(Request $request)
    {
        $image = ProductImage::findOrFail($request->image_id);
        if ($image->image && file_exists(public_path('product_images/'.$image->image))) {
            unlink(public_path('product_images/'.$image->image));
        }
        $delete = $image->delete();
        if($delete){
            return response()->json(['status' => true, 'message' => 'Image has been deleted successfully.']);
        }else{
            return response()->json(['status' => false, 'message' => 'Unable to remove image.Somethign went wrong.']);
        }
        
    }

}
