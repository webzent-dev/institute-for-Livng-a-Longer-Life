<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MemberApiController extends Controller
{
    /**
     * Validate a membership number and return its tier + discount.
     */
    public function validateMember(Request $request)
    {
        $request->validate([
            'membership_number' => 'required|string',
        ]);

        $user = User::where('membership_number', $request->membership_number)
            ->where('role', 'user')
            ->first();

        if (!$user) {
            return response()->json([
                'valid' => false,
                'message' => 'Member not found',
            ], 404);
        }

        return response()->json([
            'valid' => $this->isActiveMember($user),
            'membership_number' => $user->membership_number,
            'tier' => $user->plan_name,
            'discount_percent' => $this->getDiscountPercent($user->plan_name),
            'expires_at' => $user->plan_expiry,
            'status' => $user->status,
        ]);
    }

    /**
     * Return the current status of a member by membership number.
     */
    public function memberStatus(string $membershipNumber)
    {
        $user = User::where('membership_number', $membershipNumber)
            ->where('role', 'user')
            ->first();

        if (!$user) {
            return response()->json([
                'found' => false,
            ], 404);
        }

        return response()->json([
            'found' => true,
            'membership_number' => $user->membership_number,
            'tier' => $user->plan_name,
            'discount_percent' => $this->getDiscountPercent($user->plan_name),
            'is_active' => $this->isActiveMember($user),
            'expires_at' => $user->plan_expiry,
        ]);
    }

    /**
     * A member is active when their account is active and the plan has not expired.
     */
    private function isActiveMember(User $user): bool
    {
        return $user->status === 'active'
            && !empty($user->plan_expiry)
            && Carbon::parse($user->plan_expiry)->isFuture();
    }

    private function getDiscountPercent(?string $planName): int
    {
        return match (strtolower($planName ?? '')) {
            'standard' => 5,
            'premium' => 10,
            'lifetime' => 20,
            default => 0,
        };
    }
}
