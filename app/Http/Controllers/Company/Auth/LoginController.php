<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

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
        $company = Company::where('email', $request->email)->first();
        if (! $company || ! Hash::check($request->password, $company->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        elseif(Hash::check($request->password, $company->password) && $company->status==STATUS_PENDING){
            throw ValidationException::withMessages([
                'email' => ['Your account is pending approval.'],
            ]);
        }

        return redirect()->route('company.home');
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
        $company->phone=$request->mobile;
        $company->logo=$request->logo;
        $company->proposal=$request->file('proposal')->getClientOriginalName();
        $company->status=STATUS_PENDING;
        $company->save();
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('admin.auth.login');
    }
}
