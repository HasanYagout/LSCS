<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function index()
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

        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavProfileActiveClass'] = 'mm-active';
        $data['userInfo'] = $userInfo;
        return view('company.profile.index', $data);
    }
    public function update(Request $request)
    {
        $authUser = auth('company')->user();
        try {
            DB::beginTransaction();
            $filename = $authUser->image; // Set default to current image in case no new image is uploaded
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($authUser->image && Storage::disk('public')->exists('company/image/' . $authUser->image)) {
                    Storage::disk('public')->delete('company/image/' . $authUser->image);
                }
                // Store the new image
                $image = $request->file('image');
                $date = now()->toDateString();
                $randomSlug = Str::slug(Str::random(8)); // Create a random slug
                $randomNumber = rand(100, 999);
                $filename = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $image->getClientOriginalExtension();
                $image->storeAs('company/image', $filename, 'public');
            }

            // Update or create the company profile
            Company::updateOrCreate(['id' => $authUser->id], [
                'name' => Str::ucfirst($request['name']),
                'image' => $filename,
                'email' => $request['email'],
                'facebook_url' => $request['facebook_url'],
                'twitter_url' => $request['twitter_url'],
                'instagram_url' => $request['instagram_url'],
                'linkedin_url' => $request['linkedin_url'],
                'phone' => $request['mobile'],
            ]);

            DB::commit();
            session()->flash('success', 'Profile Updated Successfully');
            return redirect()->route('company.profile.index');
        } catch (Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Something went wrong. Please try again.']);
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
