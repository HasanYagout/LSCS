<?php

namespace App\Http\Services;

use App\Models\User;
use Exception;

class UserEmailVerifyService
{
    public function emailVerified($otp, $token)
    {
        try {
            $user = User::where('verify_token', $token)->first();
            if ($user && $user->otp_expiry >= now() && $otp == $user->otp) {
                $user->email_verification_status = STATUS_ACTIVE;
                $user->save();
                return true;
            }else{
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    public function getUserByToken($token)
    {
        return User::where('verify_token', $token)->first();
    }
}
