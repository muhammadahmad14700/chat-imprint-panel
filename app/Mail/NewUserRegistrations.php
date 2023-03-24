<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewUserRegistrations extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
	protected $name;
    protected $smsCode;
	

    public function __construct($name,$smsCode)
    {
        $this->name 		= $name;
        $this->smsCode 		= $smsCode;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name 		= $this->name;
        $smsCode 	= $this->smsCode;
        $fromEmail  = env('MAIL_FROM_ADDRESS');
		$fromName   = env('MAIL_FROM_NAME');
		$subject	= "Welcome to $fromName";
        return $this->from($fromEmail, $fromName)->subject($subject)->view('mails.newRegisterations', compact('name','smsCode', 'fromEmail', 'fromName'));
    }
}
