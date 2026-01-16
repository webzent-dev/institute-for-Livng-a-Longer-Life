<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Product;

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
    $collaborators = User::where('role', 'collaborator') ->withCount('courses', 'products')->where('status', 'active')->get();
    $specialties = $collaborators->pluck('Specialty')->filter()->unique()->sort()->values();
    return view('front.pages.collaborators', compact('collaborators', 'specialties'));
       
    }

    public function store($id)
{
    try {
        $id = decrypt($id);
    } catch (\Exception $e) {
        abort(404);
    }
    $collaborator = User::findOrFail($id);
    $products = Product::where('user_id', $collaborator->id)->where('status', 1)->latest()->get();
    return view('front.pages.store', compact('collaborator', 'products'));
}



     
    
}
