<?php

namespace App\Services\Pricing;

/**
 * Immutable value object describing a Vital Boost price calculation. Returned by
 * VitalBoostPricingService and reused across the product page, cart, checkout,
 * orders and subscriptions so every surface shows the same numbers.
 */
class PricingBreakdown implements \JsonSerializable
{
    public function __construct(
        public readonly float $unitPrice,
        public readonly int $quantity,
        public readonly float $base,               // unitPrice * quantity
        public readonly string $purchaseType,      // one_time | subscription
        public readonly ?string $plan,             // monthly | yearly | null
        public readonly float $membershipPercent,
        public readonly float $membershipDiscount,
        public readonly float $subscriptionPercent,
        public readonly float $subscriptionDiscount,
        public readonly float $shipping,
        public readonly bool $shippingWaived,
        public readonly float $total,              // final payable amount
    ) {
    }

    /** Combined discount from membership + subscription. */
    public function discountTotal(): float
    {
        return round($this->membershipDiscount + $this->subscriptionDiscount, 2);
    }

    /** Item total after all discounts, before shipping. */
    public function subtotalAfterDiscounts(): float
    {
        return round($this->base - $this->discountTotal(), 2);
    }

    public function toArray(): array
    {
        return [
            'unit_price'             => $this->unitPrice,
            'quantity'               => $this->quantity,
            'base'                   => $this->base,
            'purchase_type'          => $this->purchaseType,
            'plan'                   => $this->plan,
            'membership_percent'     => $this->membershipPercent,
            'membership_discount'    => $this->membershipDiscount,
            'subscription_percent'   => $this->subscriptionPercent,
            'subscription_discount'  => $this->subscriptionDiscount,
            'discount_total'         => $this->discountTotal(),
            'subtotal_after_discounts' => $this->subtotalAfterDiscounts(),
            'shipping'               => $this->shipping,
            'shipping_waived'        => $this->shippingWaived,
            'total'                  => $this->total,
        ];
    }

    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
