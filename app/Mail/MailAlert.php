<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MailAlert extends Mailable
{
    use Queueable, SerializesModels;
    public $emaildata;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($emaildata)
    {
        $this->emaildata = $emaildata;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // 
        return $this->markdown('emails.MailAlert')
                    ->from('STAFFEXIT@KRA.GO.KE')
                    ->with('emaildata', $this->emaildata);
    }
}
