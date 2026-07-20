<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * The product detail page must offer the same three Vital Boost plans as the
 * shop grid, priced and worded identically.
 */
class VitalBoostProductDetailsTest extends TestCase
{
    use DatabaseTransactions;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();

        config()->set('vital_boost.subscription_discounts', ['monthly' => 2, 'yearly' => 5]);
        config()->set('vital_boost.shipping.free_for_yearly', true);

        $this->admin = User::create([
            'first_name' => 'Test',
            'last_name'  => 'Admin',
            'email'      => 'admin-' . Str::random(10) . '@example.test',
            'password'   => bcrypt(Str::random(16)),
            'role'       => 'admin',
            'status'     => 'active',
        ]);
    }

    private function makeProduct(string $productType, string $category): Product
    {
        return Product::create([
            'user_id'        => $this->admin->id,
            'sku'            => 'SKU-' . Str::random(8),
            'name'           => 'Detail Product ' . Str::random(6),
            'slug'           => 'detail-product-' . Str::random(8),
            'description'    => 'A test product.',
            'price'          => 100,
            'category'       => $category,
            'product_type'   => $productType,
            'stock_quantity' => 10,
            'status'         => 'active',
        ]);
    }

    public function test_a_vital_boost_product_page_offers_all_three_plans(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('One Time');
        $response->assertSee('Monthly');
        $response->assertSee('Yearly');
        $response->assertSee('Subscribe Monthly');
        $response->assertSee('Subscribe Yearly');
    }

    public function test_each_plan_shows_its_own_discounted_price(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('$100.00');  // one time
        $response->assertSee('$98.00');   // monthly, 2% off
        $response->assertSee('$95.00');   // yearly, 5% off
    }

    public function test_the_perk_wording_matches_the_shop_page(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('Save 2% with a subscription');
        // Yearly earns both perks, in the shortened form. Rendered as HTML here,
        // so the separator appears literally (unlike the shop page's JSON payload).
        $response->assertSee('Save 5% · Free shipping', false);
    }

    public function test_a_normal_product_keeps_the_plain_add_to_cart_button(): void
    {
        $product = $this->makeProduct('supplement', 'institute');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('Add to Cart');
        // No plan selector for products that are not sold on a subscription.
        // Asserted on the rendered control rather than the class name, which also
        // appears in the (inert) selector script at the foot of the page.
        $response->assertDontSee('Subscribe Monthly');
        $response->assertDontSee('data-vb-option', false);
    }

    public function test_the_cart_honours_the_quantity_sent_from_the_detail_page(): void
    {
        $product = $this->makeProduct('supplement', 'institute');

        $this->post('/addtocart', [
            'product_id' => $product->id,
            'quantity'   => 3,
        ])->assertOk();

        // The detail page's quantity control is only useful if the amount
        // actually reaches the cart line.
        $this->assertSame(3, collect(session('cart'))->sum());
    }

    public function test_a_subscription_keeps_its_plan_and_quantity_together(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $this->post('/addtocart', [
            'product_id'    => $product->id,
            'quantity'      => 2,
            'purchase_type' => 'subscription',
            'plan'          => 'yearly',
        ])->assertOk();

        $cart = session('cart');
        $key  = array_key_first($cart);

        // A local addToCart override on the detail page used to drop the plan,
        // turning a subscription into a one-time purchase.
        $this->assertStringContainsString('yearly', (string) $key);
        $this->assertSame(2, $cart[$key]);
    }

    public function test_the_detail_page_passes_quantity_and_plan_through_one_helper(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        // Both buttons route through detailsAddToCart, which supplies the quantity.
        $response->assertSee('detailsAddToCart', false);
        // The page must not re-declare addToCart and shadow the shared one.
        $response->assertDontSee('function addToCart(', false);
    }

    public function test_the_stock_line_can_be_hidden_for_subscription_plans(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('left in stock');
        // Hidden by the selector script, so it needs a handle to target.
        $response->assertSee('id="stock_status"', false);
    }

    public function test_the_page_uses_the_shop_primary_theme_not_orange(): void
    {
        $product = $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/products/' . $product->slug);

        $response->assertOk();
        $response->assertSee('gradient-primary', false);
        $response->assertDontSee('bg-orange-500', false);
    }

    public function test_the_shop_page_serves_the_same_captions_from_the_shared_helper(): void
    {
        $this->makeProduct('vital_boost', 'vital_boost');

        $response = $this->get('/shop');

        $response->assertOk();
        // perk_label travels in the JSON pricing payload rather than being
        // rebuilt in JavaScript, so both pages cannot drift apart. @json escapes
        // the separator, so the caption is asserted in its encoded form.
        $response->assertSee('perk_label', false);
        $response->assertSee('Save 5% \u00b7 Free shipping', false);
        $response->assertSee('Save 2% with a subscription', false);
    }
}
