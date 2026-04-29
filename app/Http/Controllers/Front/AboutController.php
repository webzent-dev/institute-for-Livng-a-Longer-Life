<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use App\Models\Product;
use App\Models\ContentManagement;
use App\Models\Course;

class AboutController extends Controller
{
     
    public function index()
    {
         
    }
    public function aboutZeines()
    {
        $aboutPageContent = ContentManagement::where('page_name', 'about_page')->first();
        return view('front.pages.about-dr-zeines',compact('aboutPageContent'));
    }
    public function collaborators()
    {
        $collaborators = User::where('role', 'collaborator')->withCount('products')->withCount('courses')->where('status', 'active')->get();
        $specialties = $collaborators->pluck('speciality')->filter()->unique()->sort()->values();
        $collaboratorPageContent = ContentManagement::where('page_name', 'collaborator_page')->first();
        return view('front.pages.collaborators', compact('collaborators', 'specialties', 'collaboratorPageContent'));
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

    public function collaboratorDetails($id)
    {
        try {
            $id = decrypt($id);
            $collaboratorDetail = User::where('id', $id)->withCount('products')->withCount('courses')->first();
            if(empty($collaboratorDetail)){
                return redirect('/collaborators');
            }
            $products = Product::where('user_id', $id)->where('status', 'active')->latest()->get();
            $courses = Course::where('user_id', $id)->where('status', 'published')->latest()->get();
            return view('front.pages.collaborator-detail', compact('collaboratorDetail', 'products', 'courses'));
        } catch (\Exception $e) {
            abort(404);
        }
    }

}