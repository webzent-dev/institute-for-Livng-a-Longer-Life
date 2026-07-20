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

    public function test_member_gets_membership_discount_only_no_subscription_clubbing(): void
    {
        // Discounts are NOT clubbed for members: a member (10%) on a yearly Vital
        // Boost subscription gets their membership discount only, no subscription
        // discount on top. Yearly still ships free.
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 10.0, 10);

        $this->assertSame(10.0, $b->membershipDiscount);   // 10% of 100
        $this->assertSame(0.0, $b->subscriptionPercent);   // no subscription discount for members
        $this->assertSame(0.0, $b->subscriptionDiscount);
        $this->assertTrue($b->shippingWaived);
        $this->assertSame(90.0, $b->total);                // 100 - 10, free shipping
    }

    public function test_zero_percent_yields_no_membership_discount(): void
    {
        // e.g. a Gold plan set to 0%, or an expired/absent membership (caller passes 0).
        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_ONE_TIME, null, 0.0, 10);

        $this->assertSame(0.0, $b->membershipDiscount);
        $this->assertSame(110.0, $b->total);
    }

    public function test_guest_subscription_uses_per_plan_rate(): void
    {
        // Guests (no membership) get the per-plan rate: 2% monthly, 5% yearly.
        config()->set('vital_boost.subscription_discounts', ['monthly' => 2, 'yearly' => 5, 'member' => 15]);

        $monthly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, 0.0, 10);
        $this->assertSame(2.0, $monthly->subscriptionPercent);
        $this->assertSame(2.0, $monthly->subscriptionDiscount);

        $yearly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 0.0, 0);
        $this->assertSame(5.0, $yearly->subscriptionPercent);
        $this->assertSame(5.0, $yearly->subscriptionDiscount);
    }

    public function test_member_gets_no_subscription_discount(): void
    {
        // Discounts are not clubbed: members never receive the guest 2%/5%
        // subscription discount — only their membership discount applies.
        config()->set('vital_boost.subscription_discounts', ['monthly' => 2, 'yearly' => 5]);

        $b = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, 10.0, 10);
        $this->assertSame(0.0, $b->subscriptionPercent);
        $this->assertSame(0.0, $b->subscriptionDiscount);
        $this->assertSame(10.0, $b->membershipDiscount);
    }

    public function test_quantity_multiplies_base(): void
    {
        $b = $this->svc->calculate(50, 3, VitalBoostPricingService::TYPE_ONE_TIME, null, 0.0, 0);

        $this->assertSame(150.0, $b->base);
        $this->assertSame(150.0, $b->total);
    }

    /**
     * The shop page builds its perk line from these two payload keys, so a
     * yearly plan has to advertise the discount AND the free shipping together
     * — showing only one of them understates the offer.
     */
    public function test_yearly_payload_exposes_both_the_discount_and_free_shipping(): void
    {
        config()->set('vital_boost.subscription_discounts', ['monthly' => 2, 'yearly' => 5]);
        config()->set('vital_boost.shipping.free_for_yearly', true);

        $yearly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 0.0, 9.99)->toArray();

        $this->assertSame(5.0, $yearly['subscription_percent']);
        $this->assertTrue($yearly['shipping_waived']);
        $this->assertSame(95.0, $yearly['total']);

        $monthly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_MONTHLY, 0.0, 9.99)->toArray();

        $this->assertSame(2.0, $monthly['subscription_percent']);
        $this->assertFalse($monthly['shipping_waived']);
    }

    public function test_a_member_sees_free_shipping_on_yearly_but_no_subscription_percent(): void
    {
        config()->set('vital_boost.subscription_discounts', ['monthly' => 2, 'yearly' => 5]);
        config()->set('vital_boost.shipping.free_for_yearly', true);

        $yearly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 10.0, 9.99)->toArray();

        // Discounts are not clubbed, so the perk line must not promise a 5% saving
        // a member does not actually receive.
        $this->assertSame(0.0, $yearly['subscription_percent']);
        $this->assertTrue($yearly['shipping_waived']);
        $this->assertSame(90.0, $yearly['total']);
    }

    public function test_free_shipping_can_be_switched_off_for_yearly(): void
    {
        config()->set('vital_boost.shipping.free_for_yearly', false);

        $yearly = $this->svc->calculate(100, 1, VitalBoostPricingService::TYPE_SUBSCRIPTION, VitalBoostPricingService::PLAN_YEARLY, 0.0, 9.99)->toArray();

        // The perk line reads shipping_waived rather than assuming yearly is
        // always free, so turning the rule off removes the claim too.
        $this->assertFalse($yearly['shipping_waived']);
    }
}
