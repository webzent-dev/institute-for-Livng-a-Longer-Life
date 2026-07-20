<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Membership;
use App\Models\Order;
use App\Models\SubOrder;
use App\Models\User;
use App\Models\VitalBoostSubscription;
use App\Services\MembershipRenewalService;
use App\Services\MembershipService;
use App\Services\MemberProfileService;
use App\Services\OrderStatusService;
use App\Services\PaymentMethodService;
use App\Services\VitalBoostSubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * The admin's view of a single member, and the operations an admin can perform
 * on that member's behalf.
 *
 * Every operation delegates to the same service the member dashboard uses, so
 * an admin cancelling a membership and a member cancelling their own membership
 * run identical logic.
 *
 * Access is enforced by the RoleMiddleware:admin group these routes sit in;
 * resolveMember() adds the second guard — these actions only ever apply to
 * members, never to collaborators or other admins.
 */
class AdminMemberController extends Controller
{
    public function __construct(
        private MemberProfileService $profile,
        private MembershipService $memberships,
        private VitalBoostSubscriptionService $vitalBoost,
        private OrderStatusService $orderStatus,
        private PaymentMethodService $cards,
    ) {
    }

    /**
     * Load a member by id, refusing any user who is not a member.
     *
     * Collaborator and admin accounts have no membership, orders or saved cards
     * in the sense this screen means, and their records must not be edited
     * through member operations.
     */
    private function resolveMember(string $id): User
    {
        $user = User::findOrFail($id);

        abort_unless($user->role === 'user', 404, 'Not a member account.');

        return $user;
    }

    /**
     * The full member profile, one tab per section.
     */
    public function show(string $id)
    {
        $member = $this->resolveMember($id);

        $orders = $this->profile->orders($member);
        $vitalBoostSubscriptions = $this->profile->vitalBoostSubscriptions($member);

        return view('admin.members.show', [
            'member'                  => $member,
            'address'                 => $this->profile->address($member),
            'membership'              => $this->profile->membership($member),
            'availablePlans'          => Membership::where('status', 'active')->get(),
            'purchasedProducts'       => $this->profile->purchasedProducts($member),
            'productSubscriptions'    => $this->profile->productSubscriptions($member),
            'vitalBoostSubscriptions' => $vitalBoostSubscriptions,
            'paymentMethods'          => $this->profile->paymentMethods($member),
            'paymentHistory'          => $this->profile->paymentHistory($member),
            'orders'                  => $orders,
            'activity'                => $this->profile->activity($member),
            'summary'                 => $this->profile->summary($member, $orders, $vitalBoostSubscriptions),
            'orderStatuses'           => OrderStatusService::STATUSES,
        ]);
    }

    /**
     * Put the member on a plan without taking payment.
     *
     * For comped memberships and support corrections. Paid plan changes still go
     * through Stripe Checkout on the member's side so money and records agree.
     */
    public function updateMembership(Request $request, string $id)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'plan_id' => ['required', 'exists:memberships,id'],
            'expiry'  => ['nullable', 'date', 'after:today'],
        ]);

        $plan = Membership::findOrFail($validated['plan_id']);
        $expiry = !empty($validated['expiry']) ? Carbon::parse($validated['expiry']) : null;

        $result = $this->memberships->assignPlan($member, $plan, $expiry);

        return $this->respond($member, $result, 'membership_assigned', $result['message'], 'membership', $plan->id);
    }

    /**
     * Cancel the membership. Benefits continue until expiry.
     */
    public function cancelMembership(string $id)
    {
        $member = $this->resolveMember($id);

        $result = $this->memberships->cancel($member);

        return $this->respond($member, $result, 'membership_cancelled', $result['message']);
    }

    /**
     * Undo a cancellation.
     */
    public function resumeMembership(string $id)
    {
        $member = $this->resolveMember($id);

        $result = $this->memberships->resume($member);

        return $this->respond($member, $result, 'membership_resumed', $result['message']);
    }

    /**
     * Turn automatic renewal on or off.
     */
    public function updateAutoRenew(Request $request, string $id)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'auto_renew' => ['required', 'boolean'],
        ]);

        $result = $this->memberships->setAutoRenew($member, (bool) $validated['auto_renew']);

        return $this->respond(
            $member,
            $result,
            $validated['auto_renew'] ? 'auto_renew_enabled' : 'auto_renew_disabled',
            $result['message']
        );
    }

    /**
     * Charge the member's saved card now and extend the membership.
     *
     * Reuses the same off-session renewal the nightly job runs, so a support
     * agent renewing by hand produces exactly the same result as automatic
     * renewal — including the PaymentHistory row and the Shopify sync.
     */
    public function renewMembership(string $id, MembershipRenewalService $renewals)
    {
        $member = $this->resolveMember($id);

        if (!($member->plan_id > 0)) {
            return back()->with('error', 'This member has no plan to renew.');
        }

        if ($member->hasLifetimeMembership()) {
            return back()->with('error', 'Lifetime memberships never need renewing.');
        }

        $result = $renewals->renewOffSession($member);

        if ($result['ok']) {
            AuditLog::record(
                $member->id,
                'membership_renewed',
                'Membership renewed by admin against the saved card.',
                'membership',
                $member->plan_id
            );

            return back()->with('success', 'Membership renewed. The saved card was charged.');
        }

        // A card that needs the member present cannot be charged from here —
        // say so plainly rather than reporting a generic failure.
        $message = !empty($result['requires_action'])
            ? 'The bank needs the member to authenticate. Ask them to renew from their own dashboard.'
            : $result['message'];

        return back()->with('error', $message);
    }

    /**
     * Cancel or resume one of the member's Vital Boost subscriptions.
     */
    public function updateVitalBoostSubscription(Request $request, string $id, string $subscriptionId)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'action' => ['required', Rule::in(['cancel', 'resume'])],
        ]);

        // Scoped to the member so a subscription id from another account cannot
        // be driven through this member's URL.
        $subscription = VitalBoostSubscription::where('user_id', $member->id)
            ->findOrFail($subscriptionId);

        $result = $validated['action'] === 'cancel'
            ? $this->vitalBoost->cancel($subscription)
            : $this->vitalBoost->resume($subscription);

        return $this->respond(
            $member,
            $result,
            $validated['action'] === 'cancel' ? 'vital_boost_cancelled' : 'vital_boost_resumed',
            $result['message'],
            'vital_boost_subscription',
            $subscription->id
        );
    }

    /**
     * Move one of the member's orders to a new status.
     */
    public function updateOrderStatus(Request $request, string $id, string $orderId)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(OrderStatusService::STATUSES)],
        ]);

        $order = Order::where('user_id', $member->id)->findOrFail($orderId);

        $result = $this->orderStatus->updateOrder($order, $validated['status']);

        return $this->respond(
            $member,
            $result,
            'order_status_updated',
            "Order {$order->order_number} set to {$validated['status']}.",
            'order',
            $order->id
        );
    }

    /**
     * Move a single seller's sub-order to a new status.
     */
    public function updateSubOrderStatus(Request $request, string $id, string $subOrderId)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'status' => ['required', Rule::in(OrderStatusService::STATUSES)],
        ]);

        $subOrder = SubOrder::with('order')
            ->whereHas('order', fn ($query) => $query->where('user_id', $member->id))
            ->findOrFail($subOrderId);

        $result = $this->orderStatus->updateSubOrder($subOrder, $validated['status']);

        return $this->respond(
            $member,
            $result,
            'sub_order_status_updated',
            "Sub-order {$subOrder->sub_order_number} set to {$validated['status']}.",
            'sub_order',
            $subOrder->id
        );
    }

    /**
     * Make one of the member's saved cards their default.
     */
    public function setDefaultPaymentMethod(Request $request, string $id)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'payment_method_id' => ['required', 'string'],
        ]);

        $result = $this->cards->setDefault($member, $validated['payment_method_id']);

        return $this->respond(
            $member,
            ['ok' => $result['success'], 'message' => $result['message']],
            'default_card_changed',
            $result['message'],
            'payment_method'
        );
    }

    /**
     * Remove a saved card from the member's Stripe customer.
     */
    public function deletePaymentMethod(Request $request, string $id)
    {
        $member = $this->resolveMember($id);

        $validated = $request->validate([
            'payment_method_id' => ['required', 'string'],
        ]);

        $result = $this->cards->detach($member, $validated['payment_method_id']);

        return $this->respond(
            $member,
            ['ok' => $result['success'], 'message' => $result['message']],
            'card_removed',
            $result['message'],
            'payment_method'
        );
    }

    /**
     * Flash the service's own message and audit anything that succeeded.
     *
     * Every action on this screen ends the same way, so the audit write and the
     * redirect live in one place rather than being repeated per method.
     *
     * @param array{ok: bool, message: string} $result
     */
    private function respond(
        User $member,
        array $result,
        string $action,
        string $description,
        ?string $resourceType = null,
        ?int $resourceId = null
    ) {
        if (!$result['ok']) {
            return back()->with('error', $result['message']);
        }

        AuditLog::record($member->id, $action, $description, $resourceType, $resourceId);

        return back()->with('success', $result['message']);
    }
}
