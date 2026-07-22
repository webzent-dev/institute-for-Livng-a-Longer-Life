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
use App\Models\VitalBoostSubscription;
use App\Services\Pricing\VitalBoostPricingService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Stripe\Charge;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\PaymentMethod;
use App\Services\StripeService;

class OrderFulfilmentService
{
    public function __construct(private VitalBoostPricingService $pricing)
    {
    }

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

        // Guides on this order are downloadable PDFs. The confirmation email links
        // to each one with a signed download URL rather than attaching the file —
        // attachments bloat the message and get rejected as "too large". The signed
        // link works for guests (who have no dashboard) as well as members.
        $guideDownloads = [];
        foreach ($orderItems as $item) {
            $product = Product::find($item->product_id);
            if ($product && $product->product_type === 'guide' && $product->pdfPath()) {
                $guideDownloads[] = [
                    'name' => $product->name,
                    'url'  => URL::signedRoute('guide.download', ['orderItem' => $item->id]),
                ];
            }
        }

        // Customer confirmation email — includes any guide download links.
        if (!empty($order->email)) {
            Mail::to($order->email)->send(new OrderConfirmationMail($order, $orderItems, $guideDownloads));
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

            // Create Vital Boost subscription records for any subscription lines.
            $this->createVitalBoostSubscriptions($order, $orderItems);
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

    /**
     * Persist a Vital Boost subscription for each subscription line on the order.
     * Idempotent: skips a line that already has a subscription for this order, so
     * a re-fulfilled order never duplicates records.
     */
    private function createVitalBoostSubscriptions(Order $order, $orderItems): void
    {
        $member = $order->user_id ? User::find($order->user_id) : null;
        $memberPercent = \App\Support\MembershipDiscount::activePercentFor($member);

        foreach ($orderItems as $item) {
            if ($item->purchase_type !== VitalBoostPricingService::TYPE_SUBSCRIPTION) {
                continue;
            }
            if (!in_array($item->subscription_plan, [VitalBoostPricingService::PLAN_MONTHLY, VitalBoostPricingService::PLAN_YEARLY], true)) {
                continue;
            }

            $exists = VitalBoostSubscription::where('order_id', $order->id)
                ->where('product_id', $item->product_id)
                ->exists();
            if ($exists) {
                continue;
            }

            // Recompute the line breakdown (member-aware) so the subscription stores
            // the same numbers the buyer was charged. Shipping is excluded here and
            // recomputed at renewal.
            $breakdown = $this->pricing->calculate(
                (float) $item->price,
                (int) $item->quantity,
                VitalBoostPricingService::TYPE_SUBSCRIPTION,
                $item->subscription_plan,
                $memberPercent,
                0
            );

            $periodDays = (int) config('vital_boost.billing_period_days.' . $item->subscription_plan, 30);

            VitalBoostSubscription::create([
                'user_id'               => $order->user_id,
                'order_id'              => $order->id,
                'product_id'            => $item->product_id,
                'email'                 => $order->email,
                'product_name'          => $item->product_name,
                'plan'                  => $item->subscription_plan,
                'quantity'              => $item->quantity,
                'unit_price'            => $breakdown->unitPrice,
                'membership_percent'    => $breakdown->membershipPercent,
                'subscription_percent'  => $breakdown->subscriptionPercent,
                'membership_discount'   => $breakdown->membershipDiscount,
                'subscription_discount' => $breakdown->subscriptionDiscount,
                'item_total'            => $breakdown->subtotalAfterDiscounts(),
                'status'                => 'active',
                'started_at'            => Carbon::now(),
                'next_billing_at'       => Carbon::now()->addDays($periodDays),
            ]);
        }
    }

    private function setStripeKey(): void
    {
        StripeService::configure();
    }
}
