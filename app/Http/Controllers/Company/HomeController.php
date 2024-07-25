<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Company;
use App\Models\JobPost;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

    use ResponseTrait;
    public $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        $user = Auth::user();

        $data['pageTitle'] = __('Timeline');
        $data['activeHome'] = 'active';
        $data['upcomingEvents'] = $this->dashboardService->getUpcomingEvent()->getData()->data;
        $data['latestJobs'] = $this->dashboardService->getLatestJobs()->getData()->data;
        $data['latestNews'] = $this->dashboardService->getLatestNews()->getData()->data;
        $data['latestNotice'] = $this->dashboardService->getLatestNotice()->getData()->data;
        $data['posts']=$this->dashboardService->getPosts();
        $data['userInfo']=$user->company;

        return view('company.home', $data);
    }

    public function status(Request $request)
    {
        $company=Company::findOrFail($request->data_id);
        $company->update(['status'=>$request->checked?1:0]);

    }

    public function all(Request $request)
    {
        $companies = Company::orderBy('id','DESC');

        return datatables($companies)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
            <li class="d-flex gap-2">
                <button onclick="openPdfViewer('. "'$data->proposal'" .')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Edit').'">
                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                </button>
            </li>
        </ul>';
            })
            ->addColumn('status', function ($data) {
                $checked = $data->status ? 'checked' : '';
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
            <li class="d-flex gap-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" data-id="'.$data->id.'" '.$checked.'>
                    <label class="form-check-label" for="flexSwitchCheckChecked"></label>
                </div>
            </li>
        </ul>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function view($id)
    {
        $company=Company::findOrFail($id);
        $proposal=$company->proposal;

    }

    public function info($id)
    {
        $data['company']= Company::findOrFail($id);
        return view('company.edit-form', $data);
    }

}
