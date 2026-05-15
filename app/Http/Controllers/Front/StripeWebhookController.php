<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderFulfilmentService;
use Illuminate\Http\Request;

class StripeWebhookController extends Controller
{
    public function __construct(protected OrderFulfilmentService $fulfilmentService)
    {
    }

    public function handle(Request $request)
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        } catch (\UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        }

        if ($event->type === 'checkout.session.completed') {
            /** @var \Stripe\Checkout\Session $stripeSession */
            $stripeSession = $event->data->object;
            $orderId       = $stripeSession->metadata->order_id ?? null;

            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    $this->fulfilmentService->fulfil($order, $stripeSession);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }
}
