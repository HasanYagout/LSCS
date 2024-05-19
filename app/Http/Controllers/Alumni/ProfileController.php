<?php

namespace App\Http\Controllers\Alumni;

use App\CPU\Helpers;
use App\Http\Controllers\Controller;
use App\Http\Services\UserService;
use App\Models\Alumni;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
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
            $cvs = Alumni::where('id',auth('alumni')->id())->select('cvs')->orderBy('id','desc')->get();

            return datatables($cvs)
                ->addIndexColumn()

                ->addColumn('action', function ($data) {
                    if(auth('alumni')->user()->role_id == USER_ROLE_ALUMNI){
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                                <li class="d-flex gap-2">
//                                    <button onclick="getEditModal(\'' . route('admin.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
//                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
//                                    </button>
//                                    <button onclick="deleteItem(\'' . route('admin.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
//                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
//                                    </button>
//                                    <a href="' . route('alumni.cvs.details') . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
//                                </li>
                            </ul>';
                    }
                    else{
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <a href="' . route('alumni.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                    </li>
                </ul>';
                    }

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
        $alumni = Alumni::where('id', auth('alumni')->id())->first();
        $mpdf_view = View::make('alumni.cvs.cv');
        $file_prefix = 'order_invoice_';
        $file_postfix = 'sadsad';
        gen_mpdf($mpdf_view, $file_prefix, $file_postfix);
    }



}
