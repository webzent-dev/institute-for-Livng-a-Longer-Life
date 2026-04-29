<?php

namespace App\Http\Controllers\Collaborator;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Laravel\SerializableClosure\SerializableClosure;

class CollaboratorProductController extends Controller
{
    public function index()
    { 
        $collaboratorProducts = Product::where('user_id', Auth::id())->paginate(10);
        
        return view('collaborator.product.index', compact('collaboratorProducts'));
    }

    public function create()
    {
        return view('collaborator.product.create');
    }

    public function store(Request $request)
    {
        /*
        $request->validate([
            'product_type' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            //'discounted_price' => 'nullable|numeric',
            //'original_price' => 'nullable|numeric',
            //'rating' => 'nullable|string',
            //'reviews' => 'nullable|string',
            'stock_quantity' => 'required|integer',
            'product_images.*' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB each
        ]);
        */

        /*$imageName = null;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('product_images'), $imageName);
        }*/

        /*$validator = Validator::make(
            [
                'category'  => $request->category,
                'product_type'  => $request->product_type,
                'name'  => $request->name,
                'description'  => $request->description,
                'price'  => $request->price,
                'stock_quantity'  => $request->stock_quantity,
                'product_images.*'  => $request->product_images
            ], 
            [
                'category' => 'required',
                'product_type' => 'required',
                'name' => 'required|string',
                'description' => 'required|string',
                'price' => 'required|numeric',
                'stock_quantity' => 'required|integer',
                'product_images.*' => 'required|image|mimes:jpg,jpeg,png|max:5120', // 5MB each
            ]
        );

        if ($validator->fails()) {
            return redirect()->back()->with('error',$validator)->withInput();
        }*/

        //Add validation for check slug
        $slug = Str::slug($request->product_name);
        $slugCount = Product::where('slug', $slug)->count();
        if($slugCount > 0){
            return redirect()->back()->with('error', 'Product with the same name & slug already exists. Please choose a different name.')->withInput();
        }else{
            $product = Product::create([
                'user_id' => Auth::id(),
                'product_type' => $request->product_type,
                'category' => 'collaborator',
                'name' => $request->product_name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                'stock_quantity' => $request->stock_quantity,
                'status' => 'active'
            ]);

            // Check if images exist
            if ($request->hasFile('product_images')) {
                $i = 1;
                foreach ($request->file('product_images') as $image) {
                    // Generate unique filename
                    $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();

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
            return redirect()->route('collaborator.products')->with('success', 'Product has been added successfully.');
        }
  
    }


    public function edit($id)
    {
        $productDetail = Product::findOrFail($id);

        //Product images
        $productImages = ProductImage::where('product_id', $id)->get();

        return view('collaborator.product.show', compact('productDetail','productImages'));
    }

    public function show($id)
    {
        $productDetail = Product::findOrFail($id);

        //Product images
        $productImages = ProductImage::where('product_id', $id)->get();

        return view('collaborator.product.show', compact('productDetail','productImages'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        /*
        $request->validate([
            'product_type' => 'required|string',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            //'discounted_price' => 'nullable|numeric',
            //'original_price' => 'nullable|numeric',
            //'category' => 'nullable|string',
            //'rating' => 'nullable|string',
            //'reviews' => 'nullable|string',
            'stock_quantity' => 'required|integer',
            //'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
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
        }else{
            $product->update([
                'product_type' => $request->product_type,
                'name' => $request->product_name,
                'slug' => $slug,
                'description' => $request->description,
                'price' => $request->price,
                //'discount' => $request->discounted_price,
                //'originalPrice' => $request->original_price,
                //'rating' => $request->rating,
                //'reviews' => $request->reviews,
                'stock_quantity' => $request->stock_quantity
            ]);

            // Check if images exist
            if ($request->hasFile('product_images')) {
                $i = 1;
                foreach ($request->file('product_images') as $image) {
                    // Generate unique filename
                    $imageName = time().'_'.Str::random(10).'.'.$image->getClientOriginalExtension();

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
        //echo '<pre>';print_r($product);exit;

        //Delete image from product_images folder
        if ($product->image && file_exists(public_path('product_images/'.$product->image))) {
            unlink(public_path('product_images/'.$product->image));
        }

        $product->delete();
        return redirect()->route('collaborator.products')->with('success', 'Product has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);

        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return response()->json(['success' => true]);
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