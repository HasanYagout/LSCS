<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;


class SettingController extends Controller
{
    use ResponseTrait;

    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }
   
    public function settings()
    {
        $user = auth()->user();
        $google2fa = new Google2FA();
        $data['qr_code'] = $google2fa->getQRCodeInline(
            getOption('app_name'),
            $user->email,
            $user->google2fa_secret
        );
        $data['activeSettings'] = 'active';
        $data['user'] = $this->userService->userData();
        return view('alumni.settings',$data);
    }
    
    public function changePasswordUpdate(Request $request)
    {
       return $this->userService->changePasswordUpdate($request);
    }

    public function settingUpdate(Request $request)
    {
        return $this->userService->settingUpdate($request);
    }
}
