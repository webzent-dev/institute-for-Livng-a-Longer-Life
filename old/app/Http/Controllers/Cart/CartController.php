<?php

namespace App\Http\Controllers\Cart;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
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

        foreach ($cart as $productId => $quantity) {
            //Get product detail with user detail
            $product = Product::with('user')->find($productId);
            //$product = Product::find($productId);
            if ($product) {
                $itemTotal = $product->price * $quantity;
                $total += $itemTotal;
                $cartItems[] = [
                    // 'product' => $product,
                    // 'quantity' => $quantity,
                    // 'itemTotal' => $itemTotal,
                    'id' => $product->id,
                    'name' => $product->name,
                    'vendor' => $product->user->name,
                    'quantity' => $quantity,
                    'itemTotal' => $itemTotal,
                    'price' => $product->price,
                    'originalPrice' => $product->originalPrice,
                    'image' =>  $product->image ? asset('product_images/' . $product->image) : null
                ];
            }
        }

        return view('front.pages.cart', [
            'cartItems' => $cartItems,
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
        $product = Product::find($productId);
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

            // Add or update product in cart
            if (isset($cart[$productId])) {
                $cart[$productId] += $quantity;
            } else {
                $cart[$productId] = $quantity;
            }

            // Store updated cart in session
            Session::put('cart', $cart);

            return response()->json([
                'status' => true,
                'message' => 'Product added to cart successfully',
                'cartCount' => count($cart),
                'cartTotal' => $this->getCartTotal($cart)
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
