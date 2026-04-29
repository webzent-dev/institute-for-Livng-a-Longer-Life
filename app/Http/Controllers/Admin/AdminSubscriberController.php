<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subscribe;

class AdminSubscriberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch subscribers from the database
        $subscribers = Subscribe::paginate(10);

        // Return the view with the subscribers data
        return view('admin.subscribers.index', compact('subscribers'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Find the subscriber by ID and delete
        $subscriber = Subscribe::findOrFail($id);
        $subscriber->delete();

        // Redirect back to the subscribers list with a success message
        return redirect()->route('admin.subscribers')->with('success', 'Subscriber deleted successfully.');
    }
}
