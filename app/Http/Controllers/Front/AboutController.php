<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AboutController extends Controller
{
     
    public function index()
    {
         
    }
    public function aboutZeines()
    {
        return view('front.pages.about-dr-zeines');
    }
    public function collaborators()
    {
        return view('front.pages.collaborators');
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
