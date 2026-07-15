<?php

namespace App\Http\Controllers\Front;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\VitalBoostContent;
use App\Services\Pricing\VitalBoostPricingService;

class VitalBoostController extends Controller
{
    public function __construct(private VitalBoostPricingService $pricing)
    {
    }

    public function index()
    {
        $product = Product::where('product_type', 'vital_boost')->where('status', 'active')->first();

        // Keyed by section_key (hero, benefits, booster, usage, cta). The view falls back
        // to its built-in copy for any section that is missing or deactivated.
        $sections = VitalBoostContent::sections();

        // Pre-compute the price breakdown for each purchase option so the product page
        // can show live, member-aware numbers driven by the central pricing service.
        // Shipping is passed as 0 here (unknown until checkout); the view shows a
        // shipping note instead of a figure. Yearly is flagged free-shipping.
        $pricing = null;
        if ($product) {
            $memberPercent = \App\Support\MembershipDiscount::activePercentFor(auth()->user());
            $pricing = [
                'one_time' => $this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, $memberPercent, 0
                )->toArray(),
                'monthly' => $this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, $memberPercent, 0
                )->toArray(),
                'yearly' => $this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, $memberPercent, 0
                )->toArray(),
            ];
        }

        return view('front.pages.vital-boost', compact('product', 'sections', 'pricing'));
    }

}
