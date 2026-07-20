<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\User;
use App\Models\PageContent;
use App\Services\Pricing\VitalBoostPricingService;
use App\Support\MembershipDiscount;
use App\Support\VitalBoostPerks;

class ShopController extends Controller
{
    public function __construct(private VitalBoostPricingService $pricing)
    {
    }

    public function index()
    {
        $products = Product::with('user')
        ->whereIn('category',['collaborator','institute','vital_boost'])
        ->whereIn('product_type',['supplement','guide','book','vital_boost'])
        ->where('status', 'active')
        ->where(function($query) {
            // Institute + Vital Boost products are always shown; collaborator products
            // only while their seller is active. Vital Boost is available in the common
            // store for everyone at its actual price (non-members pay full price).
            $query->whereIn('category', ['institute', 'vital_boost'])
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('status', 'active');
                  });
        })
        ->get();
        
        // Get active collaborators for dropdown
        $collaborators = User::where('role', 'collaborator')
                            ->where('status', 'active')
                            ->select('id', 'first_name', 'last_name')
                            ->get();

        // Keyed by section_key (hero, member_benefits). The view falls back to its
        // built-in copy for any section that is missing or deactivated.
        $sections = PageContent::sections('shop');

        // Member-aware price breakdowns for the Vital Boost purchase-type selector
        // rendered on the shop card. Keyed by product id.
        $vitalBoostPricing = $this->vitalBoostPricing($products);

        return view('front.pages.shop', compact('products', 'collaborators', 'sections', 'vitalBoostPricing'));
    }

    public function filter(Request $request)
    {
        $search = $request->search;
        $category = $request->category;
        $products = Product::whereIn('category', ['collaborator', 'institute', 'vital_boost'])
        ->when($search, function($q) use ($search) {
            $q->where('name', 'like', "%$search%");
        })
        ->when($category, function($q) use ($category) {
            $q->where('category', $category);
        })
        ->where('status', 'active')
        ->where(function($query) {
            $query->whereIn('category', ['institute', 'vital_boost'])
                  ->orWhereHas('user', function($userQuery) {
                      $userQuery->where('status', 'active');
                  });
        })
        ->get();
        
        // Get active collaborators for dropdown
        $collaborators = User::where('role', 'collaborator')
                            ->where('status', 'active')
                            ->select('id', 'first_name', 'last_name')
                            ->get();

        $sections = PageContent::sections('shop');

        $vitalBoostPricing = $this->vitalBoostPricing($products);

        return view('front.pages.shop', compact('products', 'collaborators', 'sections', 'vitalBoostPricing'));
    }

    /**
     * Build member-aware price breakdowns for every Vital Boost product in the given
     * collection, keyed by product id, with one_time / monthly / yearly options.
     * Non-Vital-Boost products are skipped. Shipping is 0 here (resolved at checkout).
     */
    private function vitalBoostPricing($products): array
    {
        $memberPercent = MembershipDiscount::activePercentFor(auth()->user());
        $map = [];

        foreach ($products as $product) {
            if (! $this->pricing->isVitalBoost($product)) {
                continue;
            }

            $map[$product->id] = [
                'one_time' => $this->withPerkLabel($this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, $memberPercent, 0
                )->toArray()),
                'monthly' => $this->withPerkLabel($this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, $memberPercent, 0
                )->toArray()),
                'yearly' => $this->withPerkLabel($this->pricing->forProduct(
                    $product, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, $memberPercent, 0
                )->toArray()),
            ];
        }

        return $map;
    }

    /**
     * Attach the shopper-facing perk caption to a pricing breakdown.
     *
     * Done server-side so the shop grid and the product detail page cannot word
     * the same offer differently.
     *
     * @param  array<string, mixed> $breakdown
     * @return array<string, mixed>
     */
    private function withPerkLabel(array $breakdown): array
    {
        $breakdown['perk_label'] = VitalBoostPerks::label($breakdown);

        return $breakdown;
    }

    public function productDetails($slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return redirect()->route('shop')->with('error', 'Product not found.');
        }

        // Vital Boost sells on three plans, so the detail page needs the same
        // priced options the shop grid shows. Non-Vital-Boost products get an
        // empty map and keep the plain Add to Cart button.
        $vitalBoostPricing = $this->vitalBoostPricing(collect([$product]));

        return view('front.pages.product-details', compact('product', 'vitalBoostPricing'));
    }

}