<?php

namespace App\Services;

use App\Models\PaymentHistory;
use App\Models\User;
use Illuminate\Support\Facades\Log;

/**
 * Saved card handling, shared by the member dashboard and the admin panel.
 *
 * Nothing here ever returns raw card data: Stripe only hands back the brand,
 * last four digits and expiry, and that is all this service exposes. Full card
 * numbers never reach the application, so they can never reach a view.
 */
class PaymentMethodService
{
    /**
     * The member's saved cards, as display-safe arrays.
     *
     * @return array<int, array{id: string, brand: string, last4: string, exp_month: int, exp_year: int, is_default: bool, is_display_only?: bool}>
     */
    public function listCards(User $user): array
    {
        try {
            StripeService::configure();

            // A member may have paid before we started storing the customer id.
            // Match on email so their existing cards are not orphaned.
            if (!$user->stripe_customer_id) {
                $customers = \Stripe\Customer::all(['email' => $user->email, 'limit' => 1]);
                if ($customers->data) {
                    $user->stripe_customer_id = $customers->data[0]->id;
                    $user->save();
                }
            }

            $customer = $this->getOrCreateCustomer($user);

            $paymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customer->id,
                'type' => 'card',
            ]);

            if (count($paymentMethods->data) === 0) {
                return $this->cardsFromPaymentHistory($user);
            }

            $defaultId = $customer->invoice_settings->default_payment_method ?? null;
            $defaultId = is_string($defaultId) ? $defaultId : ($defaultId->id ?? null);

            $cards = [];
            foreach ($paymentMethods->data as $paymentMethod) {
                $card = $paymentMethod->card;
                $cards[] = [
                    'id' => $paymentMethod->id,
                    'brand' => $card->brand,
                    'last4' => $card->last4,
                    'exp_month' => $card->exp_month,
                    'exp_year' => $card->exp_year,
                    'is_default' => $paymentMethod->id === $defaultId,
                ];
            }

            return $cards;
        } catch (\Exception $e) {
            Log::error('Error getting saved payment methods: ' . $e->getMessage(), ['user_id' => $user->id]);
            return [];
        }
    }

    /**
     * Last resort when Stripe reports no attached cards: show what the most
     * recent payment recorded, flagged so the UI can disable actions on it.
     *
     * The card is not attached to the customer, so it cannot be charged, made
     * default or detached — it is a receipt, not a payment method.
     *
     * @return array<int, array<string, mixed>>
     */
    private function cardsFromPaymentHistory(User $user): array
    {
        $recentPayments = PaymentHistory::where('user_id', $user->id)
            ->where('created_at', '>=', now()->subDays(7))
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($recentPayments as $payment) {
            $cardDetails = json_decode((string) $payment->card_details, true);

            if (!empty($cardDetails['last4'])) {
                return [[
                    'id' => 'display_' . $payment->id,
                    'brand' => $cardDetails['brand'] ?? 'card',
                    'last4' => $cardDetails['last4'],
                    'exp_month' => $cardDetails['exp_month'] ?? null,
                    'exp_year' => $cardDetails['exp_year'] ?? null,
                    'is_default' => true,
                    'is_display_only' => true,
                ]];
            }
        }

        return [];
    }

    /**
     * Whether Stripe holds a card that could be charged off-session.
     */
    public function hasSavedCard(User $user): bool
    {
        if (!$user->stripe_customer_id) {
            return false;
        }

        try {
            StripeService::configure();
            $methods = \Stripe\PaymentMethod::all([
                'customer' => $user->stripe_customer_id,
                'type' => 'card',
                'limit' => 1,
            ]);

            return count($methods->data) > 0;
        } catch (\Exception $e) {
            Log::error('Could not check saved cards: ' . $e->getMessage(), ['user_id' => $user->id]);
            return false;
        }
    }

    /**
     * Fetch the member's Stripe customer, creating one if they have none.
     *
     * @return \Stripe\Customer
     */
    public function getOrCreateCustomer(User $user)
    {
        try {
            StripeService::configure();

            if ($user->stripe_customer_id) {
                return \Stripe\Customer::retrieve($user->stripe_customer_id);
            }

            $customer = \Stripe\Customer::create([
                'email' => $user->email,
                'name' => trim($user->first_name . ' ' . $user->last_name),
                'phone' => $user->phone,
            ]);

            $user->stripe_customer_id = $customer->id;
            $user->save();

            return $customer;
        } catch (\Exception $e) {
            Log::error('Error creating/retrieving Stripe customer: ' . $e->getMessage(), ['user_id' => $user->id]);
            throw $e;
        }
    }

    /**
     * Detach a saved card from the member.
     *
     * @return array{success: bool, message: string}
     */
    public function detach(User $user, string $paymentMethodId): array
    {
        try {
            StripeService::configure();

            $customer = $this->getOrCreateCustomer($user);
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

            // Guards against one member's id being used to remove another's card.
            if ($paymentMethod->customer !== $customer->id) {
                return ['success' => false, 'message' => 'Payment method not found'];
            }

            if ($paymentMethod->id === ($customer->invoice_settings->default_payment_method ?? null)) {
                return ['success' => false, 'message' => 'Cannot delete default payment method'];
            }

            $paymentMethod->detach();

            return ['success' => true, 'message' => 'Payment method deleted successfully'];
        } catch (\Exception $e) {
            Log::error('Error deleting payment method: ' . $e->getMessage(), ['user_id' => $user->id]);
            return ['success' => false, 'message' => 'Error deleting payment method'];
        }
    }

    /**
     * Make a saved card the one future off-session charges use.
     *
     * @return array{success: bool, message: string}
     */
    public function setDefault(User $user, string $paymentMethodId): array
    {
        try {
            StripeService::configure();

            $customer = $this->getOrCreateCustomer($user);
            $paymentMethod = \Stripe\PaymentMethod::retrieve($paymentMethodId);

            if ($paymentMethod->customer !== $customer->id) {
                return ['success' => false, 'message' => 'Payment method not found'];
            }

            $customer->invoice_settings->default_payment_method = $paymentMethod->id;
            $customer->save();

            return ['success' => true, 'message' => 'Default payment method updated successfully'];
        } catch (\Exception $e) {
            Log::error('Error setting default payment method: ' . $e->getMessage(), ['user_id' => $user->id]);
            return ['success' => false, 'message' => 'Error updating default payment method'];
        }
    }
}
