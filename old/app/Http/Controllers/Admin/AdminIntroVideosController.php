<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\IntroVideos;

class AdminIntroVideosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $introVideos = IntroVideos::all();
        return view('admin.intro_videos.index', compact('introVideos'));
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
            'title' => 'required|string',
            'video_url' => 'required|string'
        ]);

        IntroVideos::create([
            'title' => $request->input('title'),
            'video_url' => $request->input('video_url'),
            'status' => 'active'
        ]);

        return redirect()->back()->with('success', 'Intro video has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $introVideoDetail = IntroVideos::find($id);
        return view('admin.intro_videos.show', compact('introVideoDetail'));
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
        $introVideoDetail = IntroVideos::findOrFail($id);

        $request->validate([
            'title' => 'required|string',
            'video_url' => 'required|string'
        ]);

        $introVideoDetail->update([
            'title' => $request->input('title'),
            'video_url' => $request->input('video_url'),
            'status' => $request->input('status')
        ]);

        return redirect()->back()->with('success', 'Intro Video has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $introVideoDetail = IntroVideos::findOrFail($id);
        $introVideoDetail->delete();
        return redirect()->route('admin.intro-videos')->with('success', 'Intro videos has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        $introVideoDetail = IntroVideos::findOrFail($id);
        $introVideoDetail->status = $request->status;
        $introVideoDetail->save();
        return response()->json(['success' => true]);
    }

}