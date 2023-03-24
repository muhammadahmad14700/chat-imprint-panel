<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;
use Socialite;
use Auth;
use Redirect;
class ApiAuthController extends Controller
{
    //
    public function register (Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $request['password']=Hash::make($request['password']);
        $request['remember_token'] = Str::random(10);
        $user = User::create($request->toArray());
        $token = $user->createToken('ImprintTokenAccess')->accessToken;
		//$token = $user->createToken('Laravel Password Grant Client')->accessToken;
        $response = ['token_type' => "Bearer",'token' => $token];
        return response($response, 200);
    }

    public function login (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
        {
            return response(['errors'=>$validator->errors()->all()], 422);
        }
        $user = User::where('email', $request->email)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                //$token = $user->createToken('Laravel Password Grant Client')->accessToken;
				$token = $user->createToken('ImprintTokenAccess')->accessToken;
                $response = ['resp'=> "success",'data'=>['user'=>$user],'token_type' => "Bearer",'token' => $token];
                //$response = ['resp'=> "success",'data'=>['user'=>Crypt::encryptString($user)],'token' => $token];
                return response($response, 200);
            } else {
                $response = ['resp'=> "error","message" => "Password mismatch"];
                return response($response, 422);
            }
        } else {
            $response = ['resp'=> "error","message" =>'User does not exist'];
            return response($response, 422);
        }
    }

    public function logout (Request $request) {
        $token = $request->user()->token();
        $token->revoke();
        $response = ['message' => 'You have been successfully logged out!'];
        return response($response, 200);
    }

    // Social login
    // @todo: Needs Refactor
    public function socialLogin($social)
    {
        return Socialite::driver($social)->stateless()->redirect();
    }

    // Social call back
    // @todo: Needs Refactor
    public function handleProviderCallback(Request $request, $social)
    {
        
        /* if (!$request->has('code') || $request->has('denied')) {
            return redirect()->back();
        } */
       
        try {
            $userSocial = Socialite::driver($social)->stateless()->user();
        }
        catch (Exception $e) {
            return redirect()->back();
        }
		
        $dbUser = User::where('email', $userSocial->getEmail())->first();

        if ($dbUser) {
            $accessToken = $dbUser->createToken('ImprintTokenAccess')->accessToken;
           
            $response = [
                'data' => $dbUser,
                'token_type' => "Bearer",
                'token' => $accessToken
            ];
			return response()->json([
				'msg'     => "success",
				'data'    => $response
				//'token'    => $user->createToken($request->input('device_name'))->accessToken,
			]);
        } else {
            
            $user = User::create([
				'name' 	=> $userSocial->getName(),
				'email' => $userSocial->getEmail(),
				'password' => Hash::make($userSocial->getId())
			]);
			$user->attachRole('user');
			
            $accessToken = $user->createToken('ImprintTokenAccess')->accessToken;

            if(env('FIREBASE_STATUS')  ==  1 || env('FIREBASE_STATUS')  == "1") {
                // add user into firebase.
                $firebasedata = [
                    'displayName' => $userSocial->getName(),
                    'email' => $userSocial->getEmail(),
                    'emailVerified' => true, // as this is social login so no need to set false
					'photoUrl' => $userSocial->getAvatar()
                    //'disabled' => false,
                    //'provider' => $social,
                ];
                $firebase_data = $this->add_update_user_to_firebase($firebasedata);
                // Add firebase user id into database.
                $user->firebase_user_uid  = $firebase_data->uid;
            }
            $user->email_verified_at      = date("Y-m-d g:i:s");
            $user->save();

            $response = [
                'data' => $user,
                'token_type' => "Bearer",
                'token' => $accessToken
            ];
			
			return response()->json([
				'msg'     => "success",
				'data'    => $response
				//'token'    => $user->createToken($request->input('device_name'))->accessToken,
			]);
        }
    }

    // Social Login - Mobile Endpoint
    // Social call back
    public function social_login_mobile(Request $request, $social)
    {
        $firebase_status    =  env('FIREBASE_STATUS');
        $userSocial = Socialite::driver($social)->stateless()->user();
		$dbUser = User::where('email', $userSocial->getEmail())->first();

        if ($dbUser) 
		{
            auth()->login($dbUser, true);
            $accessToken = $dbUser->createToken('ImprintTokenAccess')->accessToken;
           
            $response = [
                'data' => $dbUser,
                'token' => $accessToken
            ];
			return response()->json([
				'msg'     => "success",
				'data'    => $response
				//'token'    => $user->createToken($request->input('device_name'))->accessToken,
			]);
        } else{
			$user = User::create([
					'name' 	=> $request->name,
					'email' => $request->email,
					'password' => Hash::make($request->platform)
				]);
			$user->attachRole('user');
				
			if($firebase_status  ==  1 || $firebase_status  == "1") 
			{
				$firebasedata = [
					'name' => $request->name,
					'email' => $request->email,
					'social_user_id' => $request->user_id,
					'social_platform' => $request->platform,
				];    
				$firebase_data = $this->add_update_user_to_firebase($firebasedata);
					// Add firebase user id into database.
				$user->firebase_user_uid = $firebase_data->uid;
			}

			$user->email_verified_at   = date("Y-m-d g:i:s");
			$user->save();
            auth()->login($user, true);
			$accessToken = $user->createToken('ImprintTokenAccess')->accessToken;

			$response = [
				'data' => $user,
				'token' => $accessToken
			];
				
			return response()->json([
					'msg'     => "success",
					'data'    => $response
			]);
		}
		
    }

}
