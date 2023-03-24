<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
//use Twilio\Rest\Client;
class User extends Authenticatable implements MustVerifyEmail
{
    //use LaratrustUserTrait;
    use HasApiTokens,Notifiable,LaratrustUserTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','phone',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function sendEmailVerificationNotification()
    {
        $current_user = Auth::user();
        if($current_user->provider == "email"){
            $verification_pin = $current_user->verification_code;
            $this->notify(new \App\Notifications\CustomVerifyEmail($verification_pin));    
        }
        //return true;
    }

    /* 
    // for twillio email varification email
    public function sendEmailVerificationNotification()
    {
       $current_user = Auth::user();
       $sid    = getenv("TWILIO_ACCOUNT_SID");
       $token  = getenv("TWILIO_AUTH_TOKEN");
       $twilio = new Client($sid, $token);

       $verification = $twilio->verify->v2->services(getenv("TWILIO_VERIFY_SID"))
           ->verifications
           ->create($current_user->email, "email");
    } */
}
