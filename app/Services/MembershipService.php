<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;

/**
 * Membership actions that are identical whether a member performs them on
 * themselves or an admin performs them on the member's behalf.
 *
 * MemberController and AdminMemberController both call through here, so the
 * business rules (benefits run to expiry, lifetime never renews, cancelling
 * only stops the next charge) live in exactly one place.
 *
 * Every result carries a `code` alongside `message`. The message is written in
 * the third person for the admin panel; the member dashboard keeps its own
 * second-person copy by switching on the code, so members read the same wording
 * they always have.
 */
class MembershipService
{
    /**
     * Cancel the membership.
     *
     * Benefits carry on until plan_expiry — the member already paid for that
     * period. Cancelling only stops the next automatic charge.
     *
     * @return array{ok: bool, code: string, message: string, expiry: ?string}
     */
    public function cancel(User $user): array
    {
        if (!($user->plan_id > 0)) {
            return ['ok' => false, 'code' => 'no_plan', 'message' => 'There is no membership to cancel.'];
        }

        if ($user->membershipIsCancelled()) {
            return ['ok' => false, 'code' => 'already_cancelled', 'message' => 'This membership is already cancelled.'];
        }

        $user->update([
            'auto_renew' => false,
            'membership_cancelled_at' => Carbon::now(),
        ]);

        $expiry = $user->plan_expiry
            ? Carbon::parse($user->plan_expiry)->format('M j, Y')
            : null;

        return [
            'ok' => true,
            'code' => 'cancelled',
            'expiry' => $expiry,
            'message' => $expiry
                ? "Membership cancelled. Benefits continue until {$expiry}, and no further charges will be made."
                : 'Membership cancelled. No further charges will be made.',
        ];
    }

    /**
     * Undo a cancellation and put automatic renewal back on.
     *
     * @return array{ok: bool, code: string, message: string}
     */
    public function resume(User $user): array
    {
        if (!$user->membershipIsCancelled()) {
            return ['ok' => false, 'code' => 'not_cancelled', 'message' => 'This membership is not cancelled.'];
        }

        $user->update([
            'membership_cancelled_at' => null,
            'auto_renew' => true,
        ]);

        if (!$this->hasSavedCard($user)) {
            return [
                'ok' => true,
                'code' => 'resumed_no_card',
                'message' => 'Membership resumed. A card must be saved by renewing once manually, otherwise automatic renewal has nothing to charge.',
            ];
        }

        return ['ok' => true, 'code' => 'resumed', 'message' => 'Membership resumed and will renew automatically.'];
    }

    /**
     * Switch automatic renewal on or off without cancelling.
     *
     * @return array{ok: bool, code: string, message: string}
     */
    public function setAutoRenew(User $user, bool $autoRenew): array
    {
        if (!($user->plan_id > 0)) {
            return ['ok' => false, 'code' => 'no_plan', 'message' => 'There is no membership to change.'];
        }

        if ($user->hasLifetimeMembership()) {
            return ['ok' => false, 'code' => 'lifetime', 'message' => 'Lifetime memberships never need renewing.'];
        }

        $user->update(['auto_renew' => $autoRenew]);

        if (!$autoRenew) {
            return [
                'ok' => true,
                'code' => 'auto_renew_off',
                'message' => 'Automatic renewal is off. The membership will end on its expiry date unless renewed.',
            ];
        }

        if (!$this->hasSavedCard($user)) {
            return [
                'ok' => true,
                'code' => 'auto_renew_on_no_card',
                'message' => 'Automatic renewal is on. Renew once manually to save a card, otherwise there is nothing to charge.',
            ];
        }

        return [
            'ok' => true,
            'code' => 'auto_renew_on',
            'message' => 'Automatic renewal is on. The saved card will be charged before the membership expires.',
        ];
    }

    /**
     * Put a member on a plan without taking payment.
     *
     * Admin-only: used for comped memberships, support fixes and migrations off
     * another system. Paid changes still go through Stripe Checkout so the money
     * and the PaymentHistory row stay in step — this deliberately records no
     * payment, because none was taken.
     *
     * @return array{ok: bool, code: string, message: string}
     */
    public function assignPlan(User $user, Membership $plan, ?Carbon $expiry = null): array
    {
        $expiry = $expiry ?: app(MembershipRenewalService::class)->nextExpiry($user, $plan);

        // auto_renew is deliberately left as it is. Handing someone a comped plan
        // must never quietly switch on billing they did not agree to; an admin
        // who wants renewal turns it on explicitly.
        $user->update([
            'plan_id'                 => $plan->id,
            'plan_name'               => $plan->membership_name,
            'plan_price'              => $plan->membership_price,
            'plan_period'             => $plan->membership_period,
            'plan_expiry'             => $expiry,
            'membership_cancelled_at' => null,
            'membership_number'       => $user->membership_number ?: User::generateMembershipNumber(),
        ]);

        // A member on a live plan gets their store discount code back.
        app(ShopifyAppService::class)->syncActiveMember($user);

        return [
            'ok' => true,
            'code' => 'plan_assigned',
            'message' => "Membership set to {$plan->membership_name}, expiring {$expiry->format('M j, Y')}. No payment was taken.",
        ];
    }

    /**
     * Whether Stripe holds a card that could be charged off-session.
     */
    public function hasSavedCard(User $user): bool
    {
        return app(PaymentMethodService::class)->hasSavedCard($user);
    }
}
