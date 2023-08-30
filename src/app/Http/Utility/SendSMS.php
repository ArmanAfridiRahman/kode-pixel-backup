<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use App\Models\Admin\SmsGateway;
use App\Models\Admin\Template;
use Textmagic\Services\TextmagicRestClient;
use Twilio\Rest\Client;

use GuzzleHttp\Client AS InfoClient;
use Infobip\Api\SendSmsApi;
use Infobip\Configuration;
use GuzzleHttp\Client as GazzleClient;
use Exception;
use Infobip\ApiException;
use Infobip\Model\SmsAdvancedTextualRequest;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
class SendSMS{


	

	public static function smsNotification(string $template, array $code = [] , object | null $userInfo = null , SmsGateway $gateway = null ) :array
    {
      
		if(!$gateway){
			$gateway = SmsGateway::where('default',StatusEnum::true->status())->first();
		}
	
        $smsTemplate = Template::where('slug', $template)->first();

        $messages = str_replace("{{name}}", @$userInfo->username ? $userInfo->username : $userInfo->name , site_settings('default_mail_template'));
        $messages = str_replace("{{message}}", @$smsTemplate->sms_body, $messages);
        foreach ($code as $key => $value) {
            $messages = str_replace('{{' . $key . '}}', $value, $messages);
        }

    	if($gateway->code === "101NEX"){
    		return self::nexmo($gateway->credential,  @$userInfo->phone, $messages);
    	}
        elseif($gateway->code === "102TWI"){
    		return self::twilio($gateway->credential,  @$userInfo->phone, $messages);
    	}
        elseif($gateway->code === "103BIRD"){
            return self::messageBird($gateway->credential,  @$userInfo->phone, $messages);
        }
        elseif($gateway->code === "104INFO"){
            return self::infobip($gateway->credential,  @$userInfo->phone, $messages);
        }

		return [
            "status" => false,
            "message" => translate('Gateway Not Found')
        ];
    }

	/**
	 * send nexmo sms
	 *
	 * @param object $credential
	 * @param string $to
	 * @param string $message
	 * @return array
	 */
	public static function nexmo(object $credential,string $to,string $message):array
	{

		$status = true;
        $responseMessage = translate("Sms Send Successfully");
		try {
			$basic = new \Vonage\Client\Credentials\Basic($credential->api_key, $credential->api_secret);
			$client = new \Vonage\Client($basic);
			$response = $client->sms()->send(
		    	new \Vonage\SMS\Message\SMS($to, $credential->sender_id, $message)
			);
			$message = $response->current();
			if($message->getStatus() != 0){
				$status = false;
                $responseMessage = translate("Faild To Send Sms!! Configuration Error");
			}

		} 
		catch (\Exception $e){
			$status = false;
            $responseMessage = $e->getMessage();
	    }

		return [
            "status" => $status,
            "message" => $responseMessage
        ];
		
	}

	/**
	 * send twilio sms
	 *
	 * @param object $credential
	 * @param string $to
	 * @param string $message
	 * @return array
	 */
	public static function twilio(object $credential,string $to,string $message):array
	{
		$status = true;
        $responseMessage = translate("Sms Send Successfully");
        try{
            $twilioNumber = $credential->from_number;
            $client = new Client($credential->account_sid, $credential->auth_token);
            $create = $client->messages->create('+'.$to, [
                'from' => $twilioNumber,
                'body' => $message
            ]);

        }catch (\Exception $e) {

	        $status = false;
            $responseMessage = $e->getMessage();
        }

		return [
            "status" => $status,
            "message" => $responseMessage
        ];
	}


	/**
	 * send messageBird message
	 *
	 * @param object $credential
	 * @param string $to
	 * @param string $message
	 * @return array
	 */
	public static function messageBird(object $credential,string $to,string $message) :array
	{
	
		$status = true;
        $responseMessage = translate("Sms Send Successfully");
		try {
			$MessageBird 		 = new \MessageBird\Client($credential->access_key);
			$Message 			 = new \MessageBird\Objects\Message();
			$Message->originator = $credential->sender_id;
			$Message->recipients = array($to);
			$Message->body 		 = $message;
			$MessageBird->messages->create($Message);

		} catch (\Exception $e) {
			$status = false;
            $responseMessage = $e->getMessage();
		}

		return [
            "status" => $status,
            "message" => $responseMessage
        ];
	}


	/**
	 * send infobip message
	 *
	 * @param object $credential
	 * @param string $to
	 * @param string $message
	 * @return array
	 */
	public static function infobip(object $credential,string $to,string $message)
	{
		$status = true;
        $responseMessage = translate("Sms Send Successfully");
		try {
			$BASE_URL = $credential->infobip_base_url;
			$API_KEY = $credential->infobip_api_key;
			$SENDER = $credential->sender_id;
			$RECIPIENT =  preg_replace('/[^0-9]/', '', $to) ;
			$MESSAGE_TEXT = strip_tags($message);

			$configuration = (new Configuration())
				->setHost($BASE_URL)
				->setApiKeyPrefix('Authorization', 'App')
				->setApiKey('Authorization', $API_KEY);
			$client = new GazzleClient();
			$sendSmsApi = new SendSMSApi($client, $configuration);
			$destination = (new SmsDestination())->setTo($RECIPIENT);
			$message = (new SmsTextualMessage())
				->setFrom($SENDER)
				->setText($MESSAGE_TEXT)
				->setDestinations([$destination]);
			$request = (new SmsAdvancedTextualRequest())->setMessages([$message]);
			$smsResponse = $sendSmsApi->sendSmsMessage($request);

		} catch (\Throwable $e) {
			$status = false;
            $responseMessage = $e->getMessage();
		}

		return [
            "status" => $status,
            "message" => $responseMessage
        ];
	}



}
