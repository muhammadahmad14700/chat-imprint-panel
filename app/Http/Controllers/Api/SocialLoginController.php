<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
//use Illuminate\Database\QueryException;
use App\VerifyUser;
use Illuminate\Support\Str;
use \Validator;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
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
class SocialLoginController extends Controller
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


    // Social Login - Mobile Endpoint
    public function social_login_mobile(Request $request)
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
            /*return response()->json([
                'status'        => 400,
                'msg'           => "error",
                'error'         => "Email is already exist. Please try another way (web / social) to login."
            ]);*/
            $accessToken = $dbUser->createToken('authToken')->accessToken;
            return response()->json([
                'status'        => 200,
                'msg'           => "success",
                'data'          => $dbUser,
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);
        }

        if ($dbUser) {
            auth()->login($dbUser, true);
            $accessToken = $dbUser->createToken('ImprintTokenAccess')->accessToken;
            return response()->json([
                'status'        => 200,
                'msg'           => "success",
                'data'          => $dbUser,
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
                'data'          => $user,
                'token_type'    => "Bearer",
                'accessToken'   => $accessToken
                //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
            ]);

        }
    }
}

