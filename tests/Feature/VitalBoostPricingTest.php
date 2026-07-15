<?php

namespace Tests\Feature;

use App\Services\Pricing\VitalBoostPricingService;
use Tests\TestCase;

class VitalBoostPricingTest extends TestCase
{
    private VitalBoostPricingService $svc;

    protected function setUp(): void
    {
        parent::setUp();

        // Pin subscription/shipping config so the test is deterministic regardless of .env.
        // (The member discount % is supplied to the service directly — it's resolved from
        // the membership record by callers, not by the pricing service.)
        config()->set('vital_boost.subscription_discounts', ['monthly' => 15, 'yearly' => 15]);
        config()->set('vital_boost.shipping.free_for_yearly', true);

        $this->svc = new VitalBoostPricingService();
    }

    public function test_normal_purchase_adds_shipping_and_no_discount(): void
    {
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, 0.0, 10);

        $this->assertSame(0.0, $b->membershipDiscount);
        $this->assertSame(0.0, $b->subscriptionDiscount);
        $this->assertSame(10.0, $b->shipping);
        $this->assertSame(110.0, $b->total);
    }

    public function test_member_one_time_gets_membership_discount(): void
    {
        // Standard plan = 5% (supplied by the caller).
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, 5.0, 10);

        $this->assertSame(5.0, $b->membershipPercent);
        $this->assertSame(5.0, $b->membershipDiscount);
        $this->assertSame(105.0, $b->total);
    }

    public function test_subscription_monthly_non_member_keeps_shipping(): void
    {
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, 0.0, 10);

        $this->assertSame(15.0, $b->subscriptionDiscount);
        $this->assertFalse($b->shippingWaived);
        $this->assertSame(95.0, $b->total);
    }

    public function test_subscription_yearly_ships_free(): void
    {
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 0.0, 10);

        $this->assertTrue($b->shippingWaived);
        $this->assertSame(0.0, $b->shipping);
        $this->assertSame(85.0, $b->total);
    }

    public function test_discounts_stack_membership_then_subscription(): void
    {
        // Premium (10%) then yearly subscription (15%) on the reduced total, free shipping.
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 10.0, 10);

        $this->assertSame(10.0, $b->membershipDiscount);   // 10% of 100
        $this->assertSame(13.5, $b->subscriptionDiscount); // 15% of 90
        $this->assertSame(76.5, $b->total);
    }

    public function test_zero_percent_yields_no_membership_discount(): void
    {
        // e.g. a Gold plan set to 0%, or an expired/absent membership (caller passes 0).
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, 0.0, 10);

        $this->assertSame(0.0, $b->membershipDiscount);
        $this->assertSame(110.0, $b->total);
    }

    public function test_quantity_multiplies_base(): void
    {
        $b = $this->svc->calculate(50, 3, VitalBoostPricingService::TYPE_ONE_TIME, null, 0.0, 0);

        $this->assertSame(150.0, $b->base);
        $this->assertSame(150.0, $b->total);
    }
}
