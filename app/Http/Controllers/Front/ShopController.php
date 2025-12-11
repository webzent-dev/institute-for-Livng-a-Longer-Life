<?php

namespace App\Http\Controllers\Front;   

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = Product::all();
         $categories = collect($products)->pluck('category')->unique();
        return view('front.pages.shop', compact('products', 'categories'));
    }
    public function filter(Request $request)
    {
        // $query = Product::query();
        // if ($request->filled('search')) {
        //     $search = $request->input('search');
        //     $query->where(function($q) use ($search) {
        //         $q->where('name', 'like', "%{$search}%")
        //         ->orWhere('category', 'like', "%{$search}%");
        //     });
        // }
    
        // if ($request->filled('category')) {
        //     $query->where('category', $request->input('category'));
        // }
    
        // $products = $query->get();


        // new code
        $search = $request->search;
    $category = $request->category;

    $products = Product::when($search, function($q) use ($search) {
                        $q->where('name', 'like', "%$search%");
                    })
                    ->when($category, function($q) use ($category) {
                        $q->where('category', $category);
                    })
                    ->get();


    // $products = Product::query()
    //     ->when($request->search, fn($q) =>
    //         $q->where('name', 'like', "%{$request->search}%")
    //           ->orWhere('category', 'like', "%{$request->search}%")
    //     )
    //     ->when($request->category, fn($q) =>
    //         $q->where('category', $request->category)
    //     )
    //     ->get();





        // Return a partial HTML for AJAX
        return view('front.pages.shop', compact('products'));
    }
}