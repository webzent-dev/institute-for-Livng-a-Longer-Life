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
        return view('front.pages.shop', compact('products'));
    }
}