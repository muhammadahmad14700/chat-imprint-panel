<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\DemoEmail;
use Symfony\Component\HttpFoundation\Response;


class MailController extends Controller {
    
    public function sendEmail() {
        $email = 'mudassar.mscit@gmail.com';
   
        $mailData = [
            'title' => 'Demo Email',
            'url' => 'http://localhost:8000'
        ];
  
        Mail::to($email)->send(new DemoEmail($mailData));
   
        return response()->json([
            'message' => 'Email has been sent.'
        ], Response::HTTP_OK);
    }

}