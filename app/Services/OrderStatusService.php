<?php

namespace App\Services;

use App\Mail\OrderStatusNotification;
use App\Models\Order;
use App\Models\SubOrder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Moving an order (or one seller's sub-order) to a new status, and telling the
 * customer about it.
 *
 * The orders screen and the member profile screen both drive order status, so
 * the notification rules live here rather than in either controller.
 */
class OrderStatusService
{
    /**
     * Statuses an order or sub-order can be moved to.
     */
    public const STATUSES = [
        'pending',
        'confirmed',
        'processing',
        'shipped',
        'delivered',
        'cancelled',
    ];

    /**
     * Set the status on the whole order and notify the customer.
     *
     * @return array{ok: bool, message: string}
     */
    public function updateOrder(Order $order, string $status): array
    {
        if (!in_array($status, self::STATUSES, true)) {
            return ['ok' => false, 'message' => 'That is not a valid order status.'];
        }

        if ($order->status === $status) {
            return ['ok' => false, 'message' => 'The order is already ' . $status . '.'];
        }

        $order->status = $status;
        $order->save();

        $this->notifyCustomer($order);

        return ['ok' => true, 'message' => 'Order status has been updated successfully.'];
    }

    /**
     * Set the status on a single seller's sub-order.
     *
     * The parent order only follows once every seller agrees — one seller
     * shipping their parcel doesn't make the whole order shipped.
     *
     * @return array{ok: bool, message: string}
     */
    public function updateSubOrder(SubOrder $subOrder, string $status): array
    {
        if (!in_array($status, self::STATUSES, true)) {
            return ['ok' => false, 'message' => 'That is not a valid order status.'];
        }

        $subOrder->status = $status;
        $subOrder->save();

        $order = $subOrder->order;

        if ($order && $order->syncStatusFromSubOrders()) {
            $this->notifyCustomer($order);
        }

        return ['ok' => true, 'message' => 'Sub-order status has been updated successfully.'];
    }

    /**
     * Email the customer their new order status.
     *
     * A failed send must not roll back a status change the admin already made,
     * so the error is logged rather than thrown.
     */
    private function notifyCustomer(Order $order): void
    {
        if (empty($order->email)) {
            return;
        }

        try {
            Mail::to($order->email)->send(new OrderStatusNotification($order));
        } catch (\Exception $e) {
            Log::error('Could not send order status email: ' . $e->getMessage(), [
                'order_id' => $order->id,
            ]);
        }
    }
}
