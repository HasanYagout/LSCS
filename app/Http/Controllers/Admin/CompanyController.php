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
            return $this->companyService->all($request);
        }
        $data['title'] = __('All Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeAllCompanyList'] = 'active-color-one';
        return view('admin.company.all', $data);
    }
    public function active(Request $request)
    {

        if ($request->ajax()) {
        return $this->companyService->active($request);
        }
        $data['title'] = __('Active Companies');
        $data['showCompanyManagement'] = 'show';
        $data['activeCompanyActiveList'] = 'active-color-one';
        return view('admin.company.active', $data);
    }

    public function pending(Request $request)
    {
        if ($request->ajax()) {
          return $this->companyService->pending($request);
        }
        $data['title'] = __('Pending Companies');
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
