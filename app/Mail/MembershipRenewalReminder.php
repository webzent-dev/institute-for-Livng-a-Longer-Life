<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MembershipRenewalReminder extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $user;
    public $daysLeft;
    public $expiryDate;

    public function __construct(User $user, int $daysLeft)
    {
        $this->user = $user;
        $this->daysLeft = $daysLeft;
        $this->expiryDate = \Carbon\Carbon::parse($user->plan_expiry);
    }

    public function build()
    {
        $subject = $this->daysLeft <= 0
            ? 'Your membership has expired — renew to restore access'
            : 'Your membership expires in ' . $this->daysLeft . ' ' . \Illuminate\Support\Str::plural('day', $this->daysLeft);

        return $this->subject($subject)
            ->view('emails.membership-renewal-reminder');
    }
}
