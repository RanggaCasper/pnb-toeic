<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TokenEmail extends Mailable
{
    use Queueable, SerializesModels;

    private $result;
    /**
     * Create a new message instance.
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * Get the message envelope.
     */
    public function build()
    {
        return $this->subject("Reset Password Token")
                    ->view('mail.reset')
                    ->with(['result' => $this->result]);
    }
}