<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\Admin;
use App\Models\FileManager;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class   ProfileController extends Controller
{
    public function myProfile()
    {
        $user = Auth::user();
        $userInfo = null;

        switch ($user->role_id) {
            case 1:
                $userInfo = $user->admin;
                break;
            case 2:
                $userInfo = $user->alumni;
                break;
            case 3:
                $userInfo = $user->company;
                break;
            default:
                abort(403, 'Unauthorized action.');
        }

        $data = [
            'pageTitle' => 'Profile',
            'navAccountSettingActiveClass' => 'mm-active',
            'subNavProfileActiveClass' => 'mm-active',
            'userInfo' => $userInfo,
        ];
        return view('admin.profile.index', $data);
    }




    public function update(Request $request)
    {

        $authUser = Auth::user();
        try {
            DB::beginTransaction();
            $filename = $authUser->admin->image; // Set default to current image in case no new image is uploaded

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $date = now()->toDateString();
                $randomSlug = Str::slug(Str::random(8)); // Create a random slug
                $randomNumber = rand(100, 999);
                $filename = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $image->getClientOriginalExtension();
                $image->storeAs('admin/image', $filename, 'public');
            }

            Admin::updateOrCreate(['id' => $authUser->admin->id],[
                'first_name'=>Str::ucfirst($request['f_name']),
                'last_name'=>Str::ucfirst($request['l_name']),
                'image' => $filename,
                'phone' => $request['mobile'],
            ]);



            DB::commit();
            session()->flash('success', 'Profile Updated Successfully');
            return redirect()->route('admin.profile.index');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();

            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
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

        $user = Auth::user();
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
            Auth::logout();
            return redirect()->route('auth.login')->with('success', 'Password updated successfully. Please log in with your new password.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('active_tab', 'editProfile-tab');
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }


}
