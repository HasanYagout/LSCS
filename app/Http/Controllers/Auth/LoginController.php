<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\User;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;

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
        $user = User::with('admin','alumni','company')->where('email', $request->email)->first();

        if (isset($user) && $user->status != 1) {
            return redirect()->back()->withInput($request->only('email', 'remember'))
                ->withErrors(['You are blocked!!, contact with admin.']);
        }
        else {
            if (isset($user)){
                if ($user->role_id == 1) {
                    if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                        return redirect()
                            ->route('admin.dashboard')
                            ->with('info', 'Welcome ' . $user->admin->first_name);
                    }
                }
                elseif ($user->role_id == 2){
                    if (auth('alumni')->attempt(['id' => $request->email, 'password' => $request->password], $request->remember)) {
                        return redirect()
                            ->route('alumni.home')
                            ->with('info', 'Welcome ' . $user->alumni->first_name);
                    }
                }
                elseif ($user->role_id == 3){
                    if (auth('company')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                        return redirect()
                            ->route('company.jobs.all-job-post')
                            ->with('info', 'Welcome ' . $user->company->name);
                    }
                }
                else{
                    if (auth('admin')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {
                        return redirect()
                            ->route('admin.instructor.dashboard')
                            ->with('info', 'Welcome ' . $user->admin->first_name);
                    }
                }
            }
            else{
                return redirect()->back()->withInput($request->only('email', 'remember'))
                    ->withErrors(['User Not Found']);
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
