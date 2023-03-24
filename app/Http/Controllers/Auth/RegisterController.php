<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
//use App\Model\Role;
use App\User;
use App\Notifications\CustomVerifyEmail;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendPinEmail;
use Twilio\Rest\Client as TwilioClient;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = RouteServiceProvider::HOME;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'phone' => 'required_without:email',
            'email' => 'required_without:phone|nullable|email|unique:users',
        ]);
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $provider   = "email";
        $randomNo 	= rand(1000,9999);
        $name       = "Imprint User";
        $email      = $data['email'];
        $password   = "1234567890";
        if(isset($data['phone']) && $data['phone'] != null)
        {
            $provider   = 'phone';
            $namee      = strtolower(str_replace(' ', '',  $name));
            $email      = $namee.'-'.uniqid()."@imprint.com";
        }
		$user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
		$user->attachRole('user');

        if(env('FIREBASE_STATUS') == "1" || env('FIREBASE_STATUS') == 1)
        {
            $firebase_data = [
                'displayName'   => $name,
                'email'         => $email,
                'provider'      => $provider,
                'photoUrl'      => '',
            ];
            $firebase_user_uid = $this->add_update_user_to_firebase($firebase_data);
            //for update firebase id to users table
            $user->firebase_user_uid = $firebase_user_uid;  
        }

        if (isset($data['phone']))
        {
            $phone   = trim($data['phone']);
            //send SMS
            $this->sendSMS($phone,$randomNo);
            $phone = str_replace('+', '',$phone);
            $user->phone = $phone;
        }
        $user->provider = $provider;
        $user->verification_code = $randomNo;
        $user->save();
        /* if(isset($data['email']) && $data['email'] != null)
        {
            //$user->notify(new CustomVerifyEmail($randomNo));
            //Mail::to($email)->send(new SendPinEmail($name,$randomNo));
        }  */
        auth()->login($user, true);
		return $user;
    }

   /*  public function sendSMS($contactNo,$randomNo)
	{
        $twilioAccountSid   = getenv("TWILIO_ACCOUNT_SID");
		$twilioAuthToken   	= getenv("TWILIO_AUTH_TOKEN");
		$twilioFromNumber   = getenv("TWILIO_NUMBER");
		
		$client = new TwilioClient($twilioAccountSid, $twilioAuthToken);
		$client->messages->create(
			// Where to send a text message (your cell phone?)
			$contactNo,
			array(
				'from' => $twilioFromNumber,
                'body' => 'Your {{getenv("MAIL_FROM_NAME")}} Activation Code :' . $randomNo
			)
        ); 
        return "success";
    } */
    
   
    
    
	 /* 
    
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
    
    public function register(Request $request)
    {
        $randomNo 	= rand(1000,9999);
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        Mail::to($user->email)->send(new SendPinEmail($user->name,$randomNo));
        return back()->with('status','Please confirm your email address');
    } */
}
