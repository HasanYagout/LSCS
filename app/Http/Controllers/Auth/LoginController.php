<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Models\Admin;
use Illuminate\Support\Str;

class LoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin', ['except' => ['logout']]);
    }



    public function login()
    {

        return view('auth.login');
    }

    public function submit(Request $request)
    {
        // Validation based on user type

            $request->validate([
                'email' => 'required|email|exists:users,email',
                'password' => 'required|min:8'
            ]);



        // Authenticate based on user type

            $user = User::where('email', $request->email)->first();

            if (isset($user) && $user->status != 1) {
                return redirect()->back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['You are blocked!!, contact with admin.']);
            } else {
                if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                    return redirect()
                        ->route('admin.dashboard')
                        ->with('info', 'Welcome ' . $user->first_name);
                }
            }


        return redirect()->back()->withInput($request->only('email', 'remember'))
            ->withErrors(['Credentials do not match.']);
    }

    public function store(Request $request)
    {
        // Validation rules
        $request->validate([
            'name' => 'required|string|max:255',
            'mobile' => 'required|string|max:15',
            'email' => 'required|email|max:255|unique:companies,email',
            'proposal' => 'required|file|mimes:pdf|max:2048', // Accept PDF files up to 2MB
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Handle file upload
        if ($request->hasFile('proposal')) {
            $folderName = Str::slug($request->name . '_' . now(), '_');
            $file = $request->file('proposal');
            $extension = $file->getClientOriginalExtension();
            $fileName = $folderName . '.' . $extension;
            $filePath = $file->storeAs('public/storage/company/proposal', $fileName);
        } else {
            return redirect()->back()->withErrors(['proposal' => 'Proposal file is required'])->withInput();
        }

        // Create new company record
        $company = new Company();
        $company->name = $request->name;
        $company->slug = Str::slug($request->name) . '_' . uniqid();
        $company->email = $request->email;
        $company->password = Hash::make($request->password);
        $company->phone = $request->mobile;
        $company->proposal = $fileName;
        $company->status = STATUS_PENDING;
        $company->save();

        // Redirect or return response
        return redirect()->route('auth.login')->with('success', 'Registration successful. Please log in.');
    }



    public function logout(Request $request)
    {
        $guard = getAuthenticatedGuard();

        if ($guard) {
            auth($guard)->logout();
            $request->session()->invalidate();
        }

        return redirect()->route('auth.login');
    }

    public function register()
    {

        return view('auth.register');
    }
}
