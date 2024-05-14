<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    use ResponseTrait;

    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function profile()
    {
        $data['activeProfile'] = 'active';
        $data['user'] = $this->userService->userData();
        return view('alumni.profile',$data);
    }

    public function userProfileUpdate(ProfileRequest $request){
        return $this->userService->profileUpdate($request);
    }

    public function addInstitution(Request $request){

        return $this->userService->addInstitution($request);
    }

    public function changePasswordUpdate(Request $request)
    {
       return $this->userService->changePasswordUpdate($request);
    }

    public function security(){
        $user = User::where('id',auth()->user()->id)->first();
        $google2fa = new Google2FA();
        $data['qr_code']= $google2fa->getQRCodeInline(
            getOption('app_name'),
            $user->email,
            $user->google2fa_secret
        );
        return view('profile.security',$data);
    }

    public function smsSend(Request $request){
        return $this->userService->smsSend($request);
    }
    public function smsReSend(){
        return $this->userService->smsReSend();
    }
    public function smsVerify(Request $request){
        $request->validate([
            'opt-field.*' => 'required|numeric|',
        ]);
        return $this->userService->smsVerify($request);
    }

}
