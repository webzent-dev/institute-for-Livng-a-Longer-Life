<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VitalBoostContent;

class VitalBoostController extends Controller
{
    public function index()
    {
        $product = Product::where('product_type', 'vital_boost')->where('status', 'active')->first();

        // Keyed by section_key (hero, benefits, booster, usage, cta). The view falls back
        // to its built-in copy for any section that is missing or deactivated.
        $sections = VitalBoostContent::sections();
        

        return view('front.pages.vital-boost', compact('product', 'sections'));
    }

}
