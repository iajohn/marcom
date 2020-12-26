<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RegisterUserMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $user;
    protected $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $url = url('api/a/verify_email/' . $this->token);
        return $this->from('no_reply@incattech.com')->view('mail.register_user')->with([
            'id'    => $this->user->id, 
            'name'  => $this->user->name,
            'email' => $this->user->email,
            'url'   => $url
        ]);
    }
}
