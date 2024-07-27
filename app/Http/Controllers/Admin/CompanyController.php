<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\CompanyService;
use App\Http\Services\UserService;
use App\Models\Company;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

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
    public function showProposal($filename)
    {
        $path = 'public/storage/company/proposal' .'/'. $filename;

//        if (!Storage::exists($path)) {
//            abort(404);
//        }
        $file = Storage::get($path);
        dd($file,$path);
        $type = Storage::mimeType($path);

        return response($file, 200)
            ->header('Content-Type', $type)
            ->header('Content-Disposition', 'inline; filename="' . $filename . '"');
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


    public function details(Request $request, $slug)
    {
         $company=Company::with(['jobs' => function($query) {
            $query->whereIn('posted_by', ['admin', 'company']);
        }])->where('slug', $slug)->firstOrFail();
        $data['company'] =$company;
        $data['userInfo']=User::where('role_id',3)->where('id',$company->user_id)->firstOrFail();
        $data['title'] = __('Company Details');
        $data['showCompanyManagement'] = 'show';
        return view('admin.company.details', $data);
    }
}
