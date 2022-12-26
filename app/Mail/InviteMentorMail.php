<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InviteMentorMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(
        protected $email,
        protected $link
    ) {
        //
    }
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return  $this->subject(__('content.send_mail_invite_mentor'))
            ->markdown('emails.template-invite-mentor')
            ->to($this->email)
            ->with('link', $this->link);
    }
}
