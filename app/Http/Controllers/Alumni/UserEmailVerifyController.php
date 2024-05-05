<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\UserEmailVerifyService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserEmailVerifyController extends Controller
{
    public $userEmailVerifyService;

    public function __construct()
    {
        $this->userEmailVerifyService = new UserEmailVerifyService;
    }

    public function emailVerified(Request $request, $token)
    {
        $otp = $request->otp__field__1.$request->otp__field__2.$request->otp__field__3.$request->otp__field__4;
        $verified =  $this->userEmailVerifyService->emailVerified($otp, $token);
        if ($verified == true) {
            return redirect()->route('login')->with('success', __('Congratulations! Successfully verified your email.'));
        } else {
            return redirect()->route('email.verify', $token)->with('error', __('Your otp doesn`t match or expired'));
        }
    }

    public function emailVerify($token)
    {
        $user = auth()->user();
        return view('auth.verify', compact('token', 'user'));
    }

    public function emailVerifyResend(Request $request, $token)
    {
        $user = $this->userEmailVerifyService->getUserByToken($token);

        if (getOption('email_verification_status', 0) == 1 && $user->email_verification_status != true && !(in_array($request->route()->getName(), ['email.verify']))) {
            
            try {
                if (!($user->otp_expiry >= now())) {
                    if (is_null($user->verify_token)) {
                        $user->verify_token = str_replace('-', '', Str::uuid()->toString());
                    }
                    
                    $user->otp = rand(1000, 9999);
                    $user->otp_expiry = now()->addMinute(5);
                    $user->save();

                    genericEmailNotify('',$user, NULL,'email-verification');

                    return redirect()->route('email.verify', $user->verify_token)->with('success', __('We have sent a fresh verify email.'));
                }
                else{
                    return redirect()->route('email.verify', $user->verify_token)->with('success', __('Already send an email. Please wait a minutes to try another'));
                }
                return redirect()->route('email.verify', $user->verify_token)->with('error', __('Verify Your Account'));
            }catch (Exception $e){
                return redirect()->route('email.verify', $user->verify_token)->with('error', __(SOMETHING_WENT_WRONG));
            }
    
            return redirect(route('email.verify', $user->verify_token));
        }else{
            return redirect(route('email.verify', $user->verify_token));
        }
    }
}
