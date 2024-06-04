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
use Illuminate\Support\Str;

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
        return Alumni::where('id', $id)->first();
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
        $authUser = auth('alumni')->user();
        try {
            DB::beginTransaction();
            $filename = $authUser->image; // Set default to current image in case no new image is uploaded

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $date = now()->toDateString();
                $randomSlug = Str::slug(Str::random(8)); // Create a random slug
                $randomNumber = rand(100, 999);
                $filename = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $image->getClientOriginalExtension();
                $image->storeAs('alumni/image', $filename, 'public');
            }


            foreach($request->education['id'] ?? [] as $index => $id){

                $authUser->education()->where('id', $id)->update([
                    'type' => $request->education['education_type'][$index],
                    'name' => $request->education['education_name'][$index],
                    'details' => $request->education['education_details'][$index],
                    'start_date' => $request->education['education_start_date'][$index],
                    'end_date' => $request->education['education_end_date'][$index],
                ]);
            }

            $authUser->education()->whereNotIn('id', $request->education['id'] ?? [])->delete();


            Alumni::updateOrCreate(['id' => $authUser->id],[
                'first_name'=> $request['first_name']?? $authUser->first_name,
                'last_name'=> $request['last_name']?? $authUser->last_name,
                'date_of_birth' => $request['date_of_birth']?? $authUser->date_of_birth,
                'about_me' => $request['about_me']?? $authUser->about_me,
                'image' => $filename,
                'linkedin_url' => $request['linkedin_url']?? $authUser->linkedin_url,
                'facebook_url' => $request['facebook_url']?? $authUser->facebook_url,
                'twitter_url' => $request['twitter_url']?? $authUser->twitter_url,
                'instagram_url' => $request['instagram_url']?? $authUser->instagram_url,
                'Company' => $request['Company'] ?? $authUser->Company,
                'company_designation' => $request['company_designation'] ?? '',
                'company_address' => $request['company_address'] ?? '',
                'city' => $request['city']?? $authUser->city,
                'address' => $request['address']?? $authUser->address,
                'skills' => json_encode($request->skills)?? $authUser->skills,
            ]);



            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();

            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function addEducation(Request $request)
    {
        $authUser = auth('alumni')->user();
        $data = $request->validate([
            "education_type" =>  'bail|required|max:195',
            "education_name" =>  'bail|required|max:195',
            "education_details" =>  'bail|required|max:1000',
            "education_start_date" =>  'required',
            "education_end_date" =>  'required',
        ]);
        try {
            DB::beginTransaction();

            $authUser->education()->create([
                'alumni_id'=>auth('alumni')->user()->id,
                'type' => $data['education_type'],
                'name' => $data['education_name'],
                'details' => $data['education_details'],
                'education_start_date' => $data['education_start_date'],
                'education_end_date' => $data['education_end_date'],
            ]);



            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            dd($e);
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
