<?php

use App\Http\Controllers\Api\MemberApiController;
use App\Http\Middleware\ApiKeyAuth;
use Illuminate\Support\Facades\Route;

Route::middleware(ApiKeyAuth::class)->prefix('v1')->group(function () {
    Route::post('/member/validate', [MemberApiController::class, 'validateMember']);
    Route::get('/member/{membershipNumber}/status', [MemberApiController::class, 'memberStatus']);
});
