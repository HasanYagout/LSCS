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
            'email' => 'required|exists:users,email',
            'password' => 'required|min:8',
        ]);

        $user = User::where('email', $request->email)
            ->where('status',1)
            ->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            // Check if the user is authenticated
            if (Auth::check()) {
                // Redirect based on user role
                switch ($user->role_id) {
                    case 1:
                        return redirect()->route('admin.home');
                    case 2:
                        return redirect()->route('alumni.home');
                    case 3:
                        return redirect()->route('company.jobs.all-job-post');
                    case 4:
                        return redirect()->route('admin.instructor.dashboard');
                    default:
                        Auth::logout();
                        return redirect()->route('auth.login')->withErrors([
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
        else{
            return back()->withErrors([
                'email' => 'You Are Blocked Contact with Admin',
            ]);
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
            'email' => 'required|email|max:255|unique:users,email',
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
            $file->storeAs('public/company/proposal', $fileName);
        } else {
            return redirect()->back()->withErrors(['proposal' => 'Proposal file is required'])->withInput();
        }

        $defaultPassword = Hash::make($request->password);
        DB::transaction(function () use ($request, $fileName, $defaultPassword) {
            // Create new user record
            $user=User::create([
                'email' => $request->input('email'),
                'password' => $defaultPassword,
                'role_id' => 3,
                'status' => STATUS_PENDING,
            ]);

            // Create new company record
            Company::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')) . '_' . uniqid(),
                'phone' => $request->input('mobile'),
                'proposal' => $fileName,
                'user_id' => $user->id,
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
