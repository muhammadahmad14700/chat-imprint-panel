<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use \Validator;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Http\Response;
use Auth;
/**
 * @group Auth endpoints
 */
class AuthenticationController extends Controller
{
    /**
     * Shows authenticated user information
     *
     * @authenticated
     *
     * @response 200 {
     *     "id": 2,
     *     "name": "Demo",
     *     "email": "demo@demo.com",
     *     "email_verified_at": null,
     *     "created_at": "2020-05-25T06:21:47.000000Z",
     *     "updated_at": "2020-05-25T06:21:47.000000Z"
     * }
     * @response status=400 scenario="Unauthenticated" {
     *     "message": "Unauthenticated."
     * }
     */
    public function user()
    {
        return auth()->user();
    }

    public function updateUser(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // validator error
        if ($validator->fails()) {
            //$this->validator_fails($validator);
            return response()->json([
                'status' => 401,
                'msg'    => "unsuccessful",
                'error'  => [$this->validator_fails($validator)]
            ]); 
        }
        $name       = $request->input('name');
        $password   = $request->input('password');
        $user_id    = $request->input('user_id');
        $userData   = User::where('id', $userid)->first();
        if(isset($name) && ($userData->verify_flag == '2' || $user->verify_flag == 2))
        {
            $update = User::where('id', $userid)->update(['name' => $name,'password' => Hash::make($password),'verify_flag'=>'3']);
        }
        return response()->json([
            'status'        => 200,
            'msg'           => "success",
            'data'          => ['user'=>$userData]
            //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
        ]);    

    }

    public function updateName(Request $request)
    {
        $validator = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        // validator error
        if ($validator->fails()) {
            //$this->validator_fails($validator);
            return response()->json([
                'status' => 401,
                'msg'    => "unsuccessful",
                'error'  => [$this->validator_fails($validator)]
            ]); 
        }
        $name       = $request->input('name');
        $user_id    = $request->input('user_id');
        $userData   = User::where('id', $userid)->first();
        if(isset($name) && ($userData->verify_flag == '1' || $user->verify_flag == 1))
        {
            $update = User::where('id', $userid)->update(['name' => $name,'verify_flag'=>'2']);
        }
        return response()->json([
            'status'        => 200,
            'msg'           => "success",
            'data'          => ['user'=>$userData]
        ]);
        
    }

    public function updatePassword(Request $request)
    {
        $validator = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
        // validator error
        if ($validator->fails()) {
            //$this->validator_fails($validator);
            return response()->json([
                'status' => 401,
                'msg'    => "unsuccessful",
                'error'  => [$this->validator_fails($validator)]
            ]); 
        }
        $password   = $request->input('password');
        $user_id    = $request->input('user_id');
        $userData   = User::where('id', $userid)->first();
        if(isset($name) && ($userData->verify_flag == '2' || $user->verify_flag == 2))
        {
            $update = User::where('id', $userid)->update(['password' => Hash::make($password),'verify_flag'=>'3']);
        }
        return response()->json([
            'status'        => 200,
            'msg'           => "success",
            'data'          => ['user'=>$userData]
            //'data'    => ['user'=>$user,'token_type' => "Bearer",'accessToken' => $accessToken]
        ]);    

    }
}
