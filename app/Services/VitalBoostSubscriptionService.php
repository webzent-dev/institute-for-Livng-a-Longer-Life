<?php

namespace App\Services;

use App\Models\VitalBoostSubscription;
use Carbon\Carbon;

/**
 * Status changes on a member's recurring Vital Boost product subscription.
 *
 * The status column is an enum of active / cancelled / expired, so those are the
 * only states this service will put a subscription into.
 */
class VitalBoostSubscriptionService
{
    /**
     * Stop billing a subscription. The member keeps whatever they already paid for.
     *
     * @return array{ok: bool, message: string}
     */
    public function cancel(VitalBoostSubscription $subscription): array
    {
        if ($subscription->status === 'cancelled') {
            return ['ok' => false, 'message' => 'This subscription is already cancelled.'];
        }

        $subscription->update([
            'status' => 'cancelled',
            // Clearing the next billing date keeps the renewal job from ever
            // picking this row up again.
            'next_billing_at' => null,
        ]);

        return ['ok' => true, 'message' => 'Vital Boost subscription cancelled. No further charges will be made.'];
    }

    /**
     * Put a cancelled subscription back into billing.
     *
     * An expired subscription cannot simply be switched back on — the member has
     * to buy it again so the price and plan are re-agreed.
     *
     * @return array{ok: bool, message: string}
     */
    public function resume(VitalBoostSubscription $subscription): array
    {
        if ($subscription->status === 'active') {
            return ['ok' => false, 'message' => 'This subscription is already active.'];
        }

        if ($subscription->status === 'expired') {
            return ['ok' => false, 'message' => 'An expired subscription cannot be resumed — the member needs to purchase it again.'];
        }

        $nextBilling = $this->nextBillingDate($subscription);

        $subscription->update([
            'status' => 'active',
            'next_billing_at' => $nextBilling,
        ]);

        return [
            'ok' => true,
            'message' => 'Vital Boost subscription resumed. Next billing ' . $nextBilling->format('M j, Y') . '.',
        ];
    }

    /**
     * When a resumed subscription should next be billed.
     *
     * Billing restarts one full period from today rather than from the original
     * date, so a member resuming after a long gap is not charged immediately for
     * the months they were cancelled.
     */
    private function nextBillingDate(VitalBoostSubscription $subscription): Carbon
    {
        return $subscription->plan === 'yearly'
            ? Carbon::now()->addYear()
            : Carbon::now()->addMonth();
    }
}
