<?php

namespace App\Http\Controllers\Auth;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Hash;
//use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
//use Socialite;
use Laravel\Socialite\Facades\Socialite;
use Auth;
use App\User;
use Redirect;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }

   

    public function username()
    {
        //return ‘identity’;
        $login = request()->input('identity');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$field => $login]);
        return $field;
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function validateLogin(Request $request)
    {
        $messages = [
            'identity.required' => 'Email or username cannot be empty',
            'email.exists' => 'Email or username already registered',
            'phone.exists' => 'Phone No is already registered',
            'password.required' => 'Password cannot be empty',
        ];

        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'phone' => 'numeric|exists:users',
        ], $messages);
    }

    /**
     * Handle Social login request
     *
     * @return response
     */
    
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    
    }

    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response
     */

    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();
        
        /* try {
            $userSocial = Socialite::driver($social)->user();
        } catch (InvalidStateException $e) {
            $userSocial = Socialite::driver($social)->stateless()->user();
        } */
        
        /* // OAuth One Providers
        $token = $userSocial->token;
        $tokenSecret = $userSocial->tokenSecret; */

        // All Providers
        $id_s       = $userSocial->getId();
        $nickname_s = $userSocial->getNickname();
        $name_s     = $userSocial->getName();
        $email_s    = $userSocial->getEmail();
        $avatar_s   = $userSocial->getAvatar();

        $user = User::where(['email' => $email_s])->first();

        if($user){
            if(!isset($user->email_verified_at))
            {
                $checkUser = User::where('email', '=', $name_s)->update(['email_verified_at'=>now()]);
            }  
            Auth::login($user);
            //return redirect('/user'); 
            //return redirect()->to('/user');
            return redirect()->action('UserController@index');

        }else{

            $defaultPassword    = "1234567890";

            $user = User::create([
                'name'          => $name_s,
                'email'         => $email_s,
                'password'      => Hash::make($defaultPassword)
                
            ]);
            $user->attachRole('user');
			// Add Firebase Key And Save User to Firestore DB
			if(env('FIREBASE_STATUS') == "1" || env('FIREBASE_STATUS') == 1) {
				$provider = "email";
				if(isset($social)){
					$provider = $social;
				}
				$firebase_data = [
					'displayName'   => $user->name,
					'email'         => $user->email,
					'password'      => $defaultPassword,
					'provider'      => $provider,
					'photoUrl'      => "",
					//'disabled'      => false,
					//'emailVerified' => false,
				];
				$firebase_user_uid = $this->add_update_user_to_firebase($firebase_data);
				//for update firebase id to users table
				$user->firebase_user_uid = $firebase_user_uid;
            }
            $user->email_verified_at = now();
            $user->avatar        = $avatar_s;
            $user->provider_id   = $id_s;
            $user->provider      = $social;
            $user->save();
            
            auth()->login($user, true);
            //return redirect('/user');    
            //return redirect()->to('/user');
            return redirect()->action('UserController@index');

        }

    }
}
