<?php

namespace Tests\Feature;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The member's own membership controls.
 *
 * These moved behind MembershipService so the admin panel could reuse them.
 * This pins the member-facing behaviour and wording so that sharing the logic
 * cannot quietly change what members see.
 */
class MemberMembershipActionsTest extends TestCase
{
    use DatabaseTransactions;

    private User $member;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->member = User::create([
            'first_name'  => 'Self',
            'last_name'   => 'Service',
            'email'       => 'self-' . Str::random(10) . '@example.test',
            'password'    => bcrypt(Str::random(16)),
            'role'        => 'user',
            'status'      => 'active',
            'plan_id'     => 1,
            'plan_name'   => 'Test Plan',
            'plan_price'  => 100,
            'plan_period' => 'year',
            'plan_expiry' => Carbon::now()->addDays(120),
            'auto_renew'  => true,
        ]);
    }

    public function test_member_can_cancel_their_own_membership(): void
    {
        $response = $this->actingAs($this->member)->post('/member/cancel-subscription');

        $response->assertRedirect();
        // Members must keep reading the second-person copy they always have.
        $response->assertSessionHas('success', fn ($message) => str_contains($message, 'Your membership has been cancelled'));

        $this->member->refresh();
        $this->assertNotNull($this->member->membership_cancelled_at);
        $this->assertFalse((bool) $this->member->auto_renew);
    }

    public function test_member_cannot_cancel_twice(): void
    {
        $this->member->update(['membership_cancelled_at' => Carbon::now(), 'auto_renew' => false]);

        $this->actingAs($this->member)
            ->post('/member/cancel-subscription')
            ->assertSessionHas('error', 'Your membership is already cancelled.');
    }

    public function test_member_can_resume_a_cancelled_membership(): void
    {
        $this->member->update(['membership_cancelled_at' => Carbon::now(), 'auto_renew' => false]);

        $this->actingAs($this->member)
            ->post('/member/resume-subscription')
            ->assertRedirect()
            ->assertSessionHas('success');

        $this->member->refresh();
        $this->assertNull($this->member->membership_cancelled_at);
        $this->assertTrue((bool) $this->member->auto_renew);
    }

    public function test_member_cannot_resume_a_membership_that_is_not_cancelled(): void
    {
        $this->actingAs($this->member)
            ->post('/member/resume-subscription')
            ->assertSessionHas('error', 'Your membership is not cancelled.');
    }

    public function test_member_can_turn_auto_renewal_off(): void
    {
        $response = $this->actingAs($this->member)->post('/member/auto-renew', ['auto_renew' => 0]);

        $response->assertRedirect();
        $response->assertSessionHas('success', fn ($message) => str_contains($message, 'Your membership will simply end'));

        $this->assertFalse((bool) $this->member->refresh()->auto_renew);
    }

    public function test_lifetime_members_are_told_renewal_does_not_apply(): void
    {
        $this->member->update(['plan_period' => 'lifetime']);

        $this->actingAs($this->member)
            ->post('/member/auto-renew', ['auto_renew' => 0])
            ->assertSessionHas('error', 'Lifetime memberships never need renewing.');
    }

    public function test_a_member_without_a_plan_cannot_cancel(): void
    {
        $this->member->update(['plan_id' => 0]);

        $this->actingAs($this->member)
            ->post('/member/cancel-subscription')
            ->assertSessionHas('error', 'You do not have a membership to cancel.');
    }

    public function test_member_subscription_and_payments_pages_still_render(): void
    {
        $this->actingAs($this->member)->get('/member/subscription')->assertOk();
        $this->actingAs($this->member)->get('/member/payments')->assertOk();
    }
}
