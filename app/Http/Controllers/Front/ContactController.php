<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Subscribe;
use Illuminate\Support\Facades\DB;

 

class ContactController extends Controller
{
    public function index()
    {
        return view('front.pages.contact');
    }

  public function store(Request $request)
{
    
    $request->validate([
        'first_name'  => 'required|string|max:255',
        'last_name'   => 'required|string|max:255',
        'email'       => 'required|email',
        'phone' => 'required|string|max:20',
        'subject'     => 'required|string|max:255',
        'description' => 'required|string',
    ]);

    Contact::create($request->all());

    return back()->with('success', 'get back to you within 24 hours');
}


    public function subscribe(Request $request)
    {
        // Validation here 
        $validated = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName'  => 'required|string|max:255',
            'email'     => 'required|email|max:255|unique:newsletters,email',
            'gender'    => 'required|in:not,woman,man',
        ]);

        // Save to DB
        Subscribe::create([
            'first_name' => $validated['firstName'],
            'last_name'  => $validated['lastName'],
            'email'      => $validated['email'],
            'gender'     => $validated['gender'],
        ]);

        // Redirect back with success message
        return back()->with('success', 'Thank you for subscribing!');
    }

}
