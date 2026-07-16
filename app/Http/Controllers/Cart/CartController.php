<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    protected $shippingService;

    public function __construct(ShippingService $shippingService)
    {
        $this->shippingService = $shippingService;
    }

    /**
     * Display the shopping cart
     *
     * @return \Illuminate\View\View
     */
    public function cart()
    {
        $cart = Session::get('cart', []);
        $total = 0;
        $cartItems = [];
        $groupedItems = [];

        foreach ($cart as $lineKey => $quantity) {
            //Get product detail with user detail
            $productId = \App\Support\CartLine::productId($lineKey);
            $product = Product::with('user')->find($productId);
            if ($product) {
                if($product->user->role == 'collaborator'){
                    $vendorName = ucfirst($product->user->first_name) . ' ' . ucfirst($product->user->last_name);
                }else{
                    $vendorName = 'Institute';
                }

                $itemTotal = $product->price * $quantity;
                $total += $itemTotal;

                $meta = \App\Support\CartLine::meta($lineKey);
                $cartItem = [
                    'id' => $product->id,
                    'line_key' => (string) $lineKey,
                    'name' => $product->name,
                    'purchase_type' => $meta['purchase_type'],
                    'plan' => $meta['plan'],
                    'purchase_label' => \App\Support\CartLine::label($meta['purchase_type'], $meta['plan']),
                    'vendor' => $vendorName,
                    'vendor_id' => $product->user->id,
                    'vendor_role' => $product->user->role,
                    'quantity' => $quantity,
                    'itemTotal' => $itemTotal,
                    'price' => $product->price,
                    'originalPrice' => $product->originalPrice,
                    'image' =>  $product->image ? asset('product_images/' . $product->image) : null,
                    'weight' => $product->weight ?? 0,
                    'requires_shipping' => $product->requires_shipping ?? true,
                ];

                $cartItems[] = $cartItem;

                // Group by seller for split shipping display
                $sellerId = $product->user->id;
                if (!isset($groupedItems[$sellerId])) {
                    $groupedItems[$sellerId] = [
                        'vendor_name' => $vendorName,
                        'vendor_role' => $product->user->role,
                        'items' => [],
                        'subtotal' => 0,
                        'total_weight' => 0,
                    ];
                }
                
                $groupedItems[$sellerId]['items'][] = $cartItem;
                $groupedItems[$sellerId]['subtotal'] += $itemTotal;
                $groupedItems[$sellerId]['total_weight'] += ($product->weight ?? 0) * $quantity;
            }
        }

        return view('front.pages.cart', [
            'cartItems' => $cartItems,
            'groupedItems' => $groupedItems,
            'total' => $total,
            'cartCount' => array_sum($cart)
        ]);
    }

    /**
     * Add product to cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addToCart(Request $request)
    {
        /*$validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $validated['product_id'];
        $quantity = $validated['quantity'];*/
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        //Get stock quantity from database
        $product = Product::with('user')->find($productId);

        // Build the cart line key from the purchase choice. Only Vital Boost
        // products support subscriptions; everything else is a one-time line.
        // This lets the same product sit in the cart as several lines (one-time,
        // monthly, yearly) instead of collapsing into one.
        $purchaseType = $request->input('purchase_type', 'one_time');
        $plan = $request->input('plan');
        if ($product->product_type !== 'vital_boost') {
            $purchaseType = 'one_time';
            $plan = null;
        }
        $lineKey = \App\Support\CartLine::key((int) $productId, $purchaseType, $plan);

        // Get current cart from session
        $cart = Session::get('cart', []);

        // Stock is shared across every line of the same product, so validate the
        // requested quantity against the combined quantity already in the cart.
        $existingProductQty = 0;
        foreach ($cart as $key => $qty) {
            if (\App\Support\CartLine::productId($key) === (int) $productId) {
                $existingProductQty += $qty;
            }
        }

        $stockQuantity = $product->stock_quantity;
        if ($stockQuantity < $existingProductQty + $quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient stock quantity/Out of stock.',
                'cartCount' => array_sum($cart),
                'cartTotal' => $this->getCartTotal($cart)
            ], 200);
        }

        // Allow multi-seller carts for split shipping
        // No longer restrict to single vendor

        // Add or update this specific line in the cart
        if (isset($cart[$lineKey])) {
            $cart[$lineKey] += $quantity;
            $message = $cart[$lineKey]. ' '. 'items in cart';
        } else {
            $cart[$lineKey] = $quantity;
            $message = $quantity.' '.' item added to cart';
        }

        // Store updated cart in session
        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'cartCount' => array_sum($cart),
            'cartTotal' => $this->getCartTotal($cart),
            'message' => $message
        ]);
    }

    /**
     * Update product quantity in cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCart(Request $request)
    {
        /*$validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $productId = $validated['product_id'];
        $quantity = $validated['quantity'];
        */
        // A specific cart line is identified by its line_key (falls back to
        // product_id for backwards compatibility / non-subscription lines).
        $lineKey = $request->input('line_key', $request->input('product_id'));
        $quantity = $request->input('quantity');

        // Get current cart from session
        $cart = Session::get('cart', []);

        if (!isset($cart[$lineKey])) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found in cart'
            ], 404);
        }

        //Get stock quantity from database. Stock is shared across every line of
        //the same product, so validate against the other lines' quantities too.
        $productId = \App\Support\CartLine::productId($lineKey);
        $product = Product::find($productId);
        $stockQuantity = $product->stock_quantity;

        $otherLinesQty = 0;
        foreach ($cart as $key => $qty) {
            if ($key != $lineKey && \App\Support\CartLine::productId($key) === $productId) {
                $otherLinesQty += $qty;
            }
        }

        if ($stockQuantity < $otherLinesQty + $quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient stock quantity/Out of stock'
            ], 200);
        }

        // Update this line's quantity
        $cart[$lineKey] = $quantity;
        Session::put('cart', $cart);

        return response()->json([
            'status' => true,
            'message' => 'Cart updated successfully',
            'cartCount' => array_sum($cart),
            'cartTotal' => $this->getCartTotal($cart)
        ]);
    }

    /**
     * Remove product from cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function removeFromCart(Request $request)
    {
        /*$validated = $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);*/

        // Remove one specific cart line by its line_key (falls back to product_id).
        $lineKey = $request->input('line_key', $request->input('product_id'));

        // Get current cart from session
        $cart = Session::get('cart', []);

        // Remove the line from cart
        if (isset($cart[$lineKey])) {
            unset($cart[$lineKey]);
            Session::put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Product removed from cart',
                'cartCount' => array_sum($cart),
                'cartTotal' => $this->getCartTotal($cart)
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Product not found in cart'
        ], 404);
    }

    /**
     * Clear entire cart
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function clearCart()
    {
        Session::forget('cart');

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully',
            'cartCount' => 0,
            'cartTotal' => 0
        ]);
    }

    /**
     * Get shipping estimates for cart
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getShippingEstimates(Request $request)
    {
        $cart = Session::get('cart', []);
        if (empty($cart)) {
            return response()->json([
                'status' => false,
                'message' => 'Cart is empty'
            ]);
        }

        $destinationAddress = $request->validate([
            'address_line_1' => 'required|string',
            'city' => 'required|string',
            'state' => 'required|string',
            'zip_code' => 'required|string',
            'country' => 'required|string',
        ]);

        try {
            $shippingQuotes = $this->shippingService->calculateSplitShippingRates($cart, $destinationAddress);
            $totalShipping = $this->shippingService->calculateTotalShippingCost($shippingQuotes);

            return response()->json([
                'status' => true,
                'shipping_quotes' => $shippingQuotes,
                'total_shipping' => $totalShipping,
                'message' => 'Shipping estimates calculated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Unable to calculate shipping: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Validate seller shipping setup
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateSellerShipping(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => false,
                'message' => 'Authentication required'
            ]);
        }

        $seller = Auth::user();
        $validation = $this->shippingService->validateSellerShippingSetup($seller);

        return response()->json([
            'status' => $validation['is_valid'],
            'errors' => $validation['errors'],
            'message' => $validation['is_valid'] ? 'Shipping setup is valid' : 'Shipping setup needs attention'
        ]);
    }

    /**
     * Calculate cart total
     *
     * @param  array  $cart
     * @return float
     */
    private function getCartTotal($cart)
    {
        $total = 0;

        foreach ($cart as $lineKey => $quantity) {
            $product = Product::find(\App\Support\CartLine::productId($lineKey));
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        return $total;
    }
}
