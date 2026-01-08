<?php

namespace App\Http\Controllers\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    { 
       $products = Product::where('user_id', Auth::id())->get();
        return view('product.index', compact('products'));
    }

    public function create()
    {
      
        return view('product.create');
    }

    public function store(Request $request)
    {
        $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'discounted_price' => 'nullable|numeric',
        'original_price' => 'nullable|numeric',
        'category' => 'nullable|string',
        'rating' => 'nullable|string',
        'reviews' => 'nullable|string',
        'stock_quantity' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    $imageName = null;
    if ($request->hasFile('image')) {
        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('product_images'), $imageName);
    }

    Product::create([
        'user_id' => Auth::id(),
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'discount' => $request->discounted_price,
        'originalPrice' => $request->original_price,
        'category' => $request->category,
        'rating' => $request->rating,
        'reviews' => $request->reviews,
        'stock_quantity' => $request->stock_quantity,
        'image' => $imageName,
    ]);
    return redirect()->route('products.index')
        ->with('success', 'Product added successfully.wait for admin approval.');
  
    }


    public function edit($id)
    {
        
        $product = Product::findOrFail($id);
        return view('product.create', compact('product'));
    }

    public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);

    $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'discounted_price' => 'nullable|numeric',
        'original_price' => 'nullable|numeric',
        'category' => 'nullable|string',
        'rating' => 'nullable|string',
        'reviews' => 'nullable|string',
        'stock_quantity' => 'required|integer',
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        
    ]);

    if ($request->hasFile('image')) {

        if ($product->image_url && file_exists(public_path('product_images/'.$product->image_url))) {
            unlink(public_path('product_images/'.$product->image_url));
        }

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('product_images'), $imageName);

        $product->image_url = $imageName;
    }

    $product->update([
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'discount' => $request->discounted_price,
        'originalPrice' => $request->original_price,
        'category' => $request->category,
        'rating' => $request->rating,
        'reviews' => $request->reviews,
        'stock_quantity' => $request->stock_quantity,
        
    ]);

    return redirect()->route('products.index')
        ->with('success', 'Product updated successfully.');
}
}
