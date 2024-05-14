<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Company;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    use ResponseTrait;
    public $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {

        $data['pageTitle'] = __('Dashboard');
        $data['activeDashboard'] = 'active';
        $dashboardService = new DashboardService();

        $d = array();

        $data['dayList'] = json_encode(array_reverse($d));

        return view('company.dashboard', $data);
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
            ->rawColumns(['action'])
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
