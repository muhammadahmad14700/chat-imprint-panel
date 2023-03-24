<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendPinEmail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    protected $userName;
    //protected $userid;
    protected $pin;


    public function __construct($userName, $pin)
    {
        $this->userName = $userName;
        //$this->userid = $userid;
        $this->pin = $pin;
    }

    /**
     * Build the message.
     *
     * @return $this
     */

    public function build()
    {
        $userName = $this->userName;
        //$userid = $this->userid;
        $pin = $this->pin;
        $subject = "Email Verification Pin";
		$fromEmail = env('MAIL_FROM_ADDRESS');
		$fromName = env('MAIL_FROM_NAME');
        return $this->from($fromEmail, $fromName)->subject($subject)->view('mails.sendPinEmail', compact('userName','pin','fromName','fromEmail'));

    }
}
