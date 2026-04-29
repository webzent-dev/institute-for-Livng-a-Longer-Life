<?php

namespace App\Mail;

use App\Models\SubOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubOrderNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $subOrder;
    public $subject;
    public $order;

    /**
     * Create a new message instance.
     */
    public function __construct(SubOrder $subOrder, string $subject = 'New Sub-Order Notification')
    {
        $this->subOrder = $subOrder;
        $this->order = $subOrder->order;
        $this->subject = $subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.sub-order-notification',
            with: [
                'subOrder' => $this->subOrder,
                'order' => $this->order,
                'customerName' => $this->order->first_name . ' ' . $this->order->last_name,
                'sellerName' => $this->subOrder->seller->first_name . ' ' . $this->subOrder->seller->last_name,
                'items' => $this->subOrder->items,
                'shippingAddress' => $this->subOrder->destination_address,
                'originAddress' => $this->subOrder->origin_address,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
