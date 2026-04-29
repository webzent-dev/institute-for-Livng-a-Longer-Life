<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::with('user')
        ->whereIn('category',['collaborator','institute'])
        ->whereIn('product_type',['supplement','guide','book'])
        ->where('status', 'active')->get();
        return view('front.pages.shop', compact('products'));
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        $products = Product::when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->when($category, function($q) use ($category) {
            $q->where('category', $category);
        })
        ->get();
        return view('front.pages.shop', compact('products'));
    }
    
    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('shop')->with('error', 'Product not found.');
        }
        return view('front.pages.product-details', compact('product'));
    }

}