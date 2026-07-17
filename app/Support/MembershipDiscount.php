<?php

namespace App\Support;

use App\Models\Membership;
use App\Models\User;
use Carbon\Carbon;

/**
 * Single source of truth for the member discount percentage.
 *
 * The discount is defined per membership plan on the memberships table
 * (memberships.discount_percent), so each plan — Gold, Standard, Lifetime or any
 * new plan an admin creates — carries its own percentage. Resolved by the
 * member's plan_id, falling back to plan_name.
 */
class MembershipDiscount
{
    /**
     * Discount percentage for a plan by its id (0 when unknown).
     */
    public static function percentForPlanId(?int $planId): float
    {
        if (empty($planId)) {
            return 0.0;
        }

        $membership = Membership::find($planId);

        return $membership ? (float) ($membership->discount_percent ?? 0) : 0.0;
    }

    /**
     * Discount percentage for a plan by its name (0 when unknown). Used where only
     * the plan name is available (e.g. Shopify code sync, member API lookups).
     */
    public static function percentFor(?string $planName): float
    {
        if (empty($planName)) {
            return 0.0;
        }

        $percent = Membership::where('membership_name', $planName)->value('discount_percent');

        return (float) ($percent ?? 0);
    }

    /**
     * Whether the member currently holds an active (unexpired) plan.
     */
    public static function isActive(?User $user): bool
    {
        return $user
            && !empty($user->plan_expiry)
            && Carbon::parse($user->plan_expiry)->isFuture();
    }

    /**
     * Discount percentage the member is actually entitled to right now: their
     * plan's percentage, but only while the plan is active. 0 otherwise.
     */
    public static function activePercentFor(?User $user): float
    {
        if (!self::isActive($user)) {
            return 0.0;
        }

        $percent = self::percentForPlanId($user->plan_id);
        if ($percent <= 0) {
            $percent = self::percentFor($user->plan_name);
        }

        return $percent;
    }
}
