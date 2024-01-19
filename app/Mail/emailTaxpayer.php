<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class emailTaxpayer extends Mailable
{
    use Queueable, SerializesModels;
    public $maildata;

   
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($maildata)
    {
        $this->maildata = $maildata;
        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.emailTaxpayer')
        -> from('IRO@KRA.GO.KE')
        ->subject($this->maildata['subject'])
        ->attachData($this->maildata['filename'], $this->maildata['tpin'].'.pdf',['mime' => 'application/pdf'])
        ->with('maildata', $this->maildata);
    }
}
