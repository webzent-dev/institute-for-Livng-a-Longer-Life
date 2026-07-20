<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Vital Boost products must belong to an admin.
 *
 * The Institute products list joins users on role = admin, so a Vital Boost
 * product owned by a collaborator disappears from every tab of the products
 * screen. The add-product form locks the User field, and these pin the rule for
 * requests that reach the controller with something else.
 */
class AdminVitalBoostProductOwnerTest extends TestCase
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
            'first_name' => 'Test',
            'last_name'  => 'Collaborator',
            'email'      => 'collab-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'collaborator',
            'status'     => 'active',
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    private function payload(array $overrides = []): array
    {
        return array_merge([
            'product_name'   => 'VB Product ' . Str::random(6),
            'sku'            => 'SKU-' . Str::random(8),
            'category'       => 'vital_boost',
            'product_type'   => 'vital_boost',
            'user_id'        => $this->admin->id,
            'description'    => 'A test product.',
            'price'          => 25,
            'stock_quantity' => 5,
        ], $overrides);
    }

    public function test_a_vital_boost_product_posted_with_a_collaborator_owner_is_reassigned_to_an_admin(): void
    {
        $payload = $this->payload(['user_id' => $this->collaborator->id]);

        $this->actingAs($this->admin)
            ->post('/admin/products', $payload)
            ->assertRedirect();

        $product = Product::where('sku', $payload['sku'])->first();

        $this->assertNotNull($product);
        $this->assertSame('vital_boost', $product->category);
        // Falls back to the acting admin rather than keeping the collaborator.
        $this->assertSame($this->admin->id, (int) $product->user_id);
        $this->assertSame('admin', $product->user->role);
    }

    public function test_a_vital_boost_product_keeps_an_admin_owner_that_was_chosen(): void
    {
        $otherAdmin = User::create([
            'first_name' => 'Other',
            'last_name'  => 'Admin',
            'email'      => 'admin2-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'admin',
            'status'     => 'active',
        ]);

        $payload = $this->payload(['user_id' => $otherAdmin->id]);

        $this->actingAs($this->admin)->post('/admin/products', $payload)->assertRedirect();

        $product = Product::where('sku', $payload['sku'])->first();

        $this->assertNotNull($product);
        $this->assertSame($otherAdmin->id, (int) $product->user_id);
    }

    public function test_choosing_vital_boost_type_alone_still_pins_the_owner(): void
    {
        // Category left as Institute: coupleVitalBoost promotes it, so the owner
        // rule has to follow that promotion rather than the posted category.
        $payload = $this->payload([
            'category'     => 'institute',
            'product_type' => 'vital_boost',
            'user_id'      => $this->collaborator->id,
        ]);

        $this->actingAs($this->admin)->post('/admin/products', $payload)->assertRedirect();

        $product = Product::where('sku', $payload['sku'])->first();

        $this->assertNotNull($product);
        $this->assertSame('vital_boost', $product->category);
        $this->assertSame($this->admin->id, (int) $product->user_id);
    }

    public function test_a_non_vital_boost_product_still_belongs_to_the_chosen_collaborator(): void
    {
        $payload = $this->payload([
            'category'     => 'collaborator',
            'product_type' => 'supplement',
            'user_id'      => $this->collaborator->id,
        ]);

        $this->actingAs($this->admin)->post('/admin/products', $payload)->assertRedirect();

        $product = Product::where('sku', $payload['sku'])->first();

        $this->assertNotNull($product);
        // The rule must apply to Vital Boost only, not to every product.
        $this->assertSame($this->collaborator->id, (int) $product->user_id);
    }

    public function test_editing_a_product_into_vital_boost_moves_it_to_an_admin(): void
    {
        $product = Product::create([
            'user_id'        => $this->collaborator->id,
            'sku'            => 'SKU-' . Str::random(8),
            'name'           => 'Plain Product ' . Str::random(6),
            'slug'           => 'plain-product-' . Str::random(8),
            'category'       => 'collaborator',
            'product_type'   => 'supplement',
            'price'          => 30,
            'stock_quantity' => 4,
            'status'         => 'active',
        ]);

        // update() also requires the shipping dimensions, unlike store().
        $this->actingAs($this->admin)->put('/admin/products/' . $product->id . '/update', $this->payload([
            'product_name' => $product->name,
            'sku'          => $product->sku,
            'user_id'      => $this->collaborator->id,
            'weight'       => 1,
            'length'       => 1,
            'width'        => 1,
            'height'       => 1,
        ]))->assertSessionHasNoErrors()->assertRedirect();

        $product->refresh();

        $this->assertSame('vital_boost', $product->category);
        $this->assertSame($this->admin->id, (int) $product->user_id);
    }

    public function test_the_add_product_form_marks_admin_options_so_the_lock_can_find_one(): void
    {
        $response = $this->actingAs($this->admin)->get('/admin/products');

        $response->assertOk();
        $response->assertSee('vb-couple-user', false);
        $response->assertSee('data-role="admin"', false);
        $response->assertSee('vital-boost-coupling.js', false);
    }

    public function test_the_edit_product_form_carries_the_same_lock_markup(): void
    {
        $product = Product::create([
            'user_id'        => $this->admin->id,
            'sku'            => 'SKU-' . Str::random(8),
            'name'           => 'VB Product ' . Str::random(6),
            'slug'           => 'vb-product-' . Str::random(8),
            'category'       => 'vital_boost',
            'product_type'   => 'vital_boost',
            'price'          => 25,
            'stock_quantity' => 5,
            'status'         => 'active',
        ]);

        $response = $this->actingAs($this->admin)->get('/admin/products/' . $product->id);

        $response->assertOk();
        // The edit form must carry the same hooks the shared script looks for.
        $response->assertSee('vb-couple-category', false);
        $response->assertSee('vb-couple-type', false);
        $response->assertSee('vb-couple-user', false);
        $response->assertSee('vb-couple-user-note', false);
        $response->assertSee('data-role="admin"', false);
        $response->assertSee('vital-boost-coupling.js', false);
    }

    public function test_saving_a_legacy_vital_boost_product_moves_it_off_a_collaborator(): void
    {
        // Data that predates the rule: Vital Boost but owned by a collaborator,
        // so it is invisible under every tab of the products screen.
        $product = Product::create([
            'user_id'        => $this->collaborator->id,
            'sku'            => 'SKU-' . Str::random(8),
            'name'           => 'Legacy VB ' . Str::random(6),
            'slug'           => 'legacy-vb-' . Str::random(8),
            'category'       => 'vital_boost',
            'product_type'   => 'vital_boost',
            'price'          => 25,
            'stock_quantity' => 5,
            'status'         => 'active',
        ]);

        $this->actingAs($this->admin)->put('/admin/products/' . $product->id . '/update', $this->payload([
            'product_name' => $product->name,
            'sku'          => $product->sku,
            'user_id'      => $this->collaborator->id,
            'weight'       => 1,
            'length'       => 1,
            'width'        => 1,
            'height'       => 1,
        ]))->assertSessionHasNoErrors()->assertRedirect();

        $this->assertSame('admin', $product->refresh()->user->role);
    }
}
