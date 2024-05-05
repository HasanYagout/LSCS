<?php

namespace App\Http\Services\SmsMail;

use App\Traits\ResponseTrait;
use Twilio\Exceptions\ConfigurationException;
use Twilio\Rest\Client;
use Exception;
class TwilioService
{
    use ResponseTrait;
    public static function sendSms($phoneNo,$otp,$smsText){
        if(getOption('app_sms_status') != 1){
            return false;
        }
        $sid = getOption('TWILIO_ACCOUNT_SID');
        $token = getOption('TWILIO_AUTH_TOKEN');
        $from_number = getOption('TWILIO_PHONE_NUMBER');
        try {
            $twilio = new Client($sid, $token);
            $sendStatus = $twilio->messages
            ->create($phoneNo, // to
                array(
                "from" => $from_number,
                "body" => $smsText
                )
            );
            return true;

        } catch (Exception $e) {
           return false;
        }
        // if($sendStatus->status == 'queued' || $sendStatus->status == 'delivered'){
        //     return true;
        // }else{
        //     return false;
        // }
    }
}
