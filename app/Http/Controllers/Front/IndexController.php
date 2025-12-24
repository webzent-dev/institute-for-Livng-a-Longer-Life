<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Controller
{
     
    public function index()
    {
        return view('front.pages.home');
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
