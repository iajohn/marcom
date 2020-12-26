<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * Class MarkdownMail
 */
class MarkdownMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var array
     */
    public $data;

    /**
     * Create a new message instance.
     * @param string $view
     * @param string $subject
     * @param array $data
     *
     * @return void
     */
    public function __construct($view, $subject, $fromEmail, $data = [])
    {
        $this->data = $data;
        $this->view = $view;
        $this->subject = $subject;
        $this->fromEmail = $fromEmail;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail)->subject($this->subject)->markdown($this->view)->with($this->data);
    }
}
