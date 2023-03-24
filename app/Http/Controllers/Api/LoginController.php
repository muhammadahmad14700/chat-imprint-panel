<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Socialite;
use Auth;
use Redirect;
/**
 * @group Auth endpoints
 */
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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);

        if ($response = $this->authenticated($request, $this->guard()->user())) {
            return $response;
        }
        $accessToken = $request->user()->createToken('ImprintTokenAccess')->accessToken;

        return response()->json([
            //'status'        => STATUS_OK,
            'status'        => 200,
            'msg'           => "success",
            'token_type'    => "Bearer",
            'accessToken'   => $accessToken,
            'data'          => ['user'=>$request->user()]
            //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
        ]);

    }

    /**
     * Handle a login request to the application.
     *
     * @bodyParam email email required The email of the user. Example: demo@demo.com
     * @bodyParam password password required The password of the user. Example: password
     *
     * @response status=422 scenario="Validation error" {
     *    "message": "The given data was invalid.",
     *    "errors": {
     *        "email": [
     *            "The email field is required."
     *        ]
     *    }
     * }
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }
	
    public function username()
    {
        //return ‘identity’;
        $login = request()->input('identity');
        $field = filter_var($login, FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        request()->merge([$field => $login]);
        return $field;
    }

    protected function validateLogin(Request $request)
    {
        $messages = [
            'identity.required' => 'Email or Phone cannot be empty',
            'email.exists' => 'Email already registered',
            'phone.exists' => 'Phone No is already registered',
            'password.required' => 'Password cannot be empty',
        ];

        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
            'email' => 'string|exists:users',
            'phone' => 'string|exists:users',
        ], $messages);
    }
	
	 /**
     * Log the user out of the application.
     *
     * @authenticated
     * @response status=204 scenario="Success" {}
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return $request->wantsJson()
            ? new Response('', 204)
            : redirect('/');
    }



    // Social Login - Mobile Endpoint
    public function social_login(Request $request)
    {
        $firebase_status    = env('FIREBASE_STATUS');
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email',
            'provider_id' => 'required|string|max:255',
            'provider' => 'required|string|max:50'
        ]);
        // validator error
        if ($validator->fails()) {
            $this->validator_fails($validator);
        }

        $dbUser = User::where('email', $request->email)->first();
        // If any info is wrong!
        if (!empty($dbUser) && ($request->provider !== $dbUser->provider || $request->provider_id !== $dbUser->provider_id)) {
            //$this->general_fails('Email is already exist. Please try another way to login.');
            return response()->json([
                'status'        => 400,
                'msg'           => "error",
                'error'         => "Email is already exist. Please try another way (web / social) to login."
            ]);
            
        }

        if ($dbUser) {
            auth()->login($dbUser, true);
            $accessToken = $dbUser->createToken('ImprintTokenAccess')->accessToken;
            return response()->json([
                'status'        => 200,
                'msg'           => "success",
                'data'          => ['user'=>$dbUser],
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);
        } else {

            $allowed_platforms = [
                'facebook',
                'google',
                'instagram'
            ];

            if (!in_array($request->provider, $allowed_platforms, true)) {
                $this->general_fails('Wrong Platform or Platform not allowed!');
            }

            $defaultPassword = "1234567890";
            $user = User::create([
                'name'          => $request->name,
                'email'         => $request->email,
                'password'      => Hash::make($request->provider_id)
            ]);

            // attach user role
            $user->attachrole("user");

            if($firebase_status  ==  1 || $firebase_status  == "1") {
                $firebase_data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'provider_id' => $request->provider_id,
                    'provider' => $request->provider,
                    'is_social' => 1,
                ];

                $firebase_user_uid = $this->add_update_user_to_firebase($firebase_data);

                if(isset($firebase_user_uid)){
                    $user->firebase_user_uid = $firebase_user_uid;
                }

            }
            $user->provider_id          = $request->provider_id;
            $user->provider             = $request->provider;
            $user->email_verified_at    = date("Y-m-d g:i:s");
            $user->save();

            //$user_arr = $this->get_user_data($user);
            auth()->login($user, true);
            $accessToken = $user->createToken('ImprintTokenAccess')->accessToken;
            return response()->json([
                'status'        => 200,
                'msg'           => "success",
                'data'          => ['user'=>$user],
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);

        }
    }



    /**
     * Handle Social login request
     *
     * @return response
     *
    public function socialLogin($social)
    {
        return Socialite::driver($social)->redirect();
    }
     */
    /**
     * Obtain the user information from Social Logged in.
     * @param $social
     * @return Response


    public function handleProviderCallback($social)
    {
        $userSocial = Socialite::driver($social)->user();

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if($user){

            Auth::login($user);
            $accessToken = $user->createToken('ImprintTokenAccess')->accessToken;

            return response()->json([
                //'status'        => STATUS_OK,
                'status'        => 200,
                'msg'           => "success",
                'data'          => $user,
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);
        }else{

            $defaultPassword = "1234567890";
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'password'      => Hash::make($defaultPassword)
            ]);
            //$avatar        = $userSocial->getAvatar();
            //$provider_id   = $userSocial->getId();
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
                if(isset($social))
                {
                    $user->provider = $social;
                }
                $user->save();
            }
            auth()->login($user, true);
            $accessToken    = $user()->createToken('ImprintTokenAccess')->accessToken;
            return response()->json([
                //'status'        => STATUS_OK,
                'status'        => 200,
                'msg'           => "success",
                'data'          => $user,
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);

        }

    }*/
}
