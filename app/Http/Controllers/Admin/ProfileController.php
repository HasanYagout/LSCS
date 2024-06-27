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
use Illuminate\Support\Str;

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

    public function update(Request $request)
    {
        $authUser = auth('admin')->user();
        try {
            DB::beginTransaction();
            $filename = $authUser->image; // Set default to current image in case no new image is uploaded

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $date = now()->toDateString();
                $randomSlug = Str::slug(Str::random(8)); // Create a random slug
                $randomNumber = rand(100, 999);
                $filename = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $image->getClientOriginalExtension();
                $image->storeAs('admin/image', $filename, 'public');
            }


            Admin::updateOrCreate(['id' => $authUser->id],[
                'first_name'=>Str::ucfirst($request['f_name']),
                'last_name'=>Str::ucfirst($request['l_name']),
                'image' => $filename,
                'email' => $request['email'],
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
}
