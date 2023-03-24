<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Google\Cloud\Firestore\FirestoreClient;
//use Kreait\Firebase\Firestore;
use Kreait\Firebase\Exception\AuthException;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Factory;
use Log;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    private $firebase_auth = null;
    private $firebase_db = null;
    //private $bucket_name = 'company-buy1248';

    public function sendSMS($contactNo,$randomNo)
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
    }

    /*  public function sendSMSNew($contactNo,$randomNo)
	{
        // Get credentials from .env 
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_ACCOUNT_SID");
        $twilio_verify_sid = getenv("TWILIO_VERIFY_SID");
        $twilio = new TwilioClient($twilio_sid, $token);
        $twilio->verify->v2->services($twilio_verify_sid)
            ->verifications
            ->create($contactNo, "sms");
            //->create($contactNo, "sms",["customCode" => $randomNo]); 
        // dd($twilio->sid);    
        return "success";    	
    } */


    private function get_firebase_configurations()
    {
        if ($this->firebase_auth && $this->firebase_db) {
            return [$this->firebase_auth, $this->firebase_db];
        }
        // Initialization
        $json_key_path = public_path(env('GOOGLE_APPLICATION_CREDENTIALS'));
        $factory = new Factory();

        $this->firebase_auth = $factory
            ->withServiceAccount($json_key_path)
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'))
            ->createAuth();

        $this->firebase_db = $factory
            ->withServiceAccount($json_key_path)
            ->createFirestore()->database();

        return [$this->firebase_auth, $this->firebase_db];
    }

    public function add_update_user_to_firebase($userProperties,$firebase_user_uid = '',bool $merge = false, bool $get_user_from_firebase = false)
    {

        list($firebase_auth, $db) = $this->get_firebase_configurations();

        // if merge = true then it means this user already exists and if merge is not true then it means it means its new user.
        if (! $merge){
            // Create User - Add in Authentication
            try {
                $createdUser = $firebase_auth->createUser($userProperties);
                $firebase_user_uid = $createdUser->uid;
            } catch (AuthException $exception) {
                Log::error(($exception->getCode() . ' -- ' . $exception->getMessage()));
                return $this->general_fails($exception->getMessage());
            } catch (FirebaseException $exception) {
                Log::error(($exception->getCode() . ' -- ' . $exception->getMessage()));
                return $this->general_fails($exception->getMessage());
            }
        }else {
            try {
                $firebase_auth->updateUser($firebase_user_uid, ['emailVerified' => true]);
            } catch (AuthException $exception) {
                Log::error(($exception->getCode() . ' -- ' . $exception->getMessage()));
            } catch (FirebaseException $exception) {
                Log::error(($exception->getCode() . ' -- ' . $exception->getMessage()));
            }
        }

        // Add into Firestore Database
        $firestore = new FirestoreClient();
        $docRef = $firestore->collection('users')->document($firebase_user_uid);
        $docRef->set($userProperties, ['merge' => $merge]);

        if ($get_user_from_firebase){
            $user = $this->get_firebase_user_by_email($userProperties['email']);
            return $user;
        }

        return $firebase_user_uid;
    }

    /*
   protected function get_firebase_user_by_email($email)
   {
       list($auth, $db) = $this->get_firebase_configurations();

       try {
           $user = $auth->getUserByEmail($email);
           return $user;
       } catch (AuthException $exception) {
           Log::debug(($exception->getCode() . ' -- ' . $exception->getMessage()));
           return [];
       } catch (FirebaseException $exception) {
           Log::debug(($exception->getCode() . ' -- ' . $exception->getMessage()));
           return [];
       }
   }
  */

   /*
    public function googleImageUpload(Request $request)
    {
        $attachmentPath = '';
        if ($request->hasFile('image')) {
            $allowed = array('gif', 'png', 'jpg', 'jpeg', 'GIF', 'PNG', 'JPG', 'JPEG');
            // If this is image and properly in available extension
            if (in_array(NewRequest::file('image')->getClientOriginalExtension(), $allowed)) {
                //json_decode(file_get_contents(public_path('@321aladdin-+=]0google/buy2buy-72af48754bcd.json')), true)
                $storage = new StorageClient([
                    'keyFilePath'   => public_path('@321aladdin-+=]0google/buy2buy-72af48754bcd.json'),
                    'projectId'     => 'buy2buy'
                ]);

                //$path = $this->bucket_name;
                $bucket = $storage->bucket($this->bucket_name);
                $url        = "profile_pic/";
                //$attachmentPath = $url.NewRequest::file('image')->getClientOriginalName();
                $attachmentPath = $url.uniqid()."-profilePic.".NewRequest::file('image')->getClientOriginalExtension();

                // upload a file and give read access to anyone with the URL.
                $object = $bucket->upload(file_get_contents(NewRequest::file('image')), [
                    'name' => $attachmentPath,
                    'predefinedAcl' => 'publicRead'
                ]);
            }
        }
        return $attachmentPath;
    }*/

}
