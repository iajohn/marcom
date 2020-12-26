<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordResetMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var 
     */
    protected $passwordResetData;

    /**
     * Create a new message instance.
     *
     * PasswordResetMail constructor
     * @return void
     */
    public function __construct($passwordResetData)
    {
        $this->passwordResetData = $passwordResetData;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('api/a/password/reset/' . $this->passwordResetData->token);
        return $this->from('no_reply@incattech.com')->view('mail.forget_password')->with([
            'email'    => $this->passwordResetData->email,
            'url'   => $url
        ]);
    }
}
