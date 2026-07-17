<?php

namespace App\Services\Pricing;

use App\Models\Product;

/**
 * Centralised pricing for Vital Boost products.
 *
 * Applies the business calculation order:
 *   1. Start with product price (unit * quantity).
 *   2. Apply membership discount (active members only).
 *   3. Apply subscription discount (subscription purchases only).
 *   4. Apply shipping unless the subscription is yearly.
 *   5. Return the final payable amount with a full breakdown.
 *
 * Non-Vital-Boost products are out of scope; callers should gate on isVitalBoost().
 */
class VitalBoostPricingService
{
    public const TYPE_ONE_TIME     = 'one_time';
    public const TYPE_SUBSCRIPTION = 'subscription';

    public const PLAN_MONTHLY = 'monthly';
    public const PLAN_YEARLY  = 'yearly';

    public function isVitalBoost(Product $product): bool
    {
        return $product->product_type === 'vital_boost';
    }

    /**
     * Convenience wrapper that reads the unit price from a Product.
     */
    public function forProduct(
        Product $product,
        int $quantity = 1,
        string $purchaseType = self::TYPE_ONE_TIME,
        ?string $plan = null,
        float $membershipPercent = 0.0,
        float $shippingCost = 0.0
    ): PricingBreakdown {
        return $this->calculate(
            (float) $product->price,
            $quantity,
            $purchaseType,
            $plan,
            $membershipPercent,
            $shippingCost
        );
    }

    /**
     * Calculate the price breakdown for a single Vital Boost line.
     *
     * @param  float        $unitPrice     Product unit price.
     * @param  int          $quantity      Quantity purchased.
     * @param  string       $purchaseType      self::TYPE_ONE_TIME | self::TYPE_SUBSCRIPTION
     * @param  string|null  $plan              self::PLAN_MONTHLY | self::PLAN_YEARLY (subscriptions only)
     * @param  float        $membershipPercent The buyer's active member discount % (0 for non-members/guests).
     *                                          Resolve via App\Support\MembershipDiscount::activePercentFor().
     * @param  float        $shippingCost      Shipping that would otherwise apply to this line/context
     */
    public function calculate(
        float $unitPrice,
        int $quantity = 1,
        string $purchaseType = self::TYPE_ONE_TIME,
        ?string $plan = null,
        float $membershipPercent = 0.0,
        float $shippingCost = 0.0
    ): PricingBreakdown {
        $purchaseType = $this->normalizePurchaseType($purchaseType);
        $plan         = $purchaseType === self::TYPE_SUBSCRIPTION ? $this->normalizePlan($plan) : null;
        $quantity     = max(1, $quantity);
        $unitPrice    = max(0.0, $unitPrice);

        // 1. Base price
        $base = round($unitPrice * $quantity, 2);

        // 2. Membership discount (active members only; percentage supplied by caller)
        $membershipPercent  = max(0.0, $membershipPercent);
        $membershipDiscount = round($base * $membershipPercent / 100, 2);
        $afterMembership    = round($base - $membershipDiscount, 2);

        // 3. Subscription discount (subscription purchases only). Discounts are not
        //    clubbed: only guests get the subscription discount. Active members (a
        //    non-zero membership percent) receive their membership discount only.
        $isMember = $membershipPercent > 0;
        $subscriptionPercent  = $purchaseType === self::TYPE_SUBSCRIPTION
            ? $this->subscriptionPercent($plan, $isMember)
            : 0.0;
        $subscriptionDiscount = round($afterMembership * $subscriptionPercent / 100, 2);
        $afterSubscription    = round($afterMembership - $subscriptionDiscount, 2);

        // 4. Shipping — waived for yearly subscriptions.
        $shippingWaived = $this->shippingWaived($purchaseType, $plan);
        $shipping       = $shippingWaived ? 0.0 : round(max(0.0, $shippingCost), 2);

        // 5. Final payable amount.
        $total = round($afterSubscription + $shipping, 2);

        return new PricingBreakdown(
            unitPrice: $unitPrice,
            quantity: $quantity,
            base: $base,
            purchaseType: $purchaseType,
            plan: $plan,
            membershipPercent: $membershipPercent,
            membershipDiscount: $membershipDiscount,
            subscriptionPercent: $subscriptionPercent,
            subscriptionDiscount: $subscriptionDiscount,
            shipping: $shipping,
            shippingWaived: $shippingWaived,
            total: $total,
        );
    }

    /**
     * Subscription discount percentage from config. Discounts are not clubbed:
     * only guests receive the per-plan (monthly/yearly) subscription discount;
     * active members receive their membership discount only (0 here).
     */
    public function subscriptionPercent(?string $plan, bool $isMember = false): float
    {
        if ($plan === null || $isMember) {
            return 0.0;
        }

        return (float) (config('vital_boost.subscription_discounts.' . $plan, 0));
    }

    /**
     * Shipping is waived only for yearly subscriptions, and only when enabled.
     */
    public function shippingWaived(string $purchaseType, ?string $plan): bool
    {
        return $purchaseType === self::TYPE_SUBSCRIPTION
            && $plan === self::PLAN_YEARLY
            && (bool) config('vital_boost.shipping.free_for_yearly', true);
    }

    private function normalizePurchaseType(string $purchaseType): string
    {
        return $purchaseType === self::TYPE_SUBSCRIPTION
            ? self::TYPE_SUBSCRIPTION
            : self::TYPE_ONE_TIME;
    }

    private function normalizePlan(?string $plan): string
    {
        return $plan === self::PLAN_YEARLY ? self::PLAN_YEARLY : self::PLAN_MONTHLY;
    }
}
