<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HelpCategory;
use App\Models\HelpArticle;
use Illuminate\Support\Str;

class AdminHelpArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $helpArticles = HelpArticle::with('category')->get();

        //Get help categories
        $helpCategories = HelpCategory::all();

        return view('admin.help_articles.index', compact('helpArticles', 'helpCategories'));
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
            'help_category_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $helpArticle = HelpArticle::create([
            'help_category_id' => $request->help_category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Help article has been created successfully.'); 
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $helpArticleDetail = HelpArticle::findOrFail($id);

        //Get help categories
        $helpCategories = HelpCategory::all();

        return view('admin.help_articles.show', compact('helpArticleDetail', 'helpCategories'));
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
        $helpArticleDetail = HelpArticle::findOrFail($id);

        $request->validate([
            'help_category_id' => 'required',
            'title' => 'required',
            'content' => 'required'
        ]);

        $helpArticleDetail->update([
            'help_category_id' => $request->help_category_id,
            'title' => $request->title,
            'slug' => Str::slug($request->title, '-'),
            'content' => $request->content,
        ]);

        return redirect()->back()->with('success', 'Help article has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $helpArticleDetail = HelpArticle::findOrFail($id);
        $helpArticleDetail->delete();
        return redirect()->route('admin.help-articles')->with('success', 'Help article has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'is_active' => 'required|in:active,inactive'
        ]);
        $helpArticle = HelpArticle::findOrFail($id);
        if($request->status == 'active')
            $status = 1;
        else
            $status = 0;

        $helpArticle->status = $status;
        $helpArticle->save();
        return response()->json(['success' => true]);
    }

}