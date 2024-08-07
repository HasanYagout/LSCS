<?php

namespace App\Http\Controllers\Company\Auth;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        // Attempt to find the company by email first
        $user = Company::where('email', $credentials['email'])->first();

        // Check if user exists and if the status is active
        if ($user && $user->status != 1) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['Your account is not active. Please contact Admin.']);
        }

        // Attempt authentication with the provided credentials
        if ($user && Auth::guard('company')->attempt($credentials, $request->remember)) {
            // Authentication successful
            return redirect()->route('company.home');
        }

        // Default response for failed authentication
        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Invalid email or password.']);
    }

    public function register()
    {
        return view('company.auth.register');
    }

    public function store(Request $request)
    {
        $folderName = Str::slug($request->name.'_'.now(), '_');
        $file= $request->file('proposal');
        $extension = $file->getClientOriginalExtension();
        $fileName = $folderName . '.' . $extension;
        $filePath = $file->storeAs('public/storage/company/proposal' . $fileName);

        $company = new Company();
        $company->name=$request->name;
        $company->slug=Str::slug($request->name).'_'.uniqid();
        $company->email=$request->email;
        $company->password=Hash::make($request->password);
        $company->phone=$request->mobile;
        $company->logo=$request->logo;
        $company->proposal=$fileName;
        $company->status=STATUS_PENDING;
        $company->save();
    }

    public function logout(Request $request)
    {
        auth()->guard('admin')->logout();
        $request->session()->invalidate();
        return redirect()->route('company.auth.login');
    }
}
