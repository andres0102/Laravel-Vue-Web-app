<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Mails extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * The demo object instance.
     *
     * @var Demo
     */
    public $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->data->senderEmail)
            ->view('mails.question')
            ->text('mails.question_plain');
    }
}
