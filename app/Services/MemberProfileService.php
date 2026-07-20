<?php

namespace App\Services;

use App\Models\AuditLog;
use App\Models\Membership;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentHistory;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\VitalBoostSubscription;
use App\Services\Pricing\VitalBoostPricingService;
use Carbon\Carbon;

/**
 * Assembles everything the admin member profile shows about one member.
 *
 * Kept out of the controller so each tab's query lives next to the others and
 * the eager loading can be reasoned about in one place.
 */
class MemberProfileService
{
    public function __construct(
        private PaymentMethodService $cardService,
    ) {
    }

    /**
     * The member's address, or null when they never saved one.
     */
    public function address(User $user): ?UserAddress
    {
        return UserAddress::where('user_id', $user->id)->first();
    }

    /**
     * Current plan plus the derived membership state the header and Membership
     * tab both need.
     *
     * @return array<string, mixed>
     */
    public function membership(User $user): array
    {
        $plan = $user->plan_id ? Membership::find($user->plan_id) : null;
        $expiry = $user->plan_expiry ? Carbon::parse($user->plan_expiry) : null;
        $isLifetime = $user->hasLifetimeMembership();
        $isActive = $user->membershipIsActive();
        $isCancelled = $user->membershipIsCancelled();

        return [
            'plan'          => $plan,
            'plan_name'     => $user->plan_name ?: ($plan->membership_name ?? null),
            'plan_price'    => $user->plan_price,
            'plan_period'   => $user->plan_period,
            'expiry'        => $expiry,
            'is_lifetime'   => $isLifetime,
            'is_active'     => $isActive,
            'is_cancelled'  => $isCancelled,
            'cancelled_at'  => $user->membership_cancelled_at,
            'auto_renew'    => (bool) $user->auto_renew,
            'will_auto_renew' => $user->shouldAutoRenew(),
            // A lifetime plan never renews, and a cancelled one stops at expiry,
            // so neither has a renewal date to show.
            'renewal_date'  => (!$isLifetime && !$isCancelled && $user->auto_renew) ? $expiry : null,
            'status_label'  => $this->membershipStatusLabel($user),
            'has_saved_card' => $this->cardService->hasSavedCard($user),
        ];
    }

    /**
     * A single word for the member's membership state, for the status badge.
     */
    private function membershipStatusLabel(User $user): string
    {
        if (!($user->plan_id > 0)) {
            return 'none';
        }

        if ($user->hasLifetimeMembership()) {
            return 'lifetime';
        }

        if (!$user->membershipIsActive()) {
            return 'expired';
        }

        return $user->membershipIsCancelled() ? 'cancelling' : 'active';
    }

    /**
     * Every order the member placed, newest first, with items and per-seller
     * sub-orders ready for the Orders tab.
     */
    public function orders(User $user)
    {
        return Order::with(['items.product', 'subOrders.seller'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Individual products the member has bought, newest first.
     *
     * Sourced from order items rather than orders so a member who bought five
     * products across two orders shows five lines.
     */
    public function purchasedProducts(User $user)
    {
        return OrderItem::with(['product', 'order'])
            ->whereHas('order', fn ($query) => $query->where('user_id', $user->id))
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Recurring product subscriptions taken out through checkout.
     */
    public function productSubscriptions(User $user)
    {
        return $this->purchasedProducts($user)
            ->where('purchase_type', VitalBoostPricingService::TYPE_SUBSCRIPTION)
            ->values();
    }

    /**
     * The member's Vital Boost subscriptions, newest first.
     */
    public function vitalBoostSubscriptions(User $user)
    {
        return VitalBoostSubscription::with(['product', 'order'])
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Saved cards, brand and last four only — see PaymentMethodService.
     *
     * @return array<int, array<string, mixed>>
     */
    public function paymentMethods(User $user): array
    {
        return $this->cardService->listCards($user);
    }

    /**
     * Membership and order payments taken from this member.
     */
    public function paymentHistory(User $user)
    {
        return PaymentHistory::where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();
    }

    /**
     * Admin actions recorded against this member, newest first.
     */
    public function activity(User $user, int $limit = 50)
    {
        return AuditLog::with('actor')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Headline counts for the cards above the tabs.
     *
     * @return array<string, mixed>
     */
    public function summary(User $user, $orders, $vitalBoostSubscriptions): array
    {
        return [
            'order_count'      => $orders->count(),
            'lifetime_value'   => $orders->where('status', '!=', 'cancelled')->sum('total'),
            'open_orders'      => $orders->whereNotIn('status', ['delivered', 'cancelled'])->count(),
            'vital_boost_count' => $vitalBoostSubscriptions->count(),
            'has_vital_boost'  => $vitalBoostSubscriptions->where('status', 'active')->isNotEmpty(),
        ];
    }
}
