<?php

namespace App\Services;

use App\Models\Membership;
use App\Models\PaymentHistory;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;

class MembershipRenewalService
{
    /**
     * Work out the new expiry date for a member paying for a plan.
     *
     * Renewing the SAME plan before it lapses stacks the new period on top of the
     * remaining time, so nobody loses days by renewing early. New purchases and
     * tier changes start from today. Mirrors IndexController::getTransactionDetail().
     */
    public function nextExpiry(User $user, Membership $plan): Carbon
    {
        $baseDate = Carbon::now();

        if (!empty($user->plan_expiry)
            && (int) $user->plan_id === (int) $plan->id
            && Carbon::parse($user->plan_expiry)->isFuture()) {
            $baseDate = Carbon::parse($user->plan_expiry);
        }

        return match (strtolower((string) $plan->membership_period)) {
            'month' => $baseDate->copy()->addDays(30),
            'year'  => $baseDate->copy()->addDays(365),
            default => $baseDate->copy()->addYears(100), // lifetime
        };
    }

    /**
     * Charge the member's saved card without them present and extend the membership.
     *
     * Only ever called for members who switched auto-renewal on and have not
     * cancelled — the caller is responsible for checking shouldAutoRenew().
     *
     * @return array{ok: bool, message: string, requires_action?: bool}
     */
    public function renewOffSession(User $user): array
    {
        $plan = Membership::find($user->plan_id);
        if (!$plan) {
            return ['ok' => false, 'message' => 'Member has no plan to renew.'];
        }

        if (!$user->stripe_customer_id) {
            return ['ok' => false, 'message' => 'No saved payment profile.'];
        }

        StripeService::configure();

        $paymentMethodId = $this->defaultPaymentMethodId($user);
        if (!$paymentMethodId) {
            return ['ok' => false, 'message' => 'No saved card to charge.'];
        }

        try {
            $intent = PaymentIntent::create([
                'amount'         => (int) round($plan->membership_price * 100),
                'currency'       => 'usd',
                'customer'       => $user->stripe_customer_id,
                'payment_method' => $paymentMethodId,
                // The member is not in the browser, so Stripe must not try to
                // redirect them through a 3-D Secure challenge.
                'off_session'    => true,
                'confirm'        => true,
                'description'    => 'Membership renewal — ' . $plan->membership_name,
                'metadata'       => [
                    'user_id'      => $user->id,
                    'plan_id'      => $plan->id,
                    'payment_for'  => 'membership_auto_renewal',
                ],
            ]);
        } catch (\Stripe\Exception\CardException $e) {
            // The commonest off-session failure: the bank wants the cardholder
            // to authenticate. Nothing to do but ask them to renew by hand.
            $code = $e->getError()->code ?? '';
            Log::warning('Membership auto-renewal declined', [
                'user_id' => $user->id,
                'code'    => $code,
            ]);

            return [
                'ok' => false,
                'requires_action' => $code === 'authentication_required',
                'message' => $e->getError()->message ?? 'The card was declined.',
            ];
        } catch (\Exception $e) {
            Log::error('Membership auto-renewal failed: ' . $e->getMessage(), ['user_id' => $user->id]);

            return ['ok' => false, 'message' => 'Renewal could not be processed.'];
        }

        if ($intent->status !== 'succeeded') {
            return ['ok' => false, 'message' => 'Payment did not complete (' . $intent->status . ').'];
        }

        $this->applyRenewal($user, $plan, $intent);

        return ['ok' => true, 'message' => 'Membership renewed.'];
    }

    /**
     * Extend the membership and record the payment. Idempotent per PaymentIntent.
     */
    public function applyRenewal(User $user, Membership $plan, PaymentIntent $intent): void
    {
        if (PaymentHistory::where('transaction_id', $intent->id)->exists()) {
            return;
        }

        $user->update([
            'plan_expiry' => $this->nextExpiry($user, $plan),
        ]);

        PaymentHistory::create([
            'user_id'        => $user->id,
            'transaction_id' => $intent->id,
            'description'    => 'Membership renewal — ' . $plan->membership_name,
            'payment_method' => $intent->payment_method_types[0] ?? 'card',
            'amount'         => $intent->amount / 100,
            'payment_for'    => 'membership',
            'status'         => $intent->status,
            'created_at'     => Carbon::now(),
        ]);

        app(ShopifyAppService::class)->syncActiveMember($user);
    }

    /**
     * The card Stripe will charge: the customer's invoice default, else the newest.
     */
    private function defaultPaymentMethodId(User $user): ?string
    {
        try {
            $customer = \Stripe\Customer::retrieve($user->stripe_customer_id);
            $default = $customer->invoice_settings->default_payment_method ?? null;
            if ($default) {
                return is_string($default) ? $default : $default->id;
            }

            $methods = \Stripe\PaymentMethod::all([
                'customer' => $user->stripe_customer_id,
                'type'     => 'card',
                'limit'    => 1,
            ]);

            return $methods->data[0]->id ?? null;
        } catch (\Exception $e) {
            Log::error('Could not resolve payment method: ' . $e->getMessage(), ['user_id' => $user->id]);
            return null;
        }
    }
}
