<?php

namespace App\Http\Controllers;

use App\Enums\StatusEnum;
use App\Http\Services\FileService;
use App\Http\Utility\SendNotification;
use App\Jobs\SendMailJob;
use App\Models\Core\Language;
use App\Models\Core\Setting;
use App\Models\Link;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Illuminate\Support\Facades\Session;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;
class CoreController extends Controller
{


    protected $fileService;
    
    public function __construct()
    {

        $this->fileService = new FileService();

    
    }
     
    /**
     * change  language
     *
     * @param string $code
     * @return RedirectResponse
     */
     public function languageChange(string $code ) :RedirectResponse
     {
       $response['status'] = "success";
       $response['message'] = translate('Language Switched Successfully');

       if(!Language::where('code', $code)->exists()){
           $code = 'en';
       }
       optimize_clear();
       session()->put('locale', $code);
       app()->setLocale($code);
       return back()->with("success",translate('Language Switched Successfully'));
     }

     /**
      * create default image
      *
      * @param string|null $size
      * @return void
      */
     public function defaultImageCreate(string $size=null) :void
     {
         $width = explode('x',$size)[0];
         $height = explode('x',$size)[1];
         $image = imagecreate($width, $height);
         $fontFile = realpath('assets/font') . DIRECTORY_SEPARATOR . 'RobotoMono-Regular.ttf';
         if($width > 100 && $height > 100){
             $fontSize = 30;
         }else{
             $fontSize = 5;
         }
         $text = $width . 'X' . $height;
         $backgroundcolor = imagecolorallocate($image, 237, 241, 250);
         $textcolor    = imagecolorallocate($image, 107, 111, 130);
         imagefill($image, 0, 0, $textcolor);
         $textsize = imagettfbbox($fontSize, 0, $fontFile, $text);
         $textWidth  = abs($textsize[4] - $textsize[0]);
         $textHeight = abs($textsize[5] - $textsize[1]);
         $xx = ($width - $textWidth) / 2;
         $yy = ($height + $textHeight) / 2;
         header('Content-Type: image/jpeg');
         imagettftext($image, $fontSize, 0, $xx, $yy, $backgroundcolor , $fontFile, $text);
         imagejpeg($image);
         imagedestroy($image);
     }
     
   /**
    * genarate default cpatcha code
    *
    * @return void
    */
   public function defaultCaptcha(int | string $randCode) :void{

       $phrase = new PhraseBuilder;
       $code = $phrase->build(4);
       $builder = new CaptchaBuilder($code, $phrase);
       $builder->setBackgroundColor(220, 210, 230);
       $builder->setMaxAngle(25);
       $builder->setMaxBehindLines(0);
       $builder->setMaxFrontLines(0);
       $builder->build($width = 100, $height = 40, $font = null);
       $phrase = $builder->getPhrase();

       if(Session::has('gcaptcha_code')) {
           Session::forget('gcaptcha_code');
       }
       Session::put('gcaptcha_code', $phrase);
       header("Cache-Control: no-cache, must-revalidate");
       header("Content-Type:image/jpeg");
       $builder->output();
    }

    public function clear() :RedirectResponse{

        optimize_clear();
        return back()->with(response_status("Cache Clean Successfully"));
    }

    public function cron(){

        $subscriptions = Subscription::with(['user','package'])->expired()
        ->where('status',StatusEnum::true->status())
        ->get();

        foreach($subscriptions as $subscription){
            $templateCode = [
                'time' => Carbon::now(),
                'name' => $subscription->package->title
            ];
            $subscription->status = StatusEnum::false->status();
            $subscription->save();
            SendMailJob::dispatch($subscription->user,'SUBSCRIPTION_EXPIRED',$templateCode);
            if(site_settings('database_notifications') == StatusEnum::true->status()){
                $code = [
                    "user_id" => $subscription->user->id,
                    "message" => "Your Running Subscription Is Expired !!",
                    "url" => route('user.subscription')
                ];
                SendNotification::database_notifications($code);
            }

            $deletedTime = Carbon::parse($subscription->expired_at)->addDays((int) site_settings('expired_data_delete_after'))->toDateString();
                
            if( $deletedTime <= Carbon::now()->toDateString()){
                $subscription->delete();
            }
        }

       

        session()->put('last_corn_run',Carbon::now());

    }



}
