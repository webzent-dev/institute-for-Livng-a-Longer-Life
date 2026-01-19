<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class VitalBoostController extends Controller
{
    public function index()
    {
        $product = Product::where('status', 1)->latest()->first();
        return view('front.pages.vital-boost', compact('product'));
    }
   
}