<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MembershipController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'firstName' => 'required|string|max:50',
            'lastName' => 'required|string|max:50',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|min:10|max:20',
            'password' => 'required|string|min:8|max:100|confirmed', // expects password_confirmation if sent; JS sends confirmPassword so we handle below
            'plan' => 'required|string',
        ], [
            'password.confirmed' => "Passwords don't match",
        ]);

        // Because the Alpine form sends confirmPassword, not password_confirmation, normalize
        if (!$request->has('password_confirmation') && $request->has('confirmPassword')) {
            $request->merge(['password_confirmation' => $request->input('confirmPassword')]);
        }

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors()->toArray()
            ], 422);
        }

        // TODO: create user, attach membership, send email, etc.
        // Example pseudo:
        // $user = User::create([...]);
        // $user->assignPlan($data['plan']);

        // return JSON success, optionally redirect to thank-you
        return response()->json([
            'message' => 'Registration successful',
            'redirect' => route('thank-you') // optional route you should define
        ], 200);
    }
}
