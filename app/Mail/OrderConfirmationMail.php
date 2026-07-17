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

    public function __construct($order, $orderItems)
    {
        $this->order = $order;
        $this->orderItems = $orderItems;
    }

    public function build()
    {
        return $this->subject('Order Confirmation')
        ->view('emails.order-confirmation');
    }
}