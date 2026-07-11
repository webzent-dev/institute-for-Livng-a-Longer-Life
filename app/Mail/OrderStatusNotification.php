<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Order;

class OrderStatusNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $order;
    public $subOrder;

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order) {
        $this->order = $order;
        $this->subOrder = $order->subOrders()->first(); // Get the first sub-order associated with the order
    }

    public function build()
    {
        return $this->subject('Order Status Update')
        ->view('emails.order_status_notification');
    }

}