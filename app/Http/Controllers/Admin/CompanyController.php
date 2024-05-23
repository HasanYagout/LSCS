<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\UserService;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PassingYear;
use App\Traits\ResponseTrait;

class CompanyController extends Controller
{
    use ResponseTrait;

    public $alumniService;
    public $userService;

    public function __construct()
    {
        $this->alumniService = new AlumniService();
        $this->userService = new UserService();
    }

    public function all(Request $request)
    {

        if ($request->ajax()) {
            $companies = Company::orderBy('id','desc')->get();


            return datatables($companies)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->name;
                })
                ->addColumn('email',function($data){
                    return $data->email;
                })
                ->addColumn('phone',function($data){
                    return $data->phone;
                })
                ->addColumn('status', function ($data) {

                    return $data->status;
                })
//                ->addColumn('logo', function ($data) {
//                    return '<img src="' . $data->company->logo . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
//                })
//            ->addColumn('title', function ($data) {
//                return htmlspecialchars($data->title);
//            })
//            ->addColumn('employee_status', function ($data) {
//                return $this->getEmployeeStatusById($data->employee_status);
//            })
//            ->addColumn('salary', function ($data) {
//                return htmlspecialchars($data->salary);
//            })
//            ->addColumn('application_deadline', function ($data) {
//               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
//            })
//
//                ->addColumn('action', function ($data) {
//                    if(auth('admin')->user()->role_id == USER_ROLE_COMPANY){
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                                <li class="d-flex gap-2">
//                                    <button onclick="getEditModal(\'' . route('admin.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
//                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
//                                    </button>
//                                    <button onclick="deleteItem(\'' . route('admin.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
//                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
//                                    </button>
//                                    <a href="' . route('admin.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
//                                </li>
//                            </ul>';
//                    }else{
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                    <li class="d-flex gap-2">
//                        <a href="' . route('company.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
//                    </li>
//                </ul>';
//                    }
//
//                })

                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'salary', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('admin.company.all', $data);
    }

    public function update(Request $request ,Company $company)
    {
        $company->update(['status' => $request->status]);
    }
}
