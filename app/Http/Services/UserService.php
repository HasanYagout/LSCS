<?php

namespace App\Http\Services;

use App\Http\Services\SmsMail\TwilioService;
use App\Models\Alumni;
use App\Models\CV;
use App\Models\FileManager;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserService
{
    use ResponseTrait;

    public function userDetails($id)
    {
        return User::find($id);
    }









    public function profileUpdate($request)
    {

        $authUser =Auth::user();

        try {
            DB::beginTransaction();
            $filename = $authUser->alumni->image; // Set default to current image in case no new image is uploaded

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $date = now()->toDateString();
                $randomSlug = Str::slug(Str::random(8)); // Create a random slug
                $randomNumber = rand(100, 999);
                $filename = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $image->getClientOriginalExtension();
                $image->storeAs('alumni/image', $filename, 'public');
            }
            $skillsData = $request->has('skills') && is_array($request->skills) ? json_encode($request->skills) : null;



            foreach($request->education['id'] ?? [] as $index => $id){

                $authUser->alumni->education()->where('id', $id)->update([
                    'type' => $request->education['type'][$index],
                    'name' => $request->education['name'][$index],
                    'title' => $request->education['title'][$index],
                    'start_date' => $request->education['start_date'][$index],
                    'end_date' => $request->education['end_date'][$index],
                ]);
            }
            $authUser->alumni->education()->whereNotIn('id', $request->education['id'] ?? [])->delete();



            foreach($request->experience['id'] ?? [] as $index => $id){

                $authUser->alumni->experience()->where('id', $id)->update([
                    'name' => $request->experience['name'][$index],
                    'position' => $request->experience['position'][$index],
                    'start_date' => $request->experience['start_date'][$index],
                    'end_date' => $request->experience['end_date'][$index],
                    'details' => $request->experience['details'][$index],
                ]);
            }

            $authUser->alumni->experience()->whereNotIn('id', $request->experience['id'] ?? [])->delete();


            Alumni::updateOrCreate(['id' => $authUser->alumni->id],[
                'first_name'=> $request['first_name']?? $authUser->alumni->first_name,
                'last_name'=> $request['last_name']?? $authUser->alumni->last_name,
                'about_me' => $request['about_me']?? $authUser->alumni->about_me,
                'image' => $filename,
                'email' => $request['email'],
                'phone' => $request['mobile'],
                'linedin_url' => $request['linkedin_url'],
                'linkedin_url' => $request['linkedin_url']?? $authUser->alumni->linkedin_url,
                'facebook_url' => $request['facebook_url']?? $authUser->alumni->facebook_url,
                'twitter_url' => $request['twitter_url']?? $authUser->alumni->twitter_url,
                'instagram_url' => $request['instagram_url']?? $authUser->alumni->instagram_url,
                'Company' => $request['Company'] ?? $authUser->alumni->Company,
                'company_designation' => $request['company_designation'] ?? '',
                'company_address' => $request['company_address'] ?? '',
                'city' => $request['city']?? $authUser->alumni->city,
                'address' => $request['address']?? $authUser->alumni->address,
                'skills' => $skillsData,

            ]);



            DB::commit();
            session()->flash('success', 'Profile Updated Successfully');
            return redirect()->route('alumni.profile.index');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();

            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function addExperience(Request $request)
    {
        $authUser = Auth::user();

        // Check if the user already has three education records

        if ($authUser->alumni->experience()->count() >= 3) {
            session()->flash('error', 'You have reached the maximum limit for experience records.');
            return redirect()->route('alumni.profile.index');
        }
        $data = $request->validate([
            "name" =>  'bail|required|max:195',
            "position" =>  'bail|required|max:195',
            "description" =>  'bail|required|max:1000',
            "end_date" =>  'required',
            "start_date" =>  'required',
        ]);
        try {
            DB::beginTransaction();

            $authUser->alumni->experience()->create([
                'alumni_id'=>$authUser->user_id,
                'name' => $data['name'],
                'position' => $data['position'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'details' => $data['description'],
            ]);



            DB::commit();
            session()->flash('success', 'Experience Added Successfully');
            return redirect()->route('alumni.profile.index');
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            session()->flash('error', $e);
            return redirect()->route('alumni.profile.index');
        }
    }

    public function addCV(Request $request)
    {

        $data = $request->validate([
            'cv.*' => 'required|mimes:pdf|max:2048', // Validate each file as PDF
        ]);

        try {
            DB::beginTransaction();
            $user=Auth::user();
            if ($request->hasFile('cv')) {
                foreach ($request->file('cv') as $cv) {
                    $date = date('Ymd'); // Current date
                    $randomNumber = rand(1000, 9999); // Random number
                    $originalName = pathinfo($cv->getClientOriginalName(), PATHINFO_FILENAME);
                    $slug = Str::slug($originalName); // Slugified file name
                    $extension = $cv->getClientOriginalExtension(); // File extension
                    $fileName = "{$date}_{$randomNumber}_{$slug}.{$extension}"; // Combine them
                    $cv->move(storage_path('app/public/alumni/cv'), $fileName);

                    CV::create([
                        'alumni_id' => $user->id,
                        'name' => $fileName,
                        'slug' => Str::slug($slug),
                    ]);
                }
            }


            DB::commit();

            // Flash success message and redirect
            return redirect()->route('alumni.profile.index')
            ->with('success', getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            dd($e);
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function addEducation(Request $request)
    {
        $authUser = Auth::user();
        // Check if the user already has three education records

        if ($authUser->alumni->education()->count() >= 3) {
            session()->flash('error', 'You have reached the maximum limit for education records.');
            return redirect()->route('alumni.profile.index');
        }
        $data = $request->validate([
            "education_type" =>  'bail|required|max:195',
            "education_name" =>  'bail|required|max:195',
            "education_title" =>  'bail|required|max:1000',
            "education_start_date" =>  'required',
            "education_end_date" =>  'required',
        ]);
        try {
            DB::beginTransaction();

            $authUser->alumni->education()->create([
                'alumni_id'=>$authUser->user_id,
                'type' => $data['education_type'],
                'name' => $data['education_name'],
                'title' => $data['education_title'],
                'start_date' => $data['education_start_date'],
                'end_date' => $data['education_end_date'],
            ]);



            DB::commit();
            session()->flash('success', 'Education Added Successfully');
            return redirect()->route('alumni.profile.index');
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

            return redirect()->route('alumni.auth.login')->with('success', 'Password updated successfully. Please log in with your new password.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('active_tab', 'editProfile-tab');
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }


}
