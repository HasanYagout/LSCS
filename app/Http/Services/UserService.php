<?php

namespace App\Http\Services;

use App\Http\Services\SmsMail\TwilioService;
use App\Models\Alumni;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    use ResponseTrait;

    public function userDetails($id)
    {
        return User::find($id);
    }

    public function userData($id = NULL)
    {
        $id = is_null($id) ? auth()->id() : $id;
        return User::where('id', $id)->with(['alumni', 'institutions', 'currentMembership'])->first();
    }

    public function smsSend($request)
    {
        try {
            $user = User::where('id', auth()->id())->first();
            //check already send otp and this validate
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
                return $this->error([], __("An otp has already been sent to your phone number."));
            }
            //send new otp
            $phoneNumber = $user->mobile;
            $otp = rand(111111, 999999);
            $smsText = __("Your") . " " . getOption('app_name') . " " . __("verification code is") . ": " . $otp;
            $sendSmsStatus = TwilioService::sendSms($phoneNumber, $otp, $smsText);
            if ($sendSmsStatus == true) {
                $dateTime = Carbon::now()->addMinute(5);
                $expiryTime = $dateTime->format('Y-m-d H:i:s');
                //save otp and expiry time in user table
                $user->otp = $otp;
                $user->otp_expiry = $expiryTime;
                $user->mobile = $phoneNumber;
                $user->save();
                return $this->success([], __("OTP has been sent to your phone number,please check"));
            } else {
                return $this->error([], __("Something went wrong,please check your credentials"));
            }

        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function smsReSend()
    {

        try {
            $user = User::where('id', auth()->id())->first();
            //check already send otp and this validate
            $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
            if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
                return $this->error([], __("An otp has already been sent to your phone number."));
            }
            //send new otp
            $phoneNumber = $user->mobile;
            $otp = rand(111111, 999999);
            $smsText = __("Your") . " " . getOption('app_name') . " " . __("verification code is") . ": " . $otp;
            $sendSmsStatus = TwilioService::sendSms($phoneNumber, $otp, $smsText);
            if ($sendSmsStatus == true) {
                $dateTime = Carbon::now()->addMinute(5);
                $expiryTime = $dateTime->format('Y-m-d H:i:s');
                //save otp and expiry time in user table
                $user->otp = $otp;
                $user->otp_expiry = $expiryTime;
                $user->save();
                return $this->success([], __("OTP has been re-sent to your phone number,please check"));

            } else {
                return $this->error([], __("Something went wrong,please check your phone number"));
            }


        } catch (Exception $exception) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function smsVerify($request)
    {

        $otp = $request->opt_field[0] . $request->opt_field[1] . $request->opt_field[2] . $request->opt_field[3] . $request->opt_field[4] . $request->opt_field[5];
        $user = User::where('id', auth()->id())->first();
        //check otp validity
        $currentDateTime = Carbon::now()->format('Y-m-d H:i:s');
        if ($user->otp_expiry && $currentDateTime < $user->otp_expiry) {
            if ($user->otp == $otp) {
                $user->phone_verification_status = 1;
                $user->save();
                return $this->success([], __("OTP verify successful"));
            } else {
                return $this->error([], __("OTP is Invalid!"));
            }
        } else {
            return $this->error([], __("OTP time expiry!"));
        }

    }

    public function profileUpdate($request)
    {
        $authUser = auth()->user();

        try {
            DB::beginTransaction();
            $userData = [
                'name' => $request['name'],
                'nick_name' => $request['nick_name'],
                'mobile' => $request['mobile'],
            ];
            if(auth()->user()->mobile !=$request['mobile'])
            {
                $userData['phone_verification_status'] = STATUS_PENDING;
            }

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('user', $request->image);
                $userData['image'] = $uploaded->id;
            }

            $authUser->update($userData);

            Alumni::updateOrCreate(['user_id' => $authUser->id],[
                'user_id' => $authUser->id,
                'date_of_birth' => $request['date_of_birth'],
                'blood_group' => $request['blood_group'],
                'about_me' => $request['about_me'],
                'linkedin_url' => $request['linkedin_url'],
                'facebook_url' => $request['facebook_url'],
                'twitter_url' => $request['twitter_url'],
                'instagram_url' => $request['instagram_url'],
                'company' => $request['company'] ?? '',
                'company_designation' => $request['company_designation'] ?? '',
                'company_address' => $request['company_address'] ?? '',
                'city' => $request['city'],
                'state' => $request['state'],
                'country' => $request['country'],
                'zip' => $request['zip'],
                'address' => $request['address'],
            ]);

            foreach($request->institution['id'] ?? [] as $index => $id){
                $authUser->institutions()->where('id', $id)->update([
                    'passing_year' => $request->institution['passing_year'][$index],
                    'degree' => $request->institution['degree'][$index],
                    'institute' => $request->institution['institute'][$index],
                ]);
            }

            $authUser->institutions()->whereNotIn('id', $request->institution['id'] ?? [])->delete();

            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            dd($e);
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function addInstitution(Request $request)
    {
        $authUser = auth()->user();
        $data = $request->validate([
            "passing_year" =>  'bail|required|max:195',
            "degree" =>  'bail|required|max:195',
            "institute" =>  'bail|required|max:195',
        ]);

        try {
            DB::beginTransaction();

            $authUser->institutions()->create([
                'passing_year' => $data['passing_year'],
                'degree' => $data['degree'],
                'institute' => $data['institute'],
            ]);

            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }
    public function changePasswordUpdate(Request $request)
    {

        $request->validate([
            'current_password' => 'required',
            'password' => 'bail|required|min:6|confirmed',
        ]);

        try {
            $hashedPassword = Auth::user()->password;

            if (Hash::check($request->current_password, $hashedPassword)) {
                DB::beginTransaction();
                $user = User::find(Auth::id());
                $user->password = Hash::make($request->password);
                $user->save();
                DB::commit();
                return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
            } else {
                return $this->error([], "Current password dose not match!");
            }
        }catch (Exception $e){
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
    public function settingUpdate(Request $request)
    {
        try {
            auth()->user()->update([$request->key => $request->value]);
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }
}
