<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Mail\UserEmailVerification;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Mail;
use PharIo\Manifest\Exception;

class UserController extends Controller
{
    use ResponseTrait;


    public function emailVerified($token)
    {
        if (User::where('remember_token', $token)->count() > 0) {
            $user = User::where('remember_token', $token)->first();
            $user->status = USER_STATUS_ACTIVE;
            $user->email_verified_at = Carbon::now()->format("Y-m-d H:i:s");
            $user->email_verification_status = 1;
            $user->save();
            return redirect()->route('login')->with('success', __('Congratulations! Successfully verified your email.'));
        } else {
            return redirect(route('login'));
        }
    }

    public function emailVerify($token)
    {
        try {
            if(!request()->cookie('verify_email_send')){
                $user = User::where('verify_token', $token)->firstOrFail();
                Mail::to($user->email)->send(new UserEmailVerification($user));
                Cookie::queue('verify_email_send', true, 1);
                return redirect()->back()->with('success', __(SENT_SUCCESSFULLY));
            }
            else{
                return redirect()->back()->with('success',__('Already send an email. Please wait a minutes to try another'));
            }
        } catch (Exception $exception) {
            return redirect()->back()->with('error', __(SOMETHING_WENT_WRONG));
        }
    }

    public function emailVerifyResend($token)
    {
        try {
            if (getOption('email_verification_status', 0) == 1) {
                $user = User::where('remember_token', $token)->firstOrFail();
                Mail::to($user->email)->send(new UserEmailVerification($user));
                return redirect()->route('login')->with('success', __(SENT_SUCCESSFULLY));
            } else {
                return redirect()->route('login')->with('error', __(SOMETHING_WENT_WRONG));
            }
        } catch (Exception $e) {
            return redirect()->route('login')->with('error', __(SOMETHING_WENT_WRONG));
        }
    }
}
