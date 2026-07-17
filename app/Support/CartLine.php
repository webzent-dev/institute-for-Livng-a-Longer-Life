<?php

namespace App\Support;

use App\Services\Pricing\VitalBoostPricingService;

/**
 * Encodes a cart line's identity into a single session-cart key so the same
 * product can appear as several independent lines (e.g. Vital Boost bought
 * one-time, monthly and yearly all at once).
 *
 * The cart session stays a flat [lineKey => quantity] map — every existing
 * consumer (array_sum for the count, per-line quantities) keeps working — but
 * the key now carries the purchase type/plan:
 *
 *   "67"          → product 67, one-time
 *   "67:monthly"  → product 67, monthly subscription
 *   "67:yearly"   → product 67, yearly subscription
 *
 * A bare numeric key (the legacy format) parses as a one-time line, so old
 * sessions remain valid.
 */
class CartLine
{
    private const SUBSCRIPTION_PLANS = [
        VitalBoostPricingService::PLAN_MONTHLY,
        VitalBoostPricingService::PLAN_YEARLY,
    ];

    /**
     * Build the cart key for a product + purchase choice. Anything that is not a
     * valid subscription collapses to the plain product-id (one-time) key.
     */
    public static function key(int $productId, ?string $purchaseType, ?string $plan): string
    {
        if ($purchaseType === VitalBoostPricingService::TYPE_SUBSCRIPTION
            && in_array($plan, self::SUBSCRIPTION_PLANS, true)) {
            return $productId . ':' . $plan;
        }

        return (string) $productId;
    }

    /**
     * Product id for a line key (works for both "67" and "67:monthly").
     */
    public static function productId(int|string $lineKey): int
    {
        return (int) explode(':', (string) $lineKey)[0];
    }

    /**
     * Purchase metadata for a line key.
     *
     * @return array{purchase_type:string, plan:?string}
     */
    public static function meta(int|string $lineKey): array
    {
        $parts = explode(':', (string) $lineKey);
        $plan  = $parts[1] ?? null;

        $isSubscription = in_array($plan, self::SUBSCRIPTION_PLANS, true);

        return [
            'purchase_type' => $isSubscription
                ? VitalBoostPricingService::TYPE_SUBSCRIPTION
                : VitalBoostPricingService::TYPE_ONE_TIME,
            'plan' => $isSubscription ? $plan : null,
        ];
    }

    /**
     * Human-readable label for a purchase choice, shown next to a cart line so
     * the buyer can tell the three lines apart.
     */
    public static function label(?string $purchaseType, ?string $plan): string
    {
        if ($purchaseType === VitalBoostPricingService::TYPE_SUBSCRIPTION) {
            return $plan === VitalBoostPricingService::PLAN_YEARLY
                ? 'Yearly subscription'
                : 'Monthly subscription';
        }

        return 'One-time purchase';
    }
}
