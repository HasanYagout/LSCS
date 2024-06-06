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
            $companies = Company::where('status',STATUS_ACTIVE)
                ->orWhere('status',STATUS_ACTIVE)
                ->orderBy('id','desc')
                ->get();

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
                    $checked = $data->status ? 'checked' : '';
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->id . '" id="toggleStatus' . $data->id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->id . '"></label>
                    </div>
                </li>
            </ul>';
                })

                ->addColumn('action', function ($data) {
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="' . route('admin.company.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';

                })
                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'status', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('admin.company.all', $data);
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
            $companies = Company::where('status',STATUS_INACTIVE)->orderBy('id','desc')->get();
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
                    $checked = $data->status ? 'checked' : '';
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->id . '" id="toggleStatus' . $data->id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->id . '"></label>
                    </div>
                </li>
            </ul>';
                })

                ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="' . route('admin.company.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';

                })
                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'status', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('admin.company.pending', $data);
    }
    public function update(Request $request, $id)
    {
        $company = Company::with('jobs')->find($id);
        if ($company) {
            $company->status = $request->status;
            $company->jobs->status=$request->status;
            $company->save();

            return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
        }

        return response()->json(['success' => false, 'message' => 'Company not found.']);
    }

    public function details(Request $request,$slug)
    {
      $data['company']=Company::with('appliedJobs','jobs')->where('slug',$slug)->firstOrFail();
      $data['title'] = __('Company Details');
      $data['showCompanyManagement'] = 'show';
      return view('admin.company.details',$data);
    }
}
