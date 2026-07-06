<?php

namespace App\Services;

use App\Mail\AdminOrderNotification;
use App\Mail\CollaboratorOrderNotification;
use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\PaymentHistory;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Services\StripeService;

class OrderFulfilmentService
{
    /**
     * Run all post-payment side-effects for a completed Stripe checkout session.
     * Safe to call from both the browser redirect (success()) and the webhook.
     * Idempotent: returns early if the order is already marked paid or already
     * has a PaymentHistory row for this payment intent.
     */
    public function fulfil(Order $order, \Stripe\Checkout\Session $stripeSession): void
    {
        // Idempotency guard — order already fulfilled
        if ($order->payment_status === 'completed') {
            return;
        }

        $this->setStripeKey();

        $orderItems = OrderItem::where('order_id', $order->id)->get();

        // Decrement stock
        foreach ($orderItems as $orderItem) {
            $product = Product::find($orderItem->product_id);
            if ($product) {
                $product->update(['stock' => $product->stock - $orderItem->quantity]);
            }
        }

        // Customer confirmation email
        if (!empty($order->email)) {
            Mail::to($order->email)->send(new OrderConfirmationMail($order, $orderItems));
        }

        // Collaborator notification emails
        foreach ($orderItems as $orderItem) {
            $product = Product::with('user')->where('id', $orderItem->product_id)->first();
            if ($product && $product->user->role === 'collaborator') {
                $collaboratorName = $product->user->first_name . ' ' . $product->user->last_name;
                $collaboratorProductIds = Product::where('user_id', $product->user->id)
                    ->pluck('id')
                    ->toArray();

                if (!empty($product->user->email)) {
                    Mail::to($product->user->email)->send(
                        new CollaboratorOrderNotification($order, $orderItems, $collaboratorProductIds, $collaboratorName)
                    );
                }
            }
        }

        // Admin notification email
        $adminDetail = User::where('role', 'admin')->first();
        $adminEmail  = $adminDetail ? $adminDetail->email : null;
        if (!empty($adminEmail)) {
            Mail::to($adminEmail)->send(new AdminOrderNotification($order, $orderItems));
        }

        // Retrieve Stripe payment details
        $paymentIntent = PaymentIntent::retrieve($stripeSession->payment_intent);
        $lineItems     = \Stripe\Checkout\Session::allLineItems($stripeSession->id);
        $description   = $lineItems->data[0]->description ?? '';

        $data = [
            'transaction_id' => $paymentIntent->id,
            'description'    => $description,
            'payment_method' => $paymentIntent->payment_method_types[0] ?? null,
            'amount'         => $paymentIntent->amount / 100,
            'currency'       => $paymentIntent->currency,
            'status'         => $paymentIntent->status,
        ];

        // Mark order paid
        if ($paymentIntent->status === 'succeeded') {
            $order->update(['payment_status' => 'completed']);
        }

        // Card details
        $paymentMethod = PaymentMethod::retrieve($paymentIntent->payment_method);
        $card          = $paymentMethod->card;
        $cardDetails   = [
            'brand'     => $card->brand,
            'last4'     => $card->last4,
            'exp_month' => $card->exp_month,
            'exp_year'  => $card->exp_year,
        ];

        // Invoice details
        $invoice        = Invoice::retrieve($stripeSession->invoice);
        $invoiceDetails = [
            'invoice_id'     => $invoice->id,
            'invoice_number' => $invoice->number,
            'invoice_pdf'    => $invoice->invoice_pdf,
        ];

        // Receipt details
        $charge         = Charge::retrieve($paymentIntent->latest_charge);
        $receiptDetails = ['receipt_url' => $charge->receipt_url];

        // PaymentHistory — idempotent by transaction_id
        $existing = PaymentHistory::where('transaction_id', $data['transaction_id'])->first();
        if (empty($existing)) {
            PaymentHistory::create([
                'user_id'        => $order->user_id,
                'transaction_id' => $data['transaction_id'],
                'description'    => $data['description'],
                'payment_method' => $data['payment_method'],
                'amount'         => $data['amount'],
                'card_details'   => json_encode($cardDetails),
                'invoice_detail' => json_encode($invoiceDetails),
                'receipt_detail' => json_encode($receiptDetails),
                'payment_for'    => 'order',
                'status'         => $data['status'],
                'created_at'     => Carbon::now(),
            ]);
        }
    }

    private function setStripeKey(): void
    {
        StripeService::configure();
    }
}
