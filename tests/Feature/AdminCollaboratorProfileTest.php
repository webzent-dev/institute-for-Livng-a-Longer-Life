<?php

namespace Tests\Feature;

use App\Models\AuditLog;
use App\Models\CollaboratorBankDetails;
use App\Models\Course;
use App\Models\Order;
use App\Models\Product;
use App\Models\SubOrder;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The admin collaborator profile and the operations it exposes.
 *
 * Runs inside a transaction because the suite points at the working database
 * rather than an in-memory one — every row created here is rolled back.
 */
class AdminCollaboratorProfileTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;
    private User $collaborator;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        $this->admin = User::create([
            'first_name' => 'Test',
            'last_name'  => 'Admin',
            'email'      => 'admin-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'admin',
            'status'     => 'active',
        ]);

        $this->collaborator = User::create([
            'first_name'  => 'Test',
            'last_name'   => 'Collaborator',
            'email'       => 'collab-' . Str::random(10) . '@example.test',
            'password'    => bcrypt(Str::random(16)),
            'role'        => 'collaborator',
            'status'      => 'active',
            'speciality'  => 'Nutrition',
            'experience'  => 5,
            'organization' => 'Test Clinic',
        ]);
    }

    private function makeProduct(string $status = 'active'): Product
    {
        return Product::create([
            'user_id'        => $this->collaborator->id,
            'sku'            => 'SKU-' . Str::random(8),
            'name'           => 'Collab Product ' . Str::random(5),
            'slug'           => 'collab-product-' . Str::random(8),
            'price'          => 40,
            'category'       => 'collaborator',
            'product_type'   => 'supplement',
            'stock_quantity' => 10,
            'status'         => $status,
        ]);
    }

    private function makeCourse(string $status = 'published'): Course
    {
        return Course::create([
            'user_id'  => $this->collaborator->id,
            'title'    => 'Collab Course ' . Str::random(5),
            'category' => 'health_wellness',
            'duration' => '10:00',
            'status'   => $status,
        ]);
    }

    private function makeSubOrder(string $status = 'pending', float $total = 60): SubOrder
    {
        $order = Order::create([
            'order_number'   => 'TEST-' . Str::random(8),
            'first_name'     => 'Buying',
            'last_name'      => 'Customer',
            'email'          => 'buyer-' . Str::random(6) . '@example.test',
            'phone'          => '0000000000',
            'city'           => 'Testville',
            'state'          => 'TS',
            'zip_code'       => '00000',
            'country'        => 'US',
            'total'          => $total,
            'status'         => 'pending',
            'payment_status' => 'completed',
        ]);

        return SubOrder::create([
            'order_id'         => $order->id,
            'seller_id'        => $this->collaborator->id,
            'sub_order_number' => 'SUB-' . Str::random(8),
            'subtotal'         => $total,
            'total'            => $total,
            'status'           => $status,
        ]);
    }

    public function test_admin_can_view_a_collaborator_profile_with_every_section(): void
    {
        $product = $this->makeProduct();
        $course = $this->makeCourse();
        $subOrder = $this->makeSubOrder();

        $response = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);

        $response->assertOk();
        $response->assertSee('Business Details');
        $response->assertSee('Payout Details');
        $response->assertSee('Collaborator Products');
        $response->assertSee('Collaborator Courses');
        $response->assertSee('Sales &amp; Shipments', false);
        $response->assertSee('Shipping Readiness');
        $response->assertSee($product->name);
        $response->assertSee($course->title);
        $response->assertSee($subOrder->sub_order_number);
    }

    public function test_profile_renders_for_a_collaborator_with_no_data(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);

        $response->assertOk();
        $response->assertSee('No products found');
        $response->assertSee('No courses found');
        $response->assertSee('This collaborator has no sales yet.');
        $response->assertSee('No bank details provided yet.');
        $response->assertSee('No business details provided yet.');
    }

    public function test_payout_account_numbers_are_masked(): void
    {
        CollaboratorBankDetails::create([
            'user_id'             => $this->collaborator->id,
            'account_holder_name' => 'Test Collaborator',
            'bank_name'           => 'Test Bank',
            'account_number'      => '12345678901234',
            'routing_number'      => '021000021',
            'iban'                => 'GB33BUKB20201555555555',
            'account_type'        => 'checking',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);

        $response->assertOk();
        // The full account number and IBAN must never reach the page.
        $response->assertDontSee('12345678901234');
        $response->assertDontSee('GB33BUKB20201555555555');
        $response->assertSee('1234');
        $response->assertSee('5555');
    }

    public function test_revenue_excludes_cancelled_shipments(): void
    {
        $this->makeSubOrder('delivered', 100);
        $this->makeSubOrder('cancelled', 250);

        $response = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);

        $response->assertOk();
        $response->assertSee('$100.00');
        $response->assertDontSee('$350.00');
    }

    public function test_sales_are_paginated_and_page_links_return_to_the_sales_tab(): void
    {
        // 12 shipments against a 10-per-page tab: page one holds ten, page two the rest.
        $subOrders = collect(range(1, 12))->map(fn () => $this->makeSubOrder());

        $first = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);
        $first->assertOk();
        $first->assertSee('of <span class="font-semibold text-gray-700">12</span> shipments', false);
        // Page links must carry the tab, or following one lands on Profile.
        $first->assertSee('sales_page=2', false);
        $first->assertSee('tab=sales', false);

        // Newest first, so the oldest shipment is the one pushed onto page two.
        $oldest = $subOrders->first();
        $first->assertDontSee($oldest->sub_order_number);

        $second = $this->actingAs($this->admin)
            ->get('/admin/collaborators/' . $this->collaborator->id . '?tab=sales&sales_page=2');

        $second->assertOk();
        $second->assertSee($oldest->sub_order_number);
    }

    public function test_summary_totals_cover_every_shipment_not_just_the_visible_page(): void
    {
        // Two full pages at $60 each — the cards must report all 12, not the 10 on screen.
        collect(range(1, 12))->each(fn () => $this->makeSubOrder('delivered', 60));

        $response = $this->actingAs($this->admin)->get('/admin/collaborators/' . $this->collaborator->id);

        $response->assertOk();
        $response->assertSee('$720.00');
        $response->assertSee('12 shipment(s), excludes cancelled');
    }

    public function test_a_member_account_is_not_reachable_as_a_collaborator(): void
    {
        $member = User::create([
            'first_name' => 'Plain',
            'last_name'  => 'Member',
            'email'      => 'member-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'user',
            'status'     => 'active',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/collaborators/' . $member->id)
            ->assertNotFound();
    }

    public function test_a_collaborator_cannot_reach_the_admin_profile(): void
    {
        $this->actingAs($this->collaborator)
            ->get('/admin/collaborators/' . $this->collaborator->id)
            ->assertForbidden();
    }

    public function test_a_guest_is_sent_to_the_login_page(): void
    {
        $this->get('/admin/collaborators/' . $this->collaborator->id)->assertRedirect('/auth');
    }

    public function test_toggling_the_collaborator_status_is_audited(): void
    {
        $this->actingAs($this->admin)
            ->post('/admin/collaborators/status/' . $this->collaborator->id)
            ->assertOk()
            ->assertJson(['status' => 'inactive']);

        $this->assertSame('inactive', $this->collaborator->refresh()->status);

        $log = AuditLog::where('user_id', $this->collaborator->id)
            ->where('action', 'collaborator_status_changed')
            ->first();

        $this->assertNotNull($log);
        $this->assertSame($this->admin->id, (int) $log->actor_id);
    }

    public function test_updating_the_profile_is_audited_and_shows_in_activity(): void
    {
        $this->actingAs($this->admin)->put('/admin/collaborators/update', [
            'user_id'                  => $this->collaborator->id,
            'first_name'               => 'Renamed',
            'last_name'                => 'Collaborator',
            'phone'                    => '5551234567',
            'speciality'               => 'Sleep Science',
            'professional_credentials' => 'PhD',
            // Sent as a string because that is what an HTML form posts, and the
            // controller validates it as one.
            'experience'               => '9',
            'organization'             => 'New Clinic',
            'collaborator_message'     => 'An updated bio.',
        ])->assertSessionHasNoErrors()->assertRedirect();

        $this->assertSame('Renamed', $this->collaborator->refresh()->first_name);

        $this->assertDatabaseHas('audit_logs', [
            'user_id' => $this->collaborator->id,
            'action'  => 'collaborator_profile_updated',
        ]);

        $this->actingAs($this->admin)
            ->get('/admin/collaborators/' . $this->collaborator->id)
            ->assertSee('Collaborator profile updated');
    }

    public function test_product_and_course_status_endpoints_still_work_for_the_profile_toggles(): void
    {
        $product = $this->makeProduct('active');
        $course = $this->makeCourse('published');

        $this->actingAs($this->admin)
            ->post('/admin/products/' . $product->id . '/status', ['status' => 'inactive'])
            ->assertOk();

        $this->actingAs($this->admin)
            ->post('/admin/courses/' . $course->id . '/status', ['status' => 'draft'])
            ->assertOk();

        $this->assertSame('inactive', $product->refresh()->status);
        $this->assertSame('draft', $course->refresh()->status);
    }
}
