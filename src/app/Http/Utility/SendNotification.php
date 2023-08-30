<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use App\Models\CustomNotifications;
use App\Models\MailConfiguration;
use Illuminate\Support\Facades\Mail;
use GuzzleHttp\Client;
use App\Models\EmailTemplates;
use App\Models\Notification;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rules\Enum;

class SendNotification
{

       

       /**
        * send database notifications
        */
       public static function  database_notifications(array $data) :Notification{
        
            $notification = new Notification();
            // $notification->user_id =  Arr::get($data,'user_id',null);
            // $notification->admin_id = Arr::get($data,'admin_id',null);
            // $notification->message = translate(Arr::get($data,'message',""));
            // $notification->url = Arr::get($data,'url',"");
            // $notification->is_read =  (StatusEnum::false)->status();
            // $notification->save();
            return  $notification;
       }

       public static function slack_notifications(array $data ,string $type = 'Test Notifications') :array{

            $status = true;
            $message = translate("Notify Successfully");

            $webhookUrl =  site_settings("slack_web_hook_url");
            $client = new Client();
            $dateTime = "*  ".get_date_time(Carbon::now())."* ".  " | ".  translate($type);
            $payload = [
                "blocks" => array(
                    array(
                        "type" => "header",
                        "text" => array(
                            "type" => "plain_text",
                            "text" => ":bell:  ".  translate('New Notifications')  ." :bell:"
                        )
                    ),
                    array(
                        "type" => "context",
                        "elements" => array(
                            array(
                                "text" => $dateTime,
                                "type" => "mrkdwn"
                            )
                        )
                    ),
                    array(
                        "type" => "divider"
                    ),
                    array(
                        "type" => "section",
                        "text" => array(
                            "type" => "mrkdwn",
                            "text" => " :loud_sound: *IN CASE YOU MISSED IT* :loud_sound:"
                        )
                    ),
                    array(
                        "type" => "section",
                        "text" => array(
                            "type" => "mrkdwn",
                            "text" => $data['messsage']
                        ),
                        "accessory" => array(
                            "type" => "button",
                            "text" => array(
                                "type" => "plain_text",
                                "text" => $data['ticket_id'],
                                "emoji" => true
                            ),
                            "url"=> $data['route'],
                            "style" => "primary",
                        )
                    ),
                
                )
         
            ];

            if(site_settings("slack_channel")){
                $payload['channel'] = site_settings("slack_channel");
            }

            try {
                $client->request('POST', $webhookUrl, [
                    'json' => $payload,
                ]);
            } catch (\Exception $e) {
                 $status = false;
                 $message = $e->getMessage();
            }
    

            return [
                'status' =>  $status ,
                'message' =>  $message ,
            ];
       }

}