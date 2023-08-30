<?php
namespace App\Http\Utility;

use App\Enums\StatusEnum;
use App\Models\Admin\MailGateway;
use App\Models\Admin\Template;
use Illuminate\Support\Facades\Mail;

class SendMail
{

    /**
     * send  mail notification
     *
     * @param string $template
     * @param array $code
     * @param object | null  $userInfo
     * @param MailGateway $gateway
     * @return array
     */
    public static function mailNotifications(string $template, array $code = [] , object | null $userInfo = null , MailGateway $gateway = null ):array
    {
      
        if(!$gateway){
            $gateway = MailGateway::where('default',StatusEnum::true->status())->first();
        }

        $emailTemplate = Template::where('slug', $template)->first();
        $messages = str_replace("{{name}}", @$userInfo->username ? $userInfo->username : $userInfo->name , site_settings('default_mail_template'));

        $messages = str_replace("{{message}}", @$emailTemplate->body, $messages);

        foreach ($code as $key => $value) {
            $messages = str_replace('{{' . $key . '}}', $value, $messages);
        }

    	if($gateway->code === "104PHP"){
    		return self::sendPhpMail(site_settings('email'),  site_settings('site_name'), $userInfo->email, $emailTemplate->subject, $messages);
    	}
        elseif($gateway->code === "101SMTP"){
    		return self::sendSMTPMail($gateway->credential->from->address, $userInfo->email,  site_settings('site_name'), $emailTemplate->subject, $messages);
    	}
        elseif($gateway->code === "102SENDGRID"){
            return  self::sendGrid($gateway->credential->from->address,site_settings('site_name'), @$userInfo->email, $emailTemplate->subject, $messages, @$gateway->credential->app_key);
        }

        return [
            "status" => false,
            "message" => translate('Gateway Not Found')
        ];
    }

    /**
     * send php mail
     * @param string $emailFrom
     * @param string $sitename
     * @param string $emailTo
     * @param string $subject
     * @param string $messages
     * @return array
     */
    public static function sendPhpMail(string $emailFrom, string $sitename,string $emailTo, string $subject,string $messages) :array
    {

        $status = true;
        $responseMessage = translate("Email Send Successfully");
        $headers = "From: $sitename <$emailFrom> \r\n";
        $headers .= "Reply-To: $sitename <$emailFrom> \r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=utf-8\r\n";
      
        try {
            @mail($emailTo, $subject, $messages, $headers); 
    
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
     * send smtp mail
     *
     * @param string $emailFrom
     * @param string $emailTo
     * @param string $fromName
     * @param string $subject
     * @param string $messages
     * @return array
     */
    public static function sendSMTPMail(string $emailFrom, string $emailTo, string $fromName, string $subject, string $messages) :array
    {

        $status = true;
        $responseMessage = translate("Email Send Successfully");

        try{
            Mail::send([], [], function ($message) use ($messages, $emailFrom, $fromName, $emailTo, $subject) {
                $message->to($emailTo) 
                ->subject($subject)
                ->from($emailFrom,$fromName)
                ->html($messages, 'text/html','utf-8');
            });

        }catch (\Exception $e){
            $status = false;
            $responseMessage = $e->getMessage();
        }

        return [
            "status" => $status,
            "message" => $responseMessage
        ];
    }


    /**
     * send sendgrid  mail
     *
     * @param string $emailFrom
     * @param string $fromName
     * @param string $emailTo
     * @param string $subject
     * @param string $messages
     * @param string $credentials
     * @return array
     */
    public static function sendGrid(string $emailFrom, string $fromName,string $emailTo, string $subject, string $messages, string $credentials) :array
    { 
        $status = true;
        $responseMessage = translate("Email Send Successfully");
        try{
            $email = new \SendGrid\Mail\Mail();
            $email->setFrom($emailFrom, $fromName);
            $email->setSubject($subject);
            $email->addTo($emailTo);
            $email->addContent("text/html", $messages);
            $sendgrid = new \SendGrid($credentials);
            $response = $sendgrid->send($email);

    
            if (!in_array($response->statusCode(), ['201','200','202'])){
                $status = false;
                $responseMessage = translate("Faild To Send Email!! Configuration Error");
            }
            
        }catch(\Exception $e){

            $status = false;
            $responseMessage = $e->getMessage();
        }

        return [
            "status" => $status,
            "message" => $responseMessage
        ];


    }
}