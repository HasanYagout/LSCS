<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use App\CPU\Helpers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Gregwar\Captcha\PhraseBuilder;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }

//    public function captcha($tmp)
//    {
//
//        $phrase = new PhraseBuilder;
//        $code = $phrase->build(4);
//        $builder = new CaptchaBuilder($code, $phrase);
//        $builder->setBackgroundColor(220, 210, 230);
//        $builder->setMaxAngle(25);
//        $builder->setMaxBehindLines(0);
//        $builder->setMaxFrontLines(0);
//        $builder->build($width = 100, $height = 40, $font = null);
//        $phrase = $builder->getPhrase();
//
//        if(Session::has('default_captcha_code')) {
//            Session::forget('default_captcha_code');
//        }
//        Session::put('default_captcha_code', $phrase);
//        header("Cache-Control: no-cache, must-revalidate");
//        header("Content-Type:image/jpeg");
//        $builder->output();
//    }

    public function login()
    {
        return view('company.auth.login');
    }

    public function submit(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);
        $admin = Admin::where('email', $request->email)->first();
        if (isset($admin) && $admin->status != 1) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['You are blocked!!, contact with admin.']);
        }else{
            if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                return redirect()->route('admin.dashboard');
            }
        }

        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials does not match.']);
    }

    public function register()
    {
        return view('company.auth.register');
    }

    public function store(Request $request)
    {
        $company = new Company();
        $company->name=$request->name;
        $company->email=$request->email;
        $company->password=Hash::make($request->password);
        $company->address=$request->address;
        $company->website=$request->website;
        $company->phone=$request->phone;
        $company->logo=$request->logo;
        $company->proposal=$request->file('proposal')->getClientOriginalName();

    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.auth.login');
    }
}
