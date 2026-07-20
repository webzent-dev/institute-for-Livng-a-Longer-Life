<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShopifyRedemption;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

class ShopifyWebhookController extends Controller
{
    /**
     * Receive a discount-code redemption event from the Shopify app.
     * The request has already passed HMAC verification (VerifyShopifyWebhook).
     */
    public function handle(Request $request)
    {
        $payload = $request->all();

        $membershipNumber = $payload['membership_number'] ?? $payload['discount_code'] ?? null;

        $user = $membershipNumber
            ? User::where('membership_number', $membershipNumber)->first()
            : null;

        $redeemedAt = !empty($payload['redeemed_at'])
            ? Carbon::parse($payload['redeemed_at'])
            : now();

        $orderAmount = $payload['order_amount'] ?? $payload['total_price'] ?? null;

        $redemption = ShopifyRedemption::create([
            'user_id' => $user?->id,
            'membership_number' => $membershipNumber,
            'discount_code' => $payload['discount_code'] ?? $membershipNumber,
            'shopify_order_id' => $payload['order_id'] ?? $payload['shopify_order_id'] ?? null,
            'order_amount' => $orderAmount !== null ? (string) $orderAmount : null,
            'currency' => $payload['currency'] ?? null,
            'redeemed_at' => $redeemedAt,
            'payload' => $payload,
        ]);


        return response()->json(['received' => true, 'id' => $redemption->id]);
    }
}
