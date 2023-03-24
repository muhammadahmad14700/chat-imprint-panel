<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\Events\Verified;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;

/**
 * @group Auth endpoints
 */
class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }

    /**
     * Mark the authenticated user's email address as verified.
     *
     * @authenticated
     * @urlParam hash required Email verification hash. Example: eyJpdiI6IjROTEh4Vjdyc085T1poTjlJa2hKNUE9PSIsInZhbHVlIjoiQ0lQOHVSblFvd0xROEtpRkNLd1pSUT09IiwibWFjIjoiMmRkNTNmNzFiZThkMjI3NzE3NGExY2FhYTRkMGI1ZjExODU1YTM5MzYzZTQyODNhYjQxOTIxNjU3ZTUxYWI5MSJ9
     * @response status=202 scenario="Email has been verified" {}
     * @response status=204 scenario="Email already verified" {}
     * @response status=400 scenario="Wrong link" {
     *     "message": "The link is wrong"
     * }
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */


    public function verifycode(Request $request)
    {
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            //'phone' => ['required', 'string'],
        ]);
        $verification_code  = $request->input('verification_code');
        $user_id            = $request->input('user_id');
        $current_user       = User::where('id', $userid)->first();
        if(isset($current_user))
        {
            if ($current_user->providor == "email" && $current_user->verification_code == $verification_code) 
            {
                $verifyuser = User::where('id', $userid)->update(['email_verified_at' => now(),'verify_flag'=>'1']);
            
                $user_arr=[
                    'id'=>$user_id,
                    'email'=>$current_user->email,
                    'firebase_user_uid'=>$current_user->firebase_user_uid,
                    'varify_flag'=>'1'
                ];
                //return redirect()->route('username')->with(['message' => 'Email verified']);
                return response()->json([
                    'status'        => 200,
                    'msg'           => "success",
                    'data'          => ['user'=>$user_arr]
                ]);
            }else if($current_user->providor == "phone" && $current_user->verification_code == $verification_code)
            {
                
                $verifyuser = User::where('id', $userid)->update(['email_verified_at' => now(),'verify_flag'=>'1']);
                //return redirect()->route('username')->with(['message' => 'Phone number verified']);
                $user_arr=[
                    'id'=>$user_id,
                    'phone'=>$userData->phone,
                    'firebase_user_uid'=>$userData->firebase_user_uid,
                    'varify_flag'=>'1'
                ];
                return response()->json([
                    'status'        => 200,
                    'msg'           => "success",
                    'data'          => ['user'=>$user_arr]
                ]);
            }else{
                return response()->json([
                    'status'    => 400,
                    'msg'       => "unsuccess",
                    'error'     => ["message"=> "The link is wrong"]
                ]);
            }
        }else{
            return response()->json([
                'status'        => 401,
                'msg'           => "unsuccess",
                'error'         => ["message"=> "Invalid User id"]
            ]);
        }   
    } 
    
    /**
     * Resend the email verification notification.
     *
     * @authenticated
     * @response status=202 scenario="Success" {}
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response()->json([
                'status'        => 204,
                'msg'           => "success"
                //'data'          => ['user'=>$user_arr]
            ]);
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }

        if($request->user()->provider == "phone")
        {
            $phone      = "+".$request->user()->phone;
            $pincode    = $request->user()->verification_code;
            $this->sendSMS($phone,$pincode);   
        }else{
            $pincode    = $request->user()->verification_code;
            $request->user()->notify(new CustomVerifyEmail($pincode));    
        }
        
        //$request->user()->sendEmailVerificationNotification();
        return response()->json([
            'status'        => 200,
            'msg'           => "success"
            //'data'          => ['user'=>$user_arr]
        ]);
        /* 
        return $request->wantsJson()
            ? new Response('', 202)
            : back()->with('resent', true); 
        */
    }

    /* 
    public function verify(Request $request)
    {
        try {
            if (Crypt::decrypt($request->route('hash')) != $request->user()->getKey()) {
                abort(400, 'The link is wrong');
            }
        } catch (DecryptException $e) {
            abort(400, 'The link is wrong');
        }

        if ($request->user()->hasVerifiedEmail()) {
            return $request->wantsJson()
                ? new Response('', 204)
                : redirect($this->redirectPath());
        }

        if ($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }

        return $request->wantsJson()
            ? new Response('', 204)
            : redirect($this->redirectPath())->with('verified', true);
    }
    */


    
}
