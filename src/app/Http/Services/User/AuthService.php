<?php
namespace App\Http\Services\User;

use App\Enums\StatusEnum;
use App\Http\Utility\SendMail;
use App\Http\Utility\SendSMS;
use App\Models\Admin;
use App\Models\Core\Otp;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Closure;
use Illuminate\Support\Facades\Http;

class AuthService 
{


    /**
     * Register a user
     *
     * @param array $data
     */
    public function register(array $data) :User {
        $user = new User();
        $user->name = Arr::get($data,"name","");
        $user->email = Arr::get($data,"email","");
        $user->user_name = Arr::get($data,"user_name","");
        $user->phone = Arr::get($data,"phone","");
        $user->country_code = Arr::get($data,"country_code","");
        $user->address = Arr::get($data,"address","");
        $user->password = Hash::make( Arr::get($data,"password",12345));
        $user->custom_data = $data;
        $user->save();
        return $user;
    
    }

    /**
     * Send Otp
     *
     * @param User $user
     * @return array
     */
    public function sendOtp(User $user , string $type , string $medium = "sms" ,string $template = "REGISTRATION_VERIFY") :array {
        
        $expiredTime = (int) site_settings('otp_expired_in');
        $user->otp()?->where('type',$type)->delete();
        $otp = new Otp();
        $code = generateOTP();
        $otp->otp =  $code;
        $otp->type = $type;
        $otp->expired_at = Carbon::now()->addMinutes($expiredTime);
        $user->otp()->save($otp);
    
        $templateCode = [
            'name' => $user->name,
            'code' => $code,
            'time' =>  Carbon::now(),
        ];
        if($medium == 'sms'){
            $templateCode = [
                'name' => $user->name,
                'otp' => $code,
                'time' =>  Carbon::now(),
            ];
            return SendSMS::smsNotification('OTP_VERIFY',$templateCode ,$user);
        }

        return SendMail::mailNotifications($template,$templateCode ,$user);
        
    }



    /**
     * Send Otp
     *
     * @param Admin $admin
     * @return array
     */
    public function passwordReset(Admin $admin) :array {
        

        $expiredTime = (int) site_settings('otp_expired_in');
        $admin->otp()?->where('type',"admin_password_reset")->delete();
        $otp = new Otp();
        $code = generateOTP();
        $otp->otp =  $code;
        $otp->type = "admin_password_reset";
        $otp->expired_at = Carbon::now()->addMinutes($expiredTime);
        $admin->otp()->save($otp);
    
        $templateCode = [
            'name' => $admin->name,
            'code' => $code,
            'time' =>  Carbon::now(),
        ];

        return SendMail::mailNotifications("PASSWORD_RESET",$templateCode ,$admin);
        
    }


    /**
     * Captcha validation rules
     *
     * @param string $type
     * @return array
     */
    public function captchaValidationRules(string $type = 'default') :array {
        $googleCaptcha = (object) json_decode(site_settings("google_recaptcha"));
        $rules = ['required' , function (string $attribute, mixed $value, Closure $fail) {
            if (strtolower($value) != strtolower(session()->get('gcaptcha_code'))) {
                $fail(translate("Invalid Captch Code"));
            }
        }];
        if($type =="google"){
            $rules =  ['required' , function (string $attribute, mixed $value, Closure $fail) use($googleCaptcha) {
                $g_response =  Http::asForm()->post("https://www.google.com/recaptcha/api/siteverify",[
                    "secret"=> $googleCaptcha->secret_key,
                    "response"=> $value,
                    "remoteip"=> request()->ip,
                ]);

                if (!$g_response->json("success")) {
                    $fail(translate("Recaptcha Validation Failed"));
                }
            }];
        }

        return $rules;
    }



    /**
     * opt Resend Status
     *
     * @param User $user
     * @return boolean
     */
    public function otpResendStatus(User $user , string $type ) :bool {
        $userOtp = $user->otp()?->where('type',$type)->first();
        if($userOtp){
            if(Carbon::parse($userOtp->created_at)->addMinute() > Carbon::now()) {
                return false;
            }
            return true;
        }
        return true;
    }


    /**
     * Otp login check
     *
     * @return boolean
     */
    public function loginWithOtp() :bool {

        $loginAttributes =  json_decode(site_settings('login_with'),true);
        if(is_array($loginAttributes) && count($loginAttributes) == 1 && in_array('phone',$loginAttributes) && site_settings('sms_otp_verification') == StatusEnum::true->status() ){
            return true;
        }
        return false;

    }
    

    /**
     * check verification code expired 
     *
     * @param User $user
     * @return void
     */
    public function checkExpiredStatus(User $user , string $type ) :void {

        $sessionParam = "expired_alert";
        if($type == "otp_verification"){
            $sessionParam = "otp_expired_alert";
        }

        if(site_settings('otp_expired_status') == StatusEnum::true->status()){
            $userOtp = $user->otp()?->where('type',$type)->first();
            session()->forget($sessionParam);
            if($userOtp){
                session()->put($sessionParam, $userOtp->expired_at);
            }
        }

    }


}