<?php

namespace App\Http\Controllers\Front;   

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;
use App\Models\Product;

class ShopController extends Controller
{
    public function index()
    {
        $products = 
                    [
                        [
                            'id' => 1,
                            'user_id' => 1,
                            'name' => 'Omega-3 Supreme',
                            'description' => 'High-potency omega-3 fish oil for heart and brain health',
                            'price' => 49.99,
                            'discount' => 17,
                            'originalPrice' => 59.99,
                            'category' => 'Supplements',
                            'rating' => 4.8,
                            'reviews' => 234,
                            'stock_quantity' => 100,
                            'image_url' => 'supplement',
                            'status' => 'active',
                        ],
                        [
                            'id' => 2,
                            'user_id' => 3,
                            'name' => 'Adaptogen Blend',
                            'description' => 'Premium adaptogenic herbs for stress resilience',
                            'price' => 39.99,
                            'discount' => 20,
                            'originalPrice' => 49.99,
                            'category' => 'Nutrition',
                            'rating' => 4.9,
                            'reviews' => 187,
                            'stock_quantity' => 100,
                            'image_url' => 'supplement',
                            'status' => 'active',
                        ],
                        [
                            'id' => 3,
                            'user_id' => 2,
                            'name' => 'Recovery Protein',
                            'description' => 'Plant-based protein blend for optimal recovery',
                            'price' => 54.99,
                            'discount' => 15,
                            'originalPrice' => 64.99,
                            'category' => 'Equipment',
                            'rating' => 4.0,
                            'reviews' => 412,
                            'stock_quantity' => 100,
                            'image_url' => 'nutrition',
                            'status' => 'active',
                        ],
                        [
                            'id' => 4,
                            'user_id' => 1, // safer for FK issues
                            'name' => 'Sleep Optimizer',
                            'description' => 'Natural sleep support with melatonin and magnesium',
                            'price' => 34.99,
                            'discount' => 22,
                            'originalPrice' => 44.99,
                            'category' => 'Nutrition',
                            'rating' => 3.0,
                            'reviews' => 289,
                            'stock_quantity' => 100,
                            'image_url' => 'supplement',
                            'status' => 'active',
                        ],
                    ];

        //  $categories = collect($products)->pluck('category')->unique();

 $categories = collect($products)
        ->pluck('category')
        ->unique()
        ->values();



        return view('front.pages.shop', compact('products', 'categories'));
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
    public function productDetails()
    {
        // $productId = $request->query('id');
        // $product = Product::find($productId);

        // if (!$product) {
        //     return redirect()->route('shop')->with('error', 'Product not found.');
        // }

        return view('front.pages.product-details');
    }

}