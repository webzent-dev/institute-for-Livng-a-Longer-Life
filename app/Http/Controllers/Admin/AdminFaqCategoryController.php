<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FaqCategory;
use Illuminate\Database\QueryException;

class AdminFaqCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqCategories = FaqCategory::paginate(10);
        return view('admin.faq_categories.index', compact('faqCategories'));
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
            'name' => 'required|string|max:255'
        ]);

        $category = FaqCategory::create([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'FAQ category has been created successfully.');

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
        $faqCategoryDetail = FaqCategory::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $faqCategoryDetail->update([
            'name' => $request->name
        ]);

        return redirect()->back()->with('success', 'FAQ category has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $faqCategoryDetail = FaqCategory::findOrFail($id);
            $faqCategoryDetail->delete();
            return redirect()->route('admin.faq-categories')->with('success', 'FAQ category has been deleted successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'Unable to delete FAQ category because it is associated with other records. Please try again...!!!');
        }
    }

    /**
     * Update FAQ Category information.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
    */
    public function updateFAQCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $faqCategoryDetail = FaqCategory::findOrFail($request->faq_category_id);
        $faqCategoryDetail->update([
            'name' => $request->name
        ]);
    
        return redirect()->back()->with('success', 'FAQ category has been updated successfully.');
    }

}