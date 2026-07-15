<?php

namespace App\Mail;

use App\Models\VitalBoostSubscription;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VitalBoostRenewalReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $subscription;
    public $daysLeft;
    public $renewalDate;

    public function __construct(VitalBoostSubscription $subscription, int $daysLeft)
    {
        $this->subscription = $subscription;
        $this->daysLeft = $daysLeft;
        $this->renewalDate = $subscription->next_billing_at;
    }

    public function build()
    {
        $subject = $this->daysLeft <= 0
            ? 'Your Vital Boost subscription is due for renewal'
            : 'Your Vital Boost subscription renews in ' . $this->daysLeft . ' ' . \Illuminate\Support\Str::plural('day', $this->daysLeft);

        return $this->subject($subject)
            ->view('emails.vital-boost-renewal-reminder');
    }
}
