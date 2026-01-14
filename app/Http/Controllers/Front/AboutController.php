<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

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
    $collaborators = User::where('role', 'collaborator') ->withCount('courses', 'products') ->get();
    $specialties = $collaborators->pluck('Specialty')
    ->filter()
    ->unique()
    ->sort()
    ->values();

return view('front.pages.collaborators', compact('collaborators', 'specialties'));
       
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
