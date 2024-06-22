<?php

namespace App\Http\Controllers\Web\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Gregwar\Captcha\PhraseBuilder;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

    public function captcha($tmp)
    {

        $phrase = new PhraseBuilder;
        $code = $phrase->build(4);
        $builder = new CaptchaBuilder($code, $phrase);
        $builder->setBackgroundColor(220, 210, 230);
        $builder->setMaxAngle(25);
        $builder->setMaxBehindLines(0);
        $builder->setMaxFrontLines(0);
        $builder->build($width = 100, $height = 40, $font = null);
        $phrase = $builder->getPhrase();

        if(Session::has('default_captcha_code')) {
            Session::forget('default_captcha_code');
        }
        Session::put('default_captcha_code', $phrase);
        header("Cache-Control: no-cache, must-revalidate");
        header("Content-Type:image/jpeg");
        $builder->output();
    }

    public function login()
    {

        return view('web.auth.login');
    }

    public function submit(Request $request)
    {
        $credentials=$request->validate([
            'student_id' => 'required|digits:8',
            'password' => 'required|min:6'
        ]);


        if (Auth::guard('alumni')->attempt($credentials, $request->remember)) {
            // Authentication successful
            return redirect()->route('alumni.home');
        } else {
            // Authentication failed
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Invalid email or password.']);
        }
    }

    public function logout(Request $request)
    {
        auth()->guard('alumni')->logout();
        $request->session()->invalidate();
        return redirect()->route('alumni.auth.login');
    }
}
