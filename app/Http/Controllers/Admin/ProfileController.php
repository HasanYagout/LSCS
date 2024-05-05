<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProfileRequest;
use App\Models\FileManager;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class   ProfileController extends Controller
{
    public function myProfile()
    {

        $data['pageTitle'] = 'Profile';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavProfileActiveClass'] = 'mm-active';
        return view('admin.profile.index', $data);
    }

    public function changePassword()
    {
        $data['pageTitle'] = 'Change Password';
        $data['navAccountSettingActiveClass'] = 'mm-active';
        $data['subNavChangePasswordActiveClass'] = 'mm-active';
        return view('admin.profile.change-password', $data);
    }

    public function changePasswordUpdate(Request $request)
    {
        $request->validate([
            'password' => 'required|confirmed|min:6'
        ]);
        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();
        return redirect()->back()->with('success', 'Updated Successfully');
    }

    public function update(ProfileRequest $request)
    {
        $user = User::find(Auth::user()->id);
        /*File Manager Call upload*/
        if ($request->profile_image) {
            $new_file = FileManager::where('id', $user->image)->first();
            if ($new_file) {
                $new_file->removeFile();
                $upload = $new_file->upload('User', $request->profile_image, '', $new_file->id);
                $user->image = $upload->id;
            } else {
                $new_file = new FileManager();
                $upload = $new_file->upload('User', $request->profile_image);
                $user->image = $upload->id;
            }
        }
        /*End*/
        $user->name = $request->name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->address = $request->address;
        $user->save();
        return redirect()->back()->with('success', 'Profile has been updated');
    }
}
