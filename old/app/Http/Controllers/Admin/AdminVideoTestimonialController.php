<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\VideoTestimonial;

class AdminVideoTestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = VideoTestimonial::all();
        return view('admin.video_testimonials.index', compact('testimonials'));
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
            'quote' => 'required',
            'video_url' => 'required|url',
            'thumbnail' => 'required'
        ]);

        //Upload og image
        $thumbnail = null;
        if ($request->hasFile('thumbnail') && !empty($request->thumbnail)) {
            $thumbnail = 'thumbnail_'.time() . '.' . $request->thumbnail->getClientOriginalExtension();
            $request->thumbnail->move(public_path('testimonial_images'), $ogImageName);
        }

        $testimonial = VideoTestimonial::create([
            'name' => $request->name,
            'quote' => $request->quote,
            'video_url' => $request->video_url,
            'thumbnail' => $thumbnail,
            'is_active' => 1
        ]);

        return redirect()->back()->with('success', 'Video Testimonial has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $testimonialDetail = VideoTestimonial::find($id);
        return view('admin.video_testimonials.show', compact('testimonialDetail'));
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
        $testimonialDetail = VideoTestimonial::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'quote' => 'required',
            'video_url' => 'required|url',
            'thumbnail' => 'required'
        ]);

        //Upload thumbnail
        if ($request->hasFile('thumbnail') && !empty($request->thumbnail)) {
            $thumbnailName = 'thumbnail_'.time() . '.' . $request->thumbnail->getClientOriginalExtension();
            $request->thumbnail->move(public_path('testimonial_images'), $thumbnailName);
            $thumbnail = $thumbnailName;
        }else{
            $thumbnail = $testimonialDetail->thumbnail;
        }

        $testimonialDetail->update([
            'name' => $request->name,
            'quote' => $request->quote,
            'video_url' => $request->video_url,
            'thumbnail' => $thumbnail,
            'is_active' => $request->is_active
        ]);

        return redirect()->back()->with('success', 'Video Testimonial has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $testimonialDetail = VideoTestimonial::findOrFail($id);
        $testimonialDetail->delete();
        return redirect()->route('admin.video-testimonials')->with('success', 'Video Testimonial has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|in:active,inactive'
        ]);
        $testimonial = VideoTestimonial::findOrFail($id);
        if($request->is_active == 'active')
            $is_active = 1;
        else
            $is_active = 0;

        $testimonial->is_active = $is_active;
        $testimonial->save();
        return response()->json(['success' => true]);
    }

}