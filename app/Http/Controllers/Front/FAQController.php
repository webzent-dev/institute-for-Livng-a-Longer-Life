<?php

namespace App\Http\Controllers\Front;
use App\Models\FaqCategory;
use App\Models\PageContent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
class FAQController extends Controller
{
     
    public function index()
    {
        $faqs = FaqCategory::with(['faqs' => function ($q) {
            $q->where('status', true);
        }])->get()->map(function ($category) {
            return [
                'category' => $category->name,
                'questions' => $category->faqs->map(function ($faq) {
                    return [
                        'q' => $faq->question, 
                        'a' => $faq->answer, 
                    ];
                })->toArray(),
            ];
        })->toArray();

        $sections = PageContent::sections('faq');

        return view('front.pages.faq', compact('faqs', 'sections'));
    }
    public function create()
    {
         
    }

    public function store(Request $request)
    {
        
    }

     
    public function show(string $id)
    {
        
    }

     
    public function edit(string $id)
    {
         
    }
 
    public function update(Request $request, string $id)
    {
         
    }

     
    public function destroy(string $id)
    {
         
    }
}
