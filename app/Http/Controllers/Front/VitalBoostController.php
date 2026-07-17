<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use App\Models\VitalBoostContent;

class VitalBoostController extends Controller
{
    public function index()
    {
        // Informational page only — the Vital Boost product is listed and purchased
        // from the shop (/shop), so no product/pricing is loaded here anymore.
        // Keyed by section_key (hero, benefits, booster, usage, cta). The view falls back
        // to its built-in copy for any section that is missing or deactivated.
        $sections = VitalBoostContent::sections();

        return view('front.pages.vital-boost', compact('sections'));
    }

}
