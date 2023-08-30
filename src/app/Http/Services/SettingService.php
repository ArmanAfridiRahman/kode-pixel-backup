<?php
namespace App\Http\Services;

use Illuminate\Http\File;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\Core\Setting;
use App\Enums\StatusEnum;
use App\Models\Core\File as CoreFile;
use App\Models\Core\Image as CoreImage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingService 
{

    /**
     * update  settings
     * @param array $request_data
     */
    public function updateSettings(array $request_data) :void{
       
        foreach(($request_data) as $key=>$value){
            
            if($key == 'aws_s3' || $key == 'ftp' ||  $key == 'pusher_settings' || $key == 'social_login' || $key == 'google_recaptcha' || $key == 'login_with' ){
                $value = json_encode($value);
            }
            
           try {
                Setting::updateOrInsert(
                    ['key' => $key],
                    ['value' => $value]
                );
           } catch (\Throwable $th) {
             
           }
        }
        optimize_clear();
    }


    /**
     * Update ticket Settings
     *
     * @param $request
     */
    public function ticketSettings( Request $request) :array{

        $status =  false;
        $newTicketSetting = [];
        foreach ($request->ticket_setting as $index => $field) {
            $newField = $field;
            if (is_null($field['name'])) {
                $newField['name'] = strtolower(str_replace(" ","_",$newField['labels']));
            }
            $newTicketSetting[$index] = $newField;
        }
        $request->merge(['ticket_setting' => $newTicketSetting]);

        try {
            $status =  true;
            $message =  translate("Ticket Setting has been updated");
            Setting::where('key','ticket_settings')->update(
                [
                    'value' => json_encode($newTicketSetting)
                ]
            );
          } catch (\Exception $exception) {
     
            $message = $exception->getMessage();
         }

         return [
            'status'=>  $status,
            'message'=>  $message,
         ];
    }
    /**
     * Update Registration Settings
     *
     * @param $request
     */
    public function registrationSettings(Request $request) :array{

        $status =  false;
        $newRegisterSetting = [];
        foreach ($request->registration as $index => $field) {
            $newField = $field;
            if (is_null($field['name'])) {
                $newField['name'] = strtolower(str_replace(" ","_",$newField['labels']));
            }
            $newRegisterSetting[$index] = $newField;
        }
        $request->merge(['registration' => $newRegisterSetting]);

        try {
            $status =  true;
            $message =  translate("Register Setting has been updated");
            Setting::where('key','user_registration_settings')->update(
                [
                    'value' => json_encode($newRegisterSetting)
                ]
            );
          } catch (\Exception $exception) {
            $message = $exception->getMessage();
         }

         return [
            'status'=>  $status,
            'message'=>  $message,
         ];
    }


    /**
     * settings validations
     * @return array
     */
    public function validationRules(array $request_data ,string $key = 'site_settings') :array{

        $rules = [];
        $message = [];

        foreach(array_keys($request_data) as $data){
            
            if($data == "expired_data_delete_after"){
                $rules[$key.".".$data] ='required|gt:-1|max:50000';
            }
            if($data == "web_route_rate_limit" || $data == "api_route_rate_limit"){
                $rules[$key.".".$data] ='required|numeric|gt:10|max:50000';
            }

            if($data == "slack_channel"){
                $rules[$key.".".$data] ='max:100';
            }
           
            else{
                $rules[$key.".".$data] ='required';
            }
      
            $message[$key.".".$data.'.required'] = ucfirst(str_replace('_',' ',$data)).' '.translate('Feild is Required');
        }
        return [
            'rules' =>  $rules,
            'message' =>$message
        ];
    }

    /**
     * Update Status
     *
     * @param $request
     * @return array
     */
    public function statusUpdate(Request $request) :array{

        $response['status'] = false;
        $response['message'] = translate('Some thing Went Wrong');
        try {
            Setting::where('key',$request->data['key'])->update([
                'value' => $request->data['status']
            ]);
    
            if($request->data['key'] == 'app_debug'){
                if($request->data['status'] ==  (StatusEnum::true)->status()){
                    update_env('APP_DEBUG=false',"APP_DEBUG=true");
                }
                else{
                    update_env('APP_DEBUG=true',"APP_DEBUG=false");
                }
            }
         
            if($request->data['key'] == 'registration'){
                $registration_settings =  json_decode(site_settings("user_authentication"),true);
                $registration_settings['registration'] = $request->data['status'];
        
                Setting::where('key','user_authentication')->update([
                    'value' => json_encode($registration_settings)
                ]);
            }


            if($request->data['key'] == 'default_recaptcha' &&  $request->data['status'] ==  (StatusEnum::true)->status()){
                $google_recaptcha =  json_decode(site_settings('google_recaptcha'),true);
                $google_recaptcha['status'] =  (StatusEnum::false)->status();
                Setting::where('key','google_recaptcha')->update([
                    'value' => json_encode($google_recaptcha )
                ]);
            }


            $response['status'] = true;
            $response['message'] = translate('Status Updated Successfully');
  
        } catch (\Exception $ex) {
            $response['message']  = $ex->getMessage();
        }

        return $response;
    }


    /**
     * logo settings
     *
     * @param Request $request
     * @return void
     */
    public function logoSettings(array $request) :void{
    
        $logos =  [];
         if ( isset($request['site_settings']['site_logo']) && is_file($request['site_settings']['site_logo']->getPathname())) {
            $site_logo = site_logo('site_logo')->image?->name;

            $response = FileService::storeFile($request['site_settings']['site_logo'] , config("settings")['file_path']['site_logo']['path'],config("settings")['file_path']['site_logo']['size'] ,$site_logo );
            if($response['status']){
                $logos ['site_logo'] = $response;
            }
          
        }

        if ( isset($request['site_settings']['user_site_logo']) && is_file($request['site_settings']['user_site_logo']->getPathname())) {
            $site_logo = site_logo('user_site_logo')->image?->name;
            $response = FileService::storeFile($request['site_settings']['user_site_logo'] , config("settings")['file_path']['user_site_logo']['path'],config("settings")['file_path']['user_site_logo']['size'] ,$site_logo );
            if($response['status']){
                $logos ['user_site_logo'] = $response;
            }
        }

        if ( isset($request['site_settings']['site_favicon']) && is_file($request['site_settings']['site_favicon']->getPathname())) {
            $site_logo = site_settings('site_favicon');
            $response = FileService::storeFile($request['site_settings']['site_favicon'] , config("settings")['file_path']['favicon']['path'],config("settings")['file_path']['favicon']['size'],$site_logo);
            if($response['status']){
                $logos ['site_favicon'] = $response;
            }

        }
        

        $this->updateLogo($logos);

    }

    public function updateLogo(array $logos) : void {

       foreach($logos as $key => $logo){
            $setting   = Setting::where('key',$key)->first();
            $setting->value = Arr::get( $logo ,'name',"#");
            $setting->save();
            $setting->file()->delete();
            $image = new CoreFile();
            $image->name =  Arr::get( $logo ,'name',"#");
            $image->disk =  Arr::get( $logo ,'disk',"local");
            $setting->file()->save($image);
        }
    }


}