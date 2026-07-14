<?php

namespace App\Http\Controllers\Front;
use App\Models\Stat;
use App\Models\VideoTestimonial;
use App\Models\Testimonial;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PageContent;

class TestimonialsController extends Controller
{
    public function index()
    {
        $videoTestimonials = VideoTestimonial::where('is_active', true) ->orderBy('sort_order')->get() ->map(function ($item) {
            return [
                'id' => $item->id,
                'videoUrl' => $item->video_url,
                'thumbnail' => env('APP_URL') . 'testimonial_images/'.$item->thumbnail,
                'quote' => $item->quote,
                'name' => $item->name,
            ];
        });
        $stats = Stat::where('is_active', true)->get();
        $testimonials = Testimonial::where('is_active', true)->orderBy('sort_order')->paginate(3);
        $sections = PageContent::sections('testimonials');

        return view('front.pages.testimonials', compact('stats', 'videoTestimonials', 'testimonials', 'sections'));
    }
 
}