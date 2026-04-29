<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Location;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $locations = Location::all();
        return view('admin.locations.index', compact('locations'));
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
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|numeric|min:5',
            'country' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $location = Location::create([
            'name' => $request->name,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Location has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $locationDetail = Location::findOrFail($id);
        return view('admin.locations.show', compact('locationDetail'));
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
        $locationDetail = Location::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'zip' => 'required|numeric|min:5',
            'country' => 'required|string|max:255',
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);

        $locationDetail->update([
            'name' => $request->name,
            'city' => $request->city,
            'state' => $request->state,
            'zip' => $request->zip,
            'country' => $request->country,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);

        return redirect()->back()->with('success', 'Location has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $locationDetail = Location::findOrFail($id);
        $locationDetail->delete();
        return redirect()->route('admin.locations')->with('success', 'Location has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        $location = Location::findOrFail($id);
        $location->status = $request->status;
        $location->save();
        return response()->json(['success' => true]);
    }
}
