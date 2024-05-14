<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Session;
use PDF;
use Illuminate\Http\Request;
use PragmaRX\Google2FAQRCode\Google2FA;

class GoogleAuthController extends Controller
{
    use ResponseTrait;

    public function verifyView()
    {
        return view('auth.2fa-verify');
    }

    public function verify(Request $request)
    {
        $user = User::where('id',auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if($status == true){
            Session::put('2fa_status', true);
            return redirect()->route('home');
        }else{
            return redirect()->back()->with('error', __('Code dose not match'));
        }
    }

    public function enable(Request $request)
    {
        $request->validate([
            'one_time_password' => 'required'
        ]);
        $user = User::where('id',auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if($status == true){
            $user->google_auth_status = 1;
            $user->save();
            return $this->success([], __("Enabled Successfully"));
        }else{
            return $this->error([], __("Code dose not match!"));
        }
    }

    public function disable(Request $request)
    {
        $user = User::where('id',auth()->user()->id)->first();
        $status = (new Google2FA)->verifyKey($user->google2fa_secret, $request->one_time_password);
        if($status == true){
            $user->google_auth_status = 0;
            $user->save();
            return $this->success([], __("Disabled Successfully"));
        }else{
            return $this->error([], __("Code dose not match!"));
        }
    }

}
