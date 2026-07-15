<?php

namespace App\Support;

use App\Services\Pricing\VitalBoostPricingService;
use Illuminate\Support\Facades\Session;

/**
 * Per-line purchase metadata (one-time vs monthly/yearly subscription) for the
 * session cart.
 *
 * The cart itself stays [productId => qty] so every existing consumer
 * (ShippingService, sub-orders, totals) keeps working unchanged; the purchase
 * type lives here in a parallel session bag keyed by product id.
 */
class CartPurchaseMeta
{
    public const SESSION_KEY = 'cart_meta';

    /** @return array<int, array{purchase_type:string, plan:?string}> */
    public static function all(): array
    {
        return Session::get(self::SESSION_KEY, []);
    }

    /**
     * Normalised meta for a product line. Defaults to a one-time purchase.
     *
     * @return array{purchase_type:string, plan:?string}
     */
    public static function for(int $productId): array
    {
        $meta = self::all()[$productId] ?? null;

        return [
            'purchase_type' => $meta['purchase_type'] ?? VitalBoostPricingService::TYPE_ONE_TIME,
            'plan'          => $meta['plan'] ?? null,
        ];
    }

    /**
     * Store the buyer's choice for a line. Anything that isn't a valid
     * subscription is normalised to a one-time purchase.
     */
    public static function put(int $productId, ?string $purchaseType, ?string $plan): void
    {
        $meta = self::all();

        if ($purchaseType === VitalBoostPricingService::TYPE_SUBSCRIPTION
            && in_array($plan, [VitalBoostPricingService::PLAN_MONTHLY, VitalBoostPricingService::PLAN_YEARLY], true)) {
            $meta[$productId] = [
                'purchase_type' => VitalBoostPricingService::TYPE_SUBSCRIPTION,
                'plan'          => $plan,
            ];
        } else {
            // One-time: no need to keep a row around.
            unset($meta[$productId]);
        }

        Session::put(self::SESSION_KEY, $meta);
    }

    public static function forget(int $productId): void
    {
        $meta = self::all();
        unset($meta[$productId]);
        Session::put(self::SESSION_KEY, $meta);
    }

    public static function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }

    public static function isSubscription(int $productId): bool
    {
        return self::for($productId)['purchase_type'] === VitalBoostPricingService::TYPE_SUBSCRIPTION;
    }

    public static function isYearlySubscription(int $productId): bool
    {
        $meta = self::for($productId);

        return $meta['purchase_type'] === VitalBoostPricingService::TYPE_SUBSCRIPTION
            && $meta['plan'] === VitalBoostPricingService::PLAN_YEARLY;
    }
}
