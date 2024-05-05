<?php

namespace App\Http\Services;

use App\Http\Repositories\AdminSettingRepository;
use App\Http\Services\SmsMail\TwilioService;
use App\Mail\CustomizeMail;
use App\Models\Alumni;
use Illuminate\Support\Str;
use App\Models\EmailTemplate;
use App\Models\Gateway;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Arr;
use App\Models\License;
use App\Models\MailHistory;
use App\Models\Plan;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SettingsService
{
    use ResponseTrait;
    public function cookieSettingUpdated($request)
    {

        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key, 'tenant_id' => getTenantId()]);

            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function commonSettingUpdate($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {


            $option = Setting::firstOrCreate(['option_key' => $key, 'tenant_id' => getTenantId()]);

            if ($request->hasFile('cookie_image') && $key == 'cookie_image') {
                $upload = settingImageStoreUpdate($value, $request->cookie_image);
                $option->option_value = $upload;
                $option->save();
            } else {
                $option->option_value = $value;
                $option->save();
            }
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function smsConfigurationStore($request)
    {
        $inputs = Arr::except($request->all(), ['_token']);

        foreach ($inputs as $key => $value) {

            $option = Setting::firstOrCreate(['option_key' => $key, 'tenant_id' => getTenantId()]);
            $option->option_value = $value;
            $option->save();
        }

        return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
    }

    public function smsTest($request)
    {
        try {
            $phoneNumber = trim($request->get('to'));
            $smsText = trim($request->get('message'));

            $sendSmsStatus = TwilioService::sendSms($phoneNumber, '', $smsText);
            if ($sendSmsStatus == true) {

                return $this->success([], __("Test sms has been sent to your phone number"));
            } else {
                return $this->error([], __("Something went wrong,please check your phone number"));
            }
        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function emailTemplateConfig($request)
    {
        try {
            if (!in_array($request->category, [EMAIL_TEMPLATE_PAYMENT_SUCCESS, EMAIL_TEMPLATE_PAYMENT_FAILURE, EMAIL_TEMPLATE_INVOICE, EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION, EMAIL_TEMPLATE_FORGOT_PASSWORD, EMAIL_TEMPLATE_PAYMENT_CANCEL, EMAIL_TEMPLATE_EMAIL_VERIFY])) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            $data['template'] = EmailTemplate::updateOrCreate([
                'category' => $request->category,
                'tenant_id' => getTenantId()
            ], [
                'category' => $request->category,
                'tenant_id' => getTenantId()
            ]);
            $data['fields'] = emailTempFields($request->category);
            return $this->success($data);
        } catch (Exception $e) {
            return $this->error([], $e->getMessage());
        }
    }

    public function emailTemplateConfigUpdate($request)
    {
        DB::beginTransaction();
        try {
            if (!in_array($request->category, [EMAIL_TEMPLATE_PAYMENT_SUCCESS, EMAIL_TEMPLATE_PAYMENT_FAILURE, EMAIL_TEMPLATE_INVOICE, EMAIL_TEMPLATE_SUBSCRIPTION_CANCELLATION, EMAIL_TEMPLATE_FORGOT_PASSWORD, EMAIL_TEMPLATE_PAYMENT_CANCEL, EMAIL_TEMPLATE_EMAIL_VERIFY])) {
                throw new Exception(__(SOMETHING_WENT_WRONG));
            }
            EmailTemplate::updateOrCreate([
                'category' => $request->category,
                'tenant_id' => getTenantId()
            ], [
                'category' => $request->category,
                'tenant_id' => getTenantId(),
                'subject' => $request->subject,
                'body' => $request->body,
            ]);
            DB::commit();
            return $this->success([], __(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], $e->getMessage());
        }
    }
}
