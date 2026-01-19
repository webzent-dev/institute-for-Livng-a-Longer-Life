<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class IndexController extends Controller
{
     
    public function index()
    {
         $product = Product::where('status', 1)->latest()->first();
         return view('front.pages.home', compact('product'));
    }
     public function introVideos()
    {
        return view('front.pages.intro-videos');
    }
    public function membership()
    {
        return view('front.pages.membership');
    }
    
    public function create()
    {
         
    }

     
    public function store(Request $request)
    {
         
    }

     
    public function show(string $id)
    {
        
    }

     
    public function edit(string $id)
    {
         
    }

     
    public function update(Request $request, string $id)
    {
         
    }
 
    public function destroy(string $id)
    {
         
    }
}
