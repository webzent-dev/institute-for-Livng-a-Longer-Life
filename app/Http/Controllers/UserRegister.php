<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Membership;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\MemberSignupMail;
use App\Mail\AdminMemberNotification;

class UserRegister extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|unique:users,email',
            'phone'      => 'required|numeric|unique:users,phone',
            'password'   => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name'  => $validated['last_name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'],
            'password'   => Hash::make($validated['password']),
        ]);

        $user->update([
            'membership_number' => User::generateMembershipNumber(),
        ]);

        // The member chose their own password on the signup form, so no reset link is
        // sent — the welcome mail tells them to sign in with those credentials.
        if(!empty($request->email)){
            Mail::to($request->email)->send(
                new MemberSignupMail($user)
            );
        }

        //Send email to admin for new member registration
        $adminDetail = User::where('role', 'admin')->first();
        $adminEmail = $adminDetail ? $adminDetail->email : null;
        if(!empty($adminEmail)){
            Mail::to($adminEmail)->send(
                new AdminMemberNotification($user)
            );
        }

        /************Stripe payment start here****************/
        $plan_id = $request->plan_id;
        $planDetail = Membership::find($plan_id);
        session(['planDetail'=>$planDetail]);
        session(['user_id'=>$user->id]);

        \App\Services\StripeService::configure();

        $session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $planDetail['membership_name'],
                        'description' => $planDetail['membership_name']
                    ],
                    'unit_amount' => (int)($planDetail['membership_price'] * 100), // Dynamic total in cents
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'invoice_creation' => [
                'enabled' => true
            ],
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);
        //return redirect($session->url, 303);
        return response()->json([
            'message' => 'Registration successful! Redirecting to payment...',
            'redirect' => $session->url, // This is the Stripe URL
        ]);
        /************Stripe payment end here*****************/

        /*return response()->json([
            'message' => 'Registration successful. Please wait for admin approval.'
        ]);*/
    }
}