<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Verifies the HMAC-SHA256 signature on incoming Shopify-app webhooks.
 *
 * The app signs the raw request body with the shared secret and sends the
 * base64-encoded digest in the X-Shopify-Hmac-Sha256 header.
 */
class VerifyShopifyWebhook
{
    public function handle(Request $request, Closure $next): Response
    {
        $secret = config('services.shopify_app.webhook_secret');
        $provided = $request->header('X-Shopify-Hmac-Sha256');

        if (empty($secret) || empty($provided)) {
            Log::warning('Shopify webhook rejected: missing secret or signature header.');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $calculated = base64_encode(hash_hmac('sha256', $request->getContent(), $secret, true));

        if (!hash_equals($calculated, $provided)) {
            Log::warning('Shopify webhook rejected: HMAC signature mismatch.');
            return response()->json(['error' => 'Invalid signature'], 401);
        }

        return $next($request);
    }
}
