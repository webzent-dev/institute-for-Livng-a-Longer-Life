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

        foreach ($cart as $productId => $quantity) {
            //Get product detail with user detail
            $product = Product::with('user')->find($productId);
            if ($product) {
                if($product->user->role == 'collaborator'){
                    $vendorName = ucfirst($product->user->first_name) . ' ' . ucfirst($product->user->last_name);
                }else{
                    $vendorName = 'Institute';
                }

                $itemTotal = $product->price * $quantity;
                $total += $itemTotal;
                
                $cartItem = [
                    'id' => $product->id,
                    'name' => $product->name,
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
            'cartCount' => count($cart)
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
        $stockQuantity = $product->stock_quantity;
        if ($stockQuantity < $quantity) {
            return response()->json([
                'status' => false,
                'message' => 'Insufficient stock quantity/Out of stock.',
                'cartCount' => 0,
                'cartTotal' => 0
            ], 200);
        }else{
            // Get current cart from session
            $cart = Session::get('cart', []);

            // Allow multi-seller carts for split shipping
            // No longer restrict to single vendor

            // Add or update product in cart
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
                $message = $cart[$productId]. ' '. 'items in cart';
            } else {
                $cart[$productId] = $quantity;
                $message = $quantity.' '.' item added to cart';
            }

            // Store updated cart in session
            Session::put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart successfully',
                'cartCount' => count($cart),
                'cartTotal' => $this->getCartTotal($cart),
                'message' => $message
            ]);
        }
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
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        //Get stock quantity from database
        $product = Product::find($productId);
        $stockQuantity = $product->stock_quantity;

        if ($stockQuantity < $quantity) { 
            return response()->json([ 
                'status' => false, 
                'message' => 'Insufficient stock quantity/Out of stock' 
            ], 200); 
        }  

        // Get current cart from session
        $cart = Session::get('cart', []);

        // Update product quantity
        if (isset($cart[$productId])) {
            $cart[$productId] = $quantity;
            Session::put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Cart updated successfully',
                'cartCount' => count($cart),
                'cartTotal' => $this->getCartTotal($cart)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'Product not found in cart'
        ], 404);
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

        $productId = $request->input('product_id');

        // Get current cart from session
        $cart = Session::get('cart', []);

        // Remove product from cart
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Product removed from cart',
                'cartCount' => count($cart),
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

        foreach ($cart as $productId => $quantity) {
            $product = Product::find($productId);
            if ($product) {
                $total += $product->price * $quantity;
            }
        }

        return $total;
    }
}
