<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderConfirmationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $order;
    public $orderItems;

    /** @var array<int, array{name:string, url:string}> Signed download links for purchased guides. */
    public $guideDownloads;

    public function __construct($order, $orderItems, $guideDownloads = [])
    {
        $this->order = $order;
        $this->orderItems = $orderItems;
        $this->guideDownloads = $guideDownloads;
    }

    public function build()
    {
        // Downloadable guides are delivered as signed download links in the body
        // (see emails.order-confirmation) rather than as attachments, which bloat
        // the message and get bounced as "too large".
        return $this->subject('Order Confirmation')
            ->view('emails.order-confirmation');
    }
}
