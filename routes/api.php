<?php

use App\Http\Controllers\Api\MemberApiController;
use App\Http\Controllers\Api\ShopifyWebhookController;
use App\Http\Middleware\ApiKeyAuth;
use App\Http\Middleware\VerifyShopifyWebhook;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiKeyAuth::class)->prefix('v1')->group(function () {
    Route::post('/member/validate', [MemberApiController::class, 'validateMember']);
    Route::get('/member/{membershipNumber}/status', [MemberApiController::class, 'memberStatus']);
});

// Incoming webhook from the Shopify app — HMAC-verified (no API key).
Route::post('/shopify/webhook', [ShopifyWebhookController::class, 'handle'])
    ->middleware(VerifyShopifyWebhook::class);
