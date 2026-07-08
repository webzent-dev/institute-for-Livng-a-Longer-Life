<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\User;

class AdminTestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::paginate(10);
        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'nullable|string',
        ]);

        $testimonial = Testimonial::create([
            'name' => $request->name,
            'location' => $request->location,
            'rating' => $request->rating ?? 5,
            'quote' => $request->quote ?? '',
            'is_active' => 1
        ]);

        return redirect()->back()->with('success', 'Testimonial has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonialDetail = Testimonial::find($id);
        return view('admin.testimonials.show', compact('testimonialDetail'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $testimonialDetail = Testimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'rating' => 'nullable|integer|min:1|max:5',
            'quote' => 'nullable|string',
        ]);

        $testimonialDetail->update([
            'name' => $request->name,
            'location' => $request->location,
            'rating' => $request->rating ?? 5,
            'quote' => $request->quote ?? '',
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'Testimonial has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonialDetail = Testimonial::findOrFail($id);
        $testimonialDetail->delete();
        return redirect()->route('admin.testimonials')->with('success', 'Testimonial has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|in:active,inactive'
        ]);
        $testimonial = Testimonial::findOrFail($id);
        if($request->is_active == 'active')
            $is_active = 1;
        else
            $is_active = 0;

        $testimonial->is_active = $is_active;
        $testimonial->save();
        return response()->json(['success' => true]);
    }
    
}