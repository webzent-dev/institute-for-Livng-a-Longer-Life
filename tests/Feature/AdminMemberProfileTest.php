<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\Membership;
use App\Models\Order;
use App\Models\User;
use App\Models\VitalBoostSubscription;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The admin member profile and the on-behalf-of actions it exposes.
 *
 * Runs inside a transaction because the suite points at the working database
 * rather than an in-memory one — every row created here is rolled back.
 */
class AdminMemberProfileTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;
    private User $member;

    protected function setUp(): void
    {
        parent::setUp();

        // These tests assert on rendered markup, not on bundled assets, and the
        // suite must not depend on `npm run build` having been run.
        $this->withoutVite();

        $this->admin = User::create([
            'first_name' => 'Test',
            'last_name'  => 'Admin',
            'email'      => 'admin-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'admin',
            'status'     => 'active',
        ]);

        $this->member = User::create([
            'first_name'  => 'Test',
            'last_name'   => 'Member',
            'email'       => 'member-' . Str::random(10) . '@example.test',
            'password'    => bcrypt(Str::random(16)),
            'role'        => 'user',
            'status'      => 'active',
            'plan_id'     => 0,
            'plan_expiry' => null,
            'auto_renew'  => false,
        ]);
    }

    /**
     * Give the member a live yearly membership.
     */
    private function giveMembership(bool $autoRenew = true): void
    {
        $this->member->update([
            'plan_id'     => $this->plan()->id,
            'plan_name'   => 'Test Plan',
            'plan_price'  => 100,
            'plan_period' => 'year',
            'plan_expiry' => Carbon::now()->addDays(200),
            'auto_renew'  => $autoRenew,
            'membership_cancelled_at' => null,
        ]);
    }

    /**
     * An order for the given member, with the address columns the table requires.
     */
    private function makeOrder(User $owner, string $status = 'pending', float $total = 50): Order
    {
        return Order::create([
            'order_number'   => 'TEST-' . Str::random(8),
            'user_id'        => $owner->id,
            'first_name'     => $owner->first_name,
            'last_name'      => $owner->last_name,
            'email'          => $owner->email,
            'phone'          => '0000000000',
            'city'           => 'Testville',
            'state'          => 'TS',
            'zip_code'       => '00000',
            'country'        => 'US',
            'total'          => $total,
            'status'         => $status,
            'payment_status' => 'completed',
        ]);
    }

    private function plan(): Membership
    {
        return Membership::firstOrCreate(
            ['membership_name' => 'Automated Test Plan'],
            [
                'membership_price'  => 100,
                'membership_period' => 'year',
                'discount_percent'  => 10,
                'status'            => 'active',
            ]
        );
    }

    public function test_admin_can_view_a_member_profile_with_every_section(): void
    {
        $this->giveMembership();

        // Populate each tab so the render walks the loops, not just the empty states.
        $order = $this->makeOrder($this->member, 'shipped', 75);

        \App\Models\OrderItem::create([
            'order_id'      => $order->id,
            'user_id'       => $this->member->id,
            'product_name'  => 'Rendered Product',
            'purchase_type' => 'subscription',
            'subscription_plan' => 'monthly',
            'quantity'      => 2,
            'price'         => 30,
            'total'         => 60,
        ]);

        VitalBoostSubscription::create([
            'user_id'         => $this->member->id,
            'order_id'        => $order->id,
            'product_name'    => 'Rendered Boost',
            'plan'            => 'monthly',
            'quantity'        => 1,
            'unit_price'      => 30,
            'item_total'      => 30,
            'status'          => 'active',
            'started_at'      => Carbon::now(),
            'next_billing_at' => Carbon::now()->addMonth(),
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/members/' . $this->member->id);

        $response->assertOk();
        $response->assertSee($order->order_number);
        $response->assertSee('Rendered Product');
        $response->assertSee('Rendered Boost');
        // The Vital Boost summary card must reflect the active subscription.
        $response->assertSee('Subscribed');
        $response->assertSee('Membership Actions');
        $response->assertSee('Saved Payment Methods');
        $response->assertSee('Order History');
        $response->assertSee('Vital Boost Subscriptions');
        $response->assertSee('Purchased Products');
        $response->assertSee('Product Subscriptions');
        $response->assertSee($this->member->email);
    }

    public function test_profile_renders_for_a_member_with_no_data_at_all(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/members/' . $this->member->id);

        $response->assertOk();
        $response->assertSee('This member has not placed any orders.');
        $response->assertSee('No Vital Boost subscriptions on record.');
        $response->assertSee('No saved cards for this member.');
    }

    public function test_a_member_cannot_reach_the_admin_member_profile(): void
    {
        $this->actingAs($this->member)
            ->get('/admin/members/' . $this->member->id)
            ->assertForbidden();
    }

    /**
     * Separate from the signed-in case: actingAs persists for the rest of a
     * test, so a guest assertion has to run in a test of its own.
     */
    public function test_a_guest_is_sent_to_the_login_page(): void
    {
        $this->get('/admin/members/' . $this->member->id)->assertRedirect('/auth');
    }

    public function test_member_operations_refuse_a_non_member_account(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/members/' . $this->admin->id)
            ->assertNotFound();

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->admin->id . '/membership/cancel')
            ->assertNotFound();
    }

    public function test_admin_can_cancel_and_resume_a_membership(): void
    {
        $this->giveMembership();

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/membership/cancel')
            ->assertRedirect();

        $this->member->refresh();
        $this->assertNotNull($this->member->membership_cancelled_at);
        $this->assertFalse((bool) $this->member->auto_renew);
        // Cancelling must not strip benefits early — expiry is untouched.
        $this->assertTrue(Carbon::parse($this->member->plan_expiry)->isFuture());

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/membership/resume')
            ->assertRedirect();

        $this->member->refresh();
        $this->assertNull($this->member->membership_cancelled_at);
        $this->assertTrue((bool) $this->member->auto_renew);
    }

    public function test_cancelling_a_membership_the_member_does_not_have_is_rejected(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/membership/cancel')
            ->assertRedirect()
            ->assertSessionHas('error');
    }

    public function test_admin_can_toggle_auto_renewal(): void
    {
        $this->giveMembership(autoRenew: true);

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/membership/auto-renew', ['auto_renew' => 0])
            ->assertRedirect();

        $this->assertFalse((bool) $this->member->refresh()->auto_renew);
    }

    public function test_admin_can_assign_a_plan_without_taking_payment(): void
    {
        $plan = $this->plan();

        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/membership', ['plan_id' => $plan->id])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->member->refresh();
        $this->assertSame((int) $plan->id, (int) $this->member->plan_id);
        $this->assertTrue(Carbon::parse($this->member->plan_expiry)->isFuture());
        // A comped plan takes no money, so no payment may be recorded.
        $this->assertSame(0, \App\Models\PaymentHistory::where('user_id', $this->member->id)->count());
    }

    public function test_assigning_a_plan_validates_its_input(): void
    {
        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/membership', ['plan_id' => 999999])
            ->assertSessionHasErrors('plan_id');

        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/membership', [
                'plan_id' => $this->plan()->id,
                'expiry'  => Carbon::now()->subDay()->toDateString(),
            ])
            ->assertSessionHasErrors('expiry');
    }

    public function test_admin_can_update_an_order_status_and_it_is_audited(): void
    {
        $order = $this->makeOrder($this->member);

        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/orders/' . $order->id . '/status', ['status' => 'shipped'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->assertSame('shipped', $order->refresh()->status);

        $log = AuditLog::where('user_id', $this->member->id)->where('action', 'order_status_updated')->first();
        $this->assertNotNull($log);
        // The member is the subject; the admin must be recorded as the actor.
        $this->assertSame($this->admin->id, (int) $log->actor_id);
    }

    public function test_an_order_belonging_to_another_member_cannot_be_touched(): void
    {
        $stranger = User::create([
            'first_name' => 'Other',
            'last_name'  => 'Member',
            'email'      => 'other-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'user',
            'status'     => 'active',
        ]);

        $order = $this->makeOrder($stranger, total: 25);

        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/orders/' . $order->id . '/status', ['status' => 'cancelled'])
            ->assertNotFound();

        $this->assertSame('pending', $order->refresh()->status);
    }

    public function test_order_status_must_be_one_of_the_known_statuses(): void
    {
        $order = $this->makeOrder($this->member, total: 10);

        $this->actingAs($this->admin)
            ->put('/admin/members/' . $this->member->id . '/orders/' . $order->id . '/status', ['status' => 'teleported'])
            ->assertSessionHasErrors('status');

        $this->assertSame('pending', $order->refresh()->status);
    }

    public function test_admin_can_cancel_and_resume_a_vital_boost_subscription(): void
    {
        $subscription = VitalBoostSubscription::create([
            'user_id'         => $this->member->id,
            'product_name'    => 'Test Boost',
            'plan'            => 'monthly',
            'quantity'        => 1,
            'unit_price'      => 30,
            'item_total'      => 30,
            'status'          => 'active',
            'started_at'      => Carbon::now(),
            'next_billing_at' => Carbon::now()->addMonth(),
        ]);

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/vital-boost/' . $subscription->id, ['action' => 'cancel'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $subscription->refresh();
        $this->assertSame('cancelled', $subscription->status);
        // Nothing must remain for the renewal job to pick up.
        $this->assertNull($subscription->next_billing_at);

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/vital-boost/' . $subscription->id, ['action' => 'resume'])
            ->assertRedirect()
            ->assertSessionHas('success');

        $subscription->refresh();
        $this->assertSame('active', $subscription->status);
        $this->assertNotNull($subscription->next_billing_at);
    }

    public function test_an_expired_vital_boost_subscription_cannot_be_resumed(): void
    {
        $subscription = VitalBoostSubscription::create([
            'user_id'      => $this->member->id,
            'product_name' => 'Test Boost',
            'plan'         => 'yearly',
            'quantity'     => 1,
            'unit_price'   => 300,
            'item_total'   => 300,
            'status'       => 'expired',
        ]);

        $this->actingAs($this->admin)
            ->post('/admin/members/' . $this->member->id . '/vital-boost/' . $subscription->id, ['action' => 'resume'])
            ->assertRedirect()
            ->assertSessionHas('error');

        $this->assertSame('expired', $subscription->refresh()->status);
    }

    public function test_viewing_a_member_through_the_users_route_redirects_to_the_profile(): void
    {
        $this->actingAs($this->admin)
            ->get('/admin/users/' . $this->member->id)
            ->assertRedirect(route('admin.members.show', $this->member->id));
    }

    public function test_users_list_links_every_tab_to_its_profile(): void
    {
        // Guarantees the collaborators tab is not empty on a clean database.
        User::create([
            'first_name' => 'Listed',
            'last_name'  => 'Collaborator',
            'email'      => 'collab-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'collaborator',
            'status'     => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/users');
        $response->assertOk();

        // The list paginates at 10 per tab, so assert against whoever actually
        // lands on page one rather than the rows this test happened to create.
        $firstOnPage = fn (string $role) => User::where('role', $role)->paginate(10)->first();

        // Each tab needs its own View target: members and collaborators have
        // full profiles, admins fall back to the plain account view.
        $response->assertSee(route('admin.members.show', $firstOnPage('user')->id), false);
        $response->assertSee(route('collaborators.show', $firstOnPage('collaborator')->id), false);
        $response->assertSee(route('users.show', $firstOnPage('admin')->id), false);
    }

    public function test_viewing_a_collaborator_through_the_users_route_still_works(): void
    {
        $collaborator = User::create([
            'first_name' => 'Test',
            'last_name'  => 'Collaborator',
            'email'      => 'collab-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'collaborator',
            'status'     => 'active',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/users/' . $collaborator->id)
            ->assertOk();
    }
}
