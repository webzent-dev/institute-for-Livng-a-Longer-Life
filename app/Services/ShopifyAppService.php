<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Client for the Standard Process Shopify embedded app.
 *
 * Manages the member discount codes that live in Shopify. All calls are
 * best-effort: a failure here must never break a membership operation, so
 * every method catches its own errors and returns a boolean instead of
 * throwing.
 *
 * Expected Shopify-app contract (adjust paths to match the deployed app):
 *   POST {base_url}/api/discount/revoke      { membership_number }
 *   POST {base_url}/api/discount/reactivate  { membership_number }
 *   POST {base_url}/api/discount/update      { membership_number, discount_percent }
 * Authenticated with the shared X-API-Key header.
 */
class ShopifyAppService
{
    protected ?string $baseUrl;
    protected ?string $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('services.shopify_app.base_url');
        $this->apiKey = config('services.shopify_app.api_key');
    }

    /**
     * Revoke a member's discount code (cancellation / expiry).
     */
    public function revokeDiscountCode(string $membershipNumber): bool
    {
        return $this->call('/api/discount/revoke', [
            'membership_number' => $membershipNumber,
        ]);
    }

    /**
     * Reactivate a previously revoked discount code (renewal / reactivation).
     */
    public function reactivateDiscountCode(string $membershipNumber): bool
    {
        return $this->call('/api/discount/reactivate', [
            'membership_number' => $membershipNumber,
        ]);
    }

    /**
     * Update a member's discount percentage (tier change).
     */
    public function updateDiscountPercent(string $membershipNumber, int $percent): bool
    {
        return $this->call('/api/discount/update', [
            'membership_number' => $membershipNumber,
            'discount_percent' => $percent,
        ]);
    }

    /**
     * Sync an active member: make sure their code is active and set to the
     * correct tier percentage. Used on renewal / tier change / activation.
     */
    public function syncActiveMember(User $user): void
    {
        if (empty($user->membership_number)) {
            return;
        }

        $this->reactivateDiscountCode($user->membership_number);
        $this->updateDiscountPercent(
            $user->membership_number,
            self::discountPercentFor($user->plan_name)
        );
    }

    /**
     * Revoke a member's code (deactivation / cancellation).
     */
    public function revokeForMember(User $user): void
    {
        if (!empty($user->membership_number)) {
            $this->revokeDiscountCode($user->membership_number);
        }
    }

    /**
     * Map a plan/tier name to its discount percentage.
     */
    public static function discountPercentFor(?string $planName): int
    {
        return match (strtolower($planName ?? '')) {
            'standard' => 5,
            'premium' => 10,
            'lifetime' => 20,
            default => 0,
        };
    }

    /**
     * Perform a best-effort POST to the Shopify app. Never throws.
     */
    protected function call(string $path, array $payload): bool
    {
        if (empty($this->baseUrl) || empty($this->apiKey)) {
            Log::info('ShopifyAppService skipped (base_url/api_key not configured): ' . $path);
            return false;
        }

        try {
            $response = Http::withHeaders([
                'X-API-Key' => $this->apiKey,
                'Accept' => 'application/json',
            ])->timeout(10)->post(rtrim($this->baseUrl, '/') . $path, $payload);

            if ($response->successful()) {
                return true;
            }

            Log::warning('ShopifyAppService call failed: ' . $path . ' [' . $response->status() . '] ' . $response->body());
            return false;
        } catch (\Throwable $e) {
            Log::error('ShopifyAppService exception on ' . $path . ': ' . $e->getMessage());
            return false;
        }
    }
}
