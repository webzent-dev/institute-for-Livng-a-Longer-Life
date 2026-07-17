<?php

namespace App\Mail;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

class AdminCollaboratorNotification extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    public $user;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New Collaborator Registration Notification')
        ->view('emails.admin_collaborator_notification');
    }

}