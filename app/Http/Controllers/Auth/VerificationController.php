<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client as TwilioClient;
use App\User;
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
	//protected $redirectTo = RouteServiceProvider::HOME;
	protected function authenticated(Request $request, $user){
		if($user->hasRole('superadministrator'))
		{
			return redirect('/admin');
		}
		if($user->hasRole('user'))
		{
			return redirect('/user');
		}
	}
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('signed')->only('verify');
        $this->middleware('throttle:6,1')->only('verify', 'resend');
    }
    
    public function verifycode(Request $request){
        $data = $request->validate([
            'verification_code' => ['required', 'numeric'],
            //'phone' => ['required', 'string'],
        ]);
        $current_user       = Auth::user();
        $userid             = Auth::user()->id;
        $providor           = Auth::user()->provider;
        $verification_code  = $request->input('verification_code');
        
        if ($providor == "email" && $current_user->verification_code == $verification_code) 
        {
            $verifyuser = tap(User::where('id', $userid))->update(['email_verified_at' => now(),'verify_flag'=>'1']);
            return redirect()->route('username')->with(['message' => 'Email verified']);
            
        }else if($providor == "phone" && $current_user->verification_code == $verification_code)
        {
            $verifyuser = tap(User::where('id', $userid))->update(['email_verified_at' => now(),'verify_flag'=>'1']);
            return redirect()->route('username')->with(['message' => 'Phone number verified']);
            
        }else{
            return redirect()->back()->with(['verification_code' => $data['verification_code'], 'error' => 'Invalid verification code entered!']);
            
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
        
        return $request->wantsJson()
            ? new Response('', 202)
            : back()->with('resent', true);
    }


    /* public function validate_twilio_verification_token(Request $request)
    {
        $current_user = Auth::user();
        $verification_token = $request->input('token');

        $sid    = getenv("TWILIO_ACCOUNT_SID");
        $token  = getenv("TWILIO_AUTH_TOKEN");
        $twilio = new Client($sid, $token);

        // Verify the token
        try {
            $verification_check = $twilio->verify->v2->services(getenv("TWILIO_VERIFY_SID"))
                ->verificationChecks
                ->create($verification_token, ["to" => $current_user->email]);
        } catch (\Exception $e) {
        
            // Redirect to elsewhere
            return redirect()->route('login');
        }

        // Check if the verify token is valid
        if ($verification_check->status === 'approved') {

            // Mark the user as verified in the database
            $current_user->markEmailAsVerified();

            // Redirect user to dashbaord
            return redirect()->route('login');
        }
    } */
}
