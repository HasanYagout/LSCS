<?php
/**
 * Created by PhpStorm.
 * User: rana
 * Date: 8/3/17
 * Time: 4:52 PM
 */

namespace App\Http\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    protected $defaultEmail;
    protected $defaultName;

    public function __construct()
    {
        $this->defaultEmail = env('MAIL_FROM_ADDRESS','noreply@'.env("APP_NAME"));
        $this->defaultName = env('MAIL_FROM_NAME',env("APP_NAME"));
    }


    public function send($template = '', $data = [], $to = '', $name = '', $subject = '')
    {
        try {
            Mail::send($template, $data, function ($message) use ($name, $to, $subject) {
                $message->to($to, $name)->subject($subject)->from(
                    $this->defaultEmail, $this->defaultName
                );
            });
            return [
                'error' => false,
                'message' => 'Email Sent'
            ];
        } catch (\Exception $e) {
            return [
                'error' => true,
                'message' => $e->getMessage()
            ];
        }
    }

}
