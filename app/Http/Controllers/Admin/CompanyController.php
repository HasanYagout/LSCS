<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\CompanyService;
use App\Http\Services\UserService;
use App\Models\Company;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PassingYear;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
{
    use ResponseTrait;

    public $companyService;


    public function __construct()
    {
        $this->companyService = new CompanyService();

    }

    public function all(Request $request)
    {

        if ($request->ajax()) {
            $companies = Company::where('status',STATUS_ACTIVE)
                ->orWhere('status',STATUS_INACTIVE)
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
        $data['activeAllCompanyList'] = 'active-color-one';
        return view('admin.company.all', $data);
    }
    public function active(Request $request)
    {

        if ($request->ajax()) {
            $companies = Company::where('status',STATUS_ACTIVE)
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
                    if ($data->status == 1) {
                        return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Active').'</span>';
                    } else {
                        return '<span class="zBadge-free">'.__('Deactivate').'</span>';
                    }
                })

                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'status', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeCompanyActiveList'] = 'active-color-one';
        return view('admin.company.active', $data);
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
        $data['activePendingCompanyList'] = 'active-color-one';
        return view('admin.company.pending', $data);
    }
    public function update(Request $request, $id)
    {
       return $this->companyService->updateStatus($request,$id);

    }


    public function details(Request $request,$slug)
    {
      $data['company']=Company::with('appliedJobs','jobs')->where('slug',$slug)->firstOrFail();
      $data['title'] = __('Company Details');
      $data['showCompanyManagement'] = 'show';
      return view('admin.company.details',$data);
    }
}
