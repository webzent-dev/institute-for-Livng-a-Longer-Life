<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Membership discount
    |--------------------------------------------------------------------------
    |
    | The member discount percentage is NOT configured here — it is defined per
    | plan on the memberships table (memberships.discount_percent), editable from
    | the admin "Manage Membership" screen, and resolved via
    | App\Support\MembershipDiscount. This lets each plan (Gold, Standard,
    | Lifetime, or any new plan) carry its own percentage.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Subscription discounts (percentage off)
    |--------------------------------------------------------------------------
    |
    | Additional discount for Vital Boost subscription purchases, applied AFTER
    | the membership discount (per the pricing calculation order). Available to
    | members and non-members alike.
    |
    */
    'subscription_discounts' => [
        'monthly' => (float) env('VB_SUBSCRIPTION_DISCOUNT_MONTHLY', 15),
        'yearly'  => (float) env('VB_SUBSCRIPTION_DISCOUNT_YEARLY', 15),
    ],

    /*
    |--------------------------------------------------------------------------
    | Shipping rules
    |--------------------------------------------------------------------------
    |
    | Shipping applies to normal purchases, member purchases and monthly
    | subscriptions. Yearly subscriptions ship free when this flag is true.
    |
    */
    'shipping' => [
        'free_for_yearly' => (bool) env('VB_YEARLY_FREE_SHIPPING', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Subscription billing periods (days)
    |--------------------------------------------------------------------------
    |
    | Used later (Phase 4) to set the next_billing date, mirroring the
    | membership one-time-per-period model.
    |
    */
    'billing_period_days' => [
        'monthly' => (int) env('VB_MONTHLY_PERIOD_DAYS', 30),
        'yearly'  => (int) env('VB_YEARLY_PERIOD_DAYS', 365),
    ],

];
