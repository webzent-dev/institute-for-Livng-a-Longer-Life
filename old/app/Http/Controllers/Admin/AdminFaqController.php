<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Faq;
use App\Models\FaqCategory;


class AdminFaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //GET FAQs with category detail and use with query
        $faqs = Faq::with('category')->get();
        
        //FAQ Categories
        $faqCategories = FaqCategory::all();

        return view('admin.faqs.index', compact('faqs', 'faqCategories'));
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
            'faq_category_id' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        Faq::create([
            'faq_category_id' => $request->faq_category_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => 1
        ]);

        return redirect()->back()->with('success', 'FAQ has been added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $faqDetail = Faq::find($id);

        //FAQ Categories
        $faqCategories = FaqCategory::all();

        return view('admin.faqs.show', compact('faqDetail', 'faqCategories'));
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
        $faqDetail = Faq::findOrFail($id);

        $request->validate([
            'faq_category_id' => 'required',
            'question' => 'required',
            'answer' => 'required'
        ]);

        $faqDetail->update([
            'faq_category_id' => $request->faq_category_id,
            'question' => $request->question,
            'answer' => $request->answer,
            'status' => $request->status
        ]);

        return redirect()->back()->with('success', 'FAQ has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $faqDetail = Faq::findOrFail($id);
        $faqDetail->delete();
        return redirect()->route('admin.faqs')->with('success', 'FAQ has been deleted successfully.');
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive'
        ]);
        $faq = Faq::findOrFail($id);
        if($request->status == 'active')
            $status = 1;
        else
            $status = 0;

        $faq->status = $status;
        $faq->save();
        return response()->json(['success' => true]);
    }

}
