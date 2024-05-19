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
        $uniqueId=uniqid();
        $cv= new CV();
        $cv->name=$request->name;
        $cv->slug=$request->name.'_'.$uniqueId;
        $cv->alumni_id=auth('alumni')->id();
        $cv->first_name=$request->fname;
        $cv->last_name=$request->lname;
        $cv->email=$request->email;
        $cv->phone=$request->phone;
        $cv->address=$request->address;
        $cv->education=$request->education;
        $cv->experience=$request->experience;
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
