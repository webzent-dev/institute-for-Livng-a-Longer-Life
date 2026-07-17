<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CollaboratorOrderNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $order;
    public $orderItems;
    public $collaboratorProductIds;
    public $collaboratorName;

    /**
     * Create a new message instance.
     */
    public function __construct($order, $orderItems, $collaboratorProductIds, $collaboratorName)
    {
        $this->order = $order;
        $this->orderItems = $orderItems;
        $this->collaboratorProductIds = $collaboratorProductIds;
        $this->collaboratorName = $collaboratorName;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Collaborator Order Notification',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.collaborator-order-notification',
            with: [
                'order' => $this->order,
                'orderItems' => $this->orderItems,
                'collaboratorProductIds' => $this->collaboratorProductIds,
                'collaboratorName' => $this->collaboratorName,
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
