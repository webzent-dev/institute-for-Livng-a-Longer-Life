<?php

namespace App\Services;

use Stripe\Stripe;

class StripeService
{
    /**
     * Set the Stripe API key from config.
     *
     * The active secret is always STRIPE_SECRET in .env.
     * Set STRIPE_MODE=sandbox or STRIPE_MODE=live to document which
     * environment is active; the deployment is responsible for placing
     * the correct key in STRIPE_SECRET for that mode.
     */
    public static function configure(): void
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }
}
