<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        return view('alumni.recommendation.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $recomendations = Recommendation::with('alumni','admin')->where('alumni_id',auth('alumni')->id())->get();

            return datatables($recomendations)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return  $data->admin->first_name.' '.$data->admin->last_name;
                })
                ->addColumn('status', function ($data) {
                    $status = $data->status;
                    $color = '';

                    switch ($status) {
                        case '1':
                            $color = 'background-color: green; color: white;';
                            break;
                        case 'Pending':
                            $color = 'background-color: yellow; color: black;';
                            break;
                        case '0':
                            $color = 'background-color: red; color: white;';
                            break;
                        default:
                            $color = 'background-color: gray; color: white;';
                            break;
                    }

                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li style="'.$color.'" class="d-flex gap-2"></li>

                            </ul>';
                })
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

    }

    public function create(Request $request){
        $data['title'] = __('Create Recommendation');
        $data['admins']=Admin::where('role_id',4)->get();
        return view('alumni.recommendation.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'instructor' => 'required|exists:admins,id', // assuming instructors are users
            'details' => 'required|string|max:2000',
        ]);

        Recommendation::create(['alumni_id'=>auth('alumni')->id(),
            'admin_id'=>$request->instructor,'status'=>0]);
        return back()->with('success', 'Recommendation request submitted successfully.');

    }
}
