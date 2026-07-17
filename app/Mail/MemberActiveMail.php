<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class MemberActiveMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;

    public function __construct(User $user) {
        $this->user = $user;
    }
    
    public function build()
    {
        return $this->subject('Your Account is Activated')
        ->view('emails.member_active');
    }

}