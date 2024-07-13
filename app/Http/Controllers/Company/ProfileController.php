<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    public function index()
    {

        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavProfileActiveClass'] = 'mm-active';
        return view('company.profile.index', $data);
    }

    public function changePassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|min:8',
            'new_password' => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            session()->flash('active_tab', 'editProfile-tab');
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Validation failed.');
        }

        $user = auth('company')->user();
        if (!Hash::check($request->current_password, $user->password)) {
            session()->flash('active_tab', 'editProfile-tab');
            return redirect()->back()
                ->with('error', 'The current password is incorrect.');
        }
        // Check if the new password is the same as the old password
        if (Hash::check($request->new_password, $user->password)) {
            return back()->withErrors(['new_password' => 'New password cannot be the same as the old password'])
                ->with('active_tab', 'editProfile-tab');
        }

        DB::beginTransaction();
        try {
            $user->password = Hash::make($request->new_password);
            $user->save();
            DB::commit();

            // Log out the user and redirect to login page with a success message
            auth('company')->logout();
            return redirect()->route('company.auth.login')->with('success', 'Password updated successfully. Please log in with your new password.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('active_tab', 'editProfile-tab');
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
