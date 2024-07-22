<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Check if the user is authenticated
            if (Auth::check()) {
                // Redirect based on user role
                switch ($user->role_id) {
                    case 1:
                        return redirect()->route('admin.home');
                    case 2:
                        return redirect()->route('company.home');
                    case 3:
                        return redirect()->route('alumni.home');
                    default:
                        Auth::logout();
                        return redirect()->route('login.form')->withErrors([
                            'email' => 'Invalid role specified.',
                        ]);
                }
            } else {
                // Add debug information
                return back()->withErrors([
                    'email' => 'Authentication failed. Please try again.',
                ]);
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
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

        $fileName = null;

        // Handle file upload
        if ($request->hasFile('proposal')) {
            $folderName = Str::slug($request->name . '_' . now(), '_');
            $file = $request->file('proposal');
            $extension = $file->getClientOriginalExtension();
            $fileName = $folderName . '.' . $extension;
            $file->storeAs('public/storage/company/proposal', $fileName);
        } else {
            return redirect()->back()->withErrors(['proposal' => 'Proposal file is required'])->withInput();
        }

        $defaultPassword = Hash::make($request->password);
        DB::transaction(function () use ($request, $fileName, $defaultPassword) {
            // Create new company record
            $company = Company::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')) . '_' . uniqid(),
                'email' => $request->input('email'),
                'password' => $defaultPassword,
                'phone' => $request->input('mobile'),
                'proposal' => $fileName,
                'status' => STATUS_PENDING,
            ]);

            // Create new user record
            User::create([
                'email' => $request->input('email'),
                'password' => $defaultPassword,
                'user_id' => $company->id,
                'role_id' => 3,
                'status' => STATUS_PENDING,
            ]);
        });

        // Redirect or return response
        return redirect()->route('auth.login')->with('success', 'Registration successful. Please log in.');
    }



    public function logout(Request $request)
    {
        $guard = getAuthenticatedGuard();

        if ($guard) {
            auth($guard)->logout();
            $request->session()->invalidate();
            $request->session()->flash('success', 'You have been logged out successfully!');
        }

        return redirect()->route('auth.login');
    }

    public function register()
    {

        return view('auth.register');
    }
}
