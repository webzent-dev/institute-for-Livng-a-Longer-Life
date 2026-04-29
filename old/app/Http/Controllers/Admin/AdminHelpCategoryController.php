<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpCategory;
use Illuminate\Support\Str;

class AdminHelpCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $helpCategories = HelpCategory::all();
        return view('admin.help_categories.index', compact('helpCategories'));
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
            'icon' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $category = HelpCategory::create([
            'icon' => $request->icon,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Help category has been created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helpCategoryDetail = HelpCategory::findOrFail($id);
        return view('admin.help_categories.show', compact('helpCategoryDetail'));
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
        $helpCategoryDetail = HelpCategory::findOrFail($id);

        $request->validate([
            'icon' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $helpCategoryDetail->update([
            'icon' => $request->icon,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'description' => $request->description
        ]);

        return redirect()->back()->with('success', 'Help category has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $helpCategoryDetail = HelpCategory::findOrFail($id);
        $helpCategoryDetail->delete();
        return redirect()->route('admin.help-categories')->with('success', 'Help category has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|in:active,inactive'
        ]);
        $helpCategory = HelpCategory::findOrFail($id);
        if($request->status == 'active')
            $status = 1;
        else
            $status = 0;

        $helpCategory->status = $status;
        $helpCategory->save();
        return response()->json(['success' => true]);
    }

}