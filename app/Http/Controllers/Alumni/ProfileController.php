<?php

namespace App\Http\Controllers\Alumni;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Alumni;
use App\Models\CV;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Http\Requests\ProfileRequest;


class ProfileController extends Controller
{
    use ResponseTrait;

    public $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function profile()
    {
        $data['activeProfile'] = 'active';
        $data['user'] = $this->userService->userData();
        return view('alumni.profile',$data);
    }

    public function userProfileUpdate(ProfileRequest $request){
        return $this->userService->profileUpdate($request);
    }

    public function addInstitution(Request $request){

        return $this->userService->addInstitution($request);
    }

    public function changePasswordUpdate(Request $request)
    {
       return $this->userService->changePasswordUpdate($request);
    }

    public function security(){
        $user = User::where('id',auth()->user()->id)->first();
        $google2fa = new Google2FA();
        $data['qr_code']= $google2fa->getQRCodeInline(
            getOption('app_name'),
            $user->email,
            $user->google2fa_secret
        );
        return view('profile.security',$data);
    }

    public function smsSend(Request $request){
        return $this->userService->smsSend($request);
    }
    public function smsReSend(){
        return $this->userService->smsReSend();
    }
    public function smsVerify(Request $request){
        $request->validate([
            'opt-field.*' => 'required|numeric|',
        ]);
        return $this->userService->smsVerify($request);
    }

    public function list_cvs(Request $request){
        if ($request->ajax()) {
            $cvs = CV::where('alumni_id',auth('alumni')->id())->orderBy('id','desc')->get();

            return datatables($cvs)
                ->addIndexColumn()
                ->addColumn('name',function ($data){
                    return $data->name;
                })
                ->addColumn('action', function ($data) {

                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="'.route('alumni.cvs.view',$data->slug).'">
                                        <img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="edit" />
                                    </a>
                                </li>
                            </ul>';


                })
                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'salary', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('alumni.jobs.all-job-post', $data);
    }

    public function create_cv()
    {
        return view('alumni.cvs.create');
    }


    public function store_cv(Request $request)
    {
        $uniqueId = uniqid();
        $cv = new CV();
        $cv->name = $request->name;
        $cv->slug = $request->name . '_' . $uniqueId;
        $cv->alumni_id = auth('alumni')->id();
        $cv->first_name = $request->fname;
        $cv->last_name = $request->lname;
        $cv->email = $request->email;
        $cv->phone = $request->phone;
        $cv->address = $request->address;
        $workExperiences = []; // Initialize an empty array to store work experiences
// Loop through the work experience fields and save the data
        for ($i = 1; $i <= $request->experienceCount; $i++) {
            $workExperience = [
                'company' => $request->input('work_experience_name'.$i),
                'position' => $request->input('work_experience_position'.$i),
                'start_date' => $request->input('work_experience_start_date'.$i),
                'end_date' => $request->input('work_experience_end_date'.$i),
                'details' => $request->input('work_experience_details'.$i),
            ];

            $workExperiences[] = $workExperience; // Add the work experience to the array
        }

// Create the JSON object
        $workExperienceData = [
            'work_experiences' => $workExperiences,
        ];

// Convert the JSON object to a string
        $workExperienceDataJson = json_encode($workExperienceData);

// Save high school data
        $highSchool = [
            'name' => $request->highschool_name,
            'start_date' => $request->highschool_start_date,
            'end_date' => $request->highschool_end_date,
            'details' => $request->highschool_details,
        ];

// Save university data
        $university = [
            'name' => $request->university_name,
            'start_date' => $request->university_start_date,
            'end_date' => $request->university_end_date,
            'details' => $request->university_details,
        ];

// Save other education data
        $otherEducation = [
            'name' => $request->other_education_name,
            'start_date' => $request->other_education_start_date,
            'end_date' => $request->other_education_end_date,
            'details' => $request->other_education_details,
        ];

// Create the JSON object
        $educationData = [
            'high_school' => $highSchool,
            'university' => $university,
            'other_education' => $otherEducation,
        ];

// Convert the JSON object to a string
        $educationDataJson = json_encode($educationData);

// Save the education data in the CV object
        $cv->education = $educationDataJson;

// Save the work experience data in the CV object
        $cv->experience = $workExperienceDataJson;


        $cv->skills=$request->skills;
        $cv->additional_info=$request->additional;
        $cv->status=0;

        $cv->save();


        $mpdf_view = View::make('alumni.cvs.cv');
        $file_name = $request->name.'_'.$uniqueId;
        gen_mpdf($mpdf_view, $file_name);



    }

    public function view($slug)
    {
        $cv = CV::where('alumni_id', auth('alumni')->id())
            ->where('slug', $slug)
            ->first();

        $name = url('storage/cv/' . $cv->slug . '.pdf');
        $headers = [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $name . '"',
        ];

        // Return the response with the file
        return response()->file(public_path('storage/cv/' . $cv->slug . '.pdf'), $headers);
    }



}
