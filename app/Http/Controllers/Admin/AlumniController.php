<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\UserService;
use App\Models\Alumni;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PassingYear;
use App\Traits\ResponseTrait;

class AlumniController extends Controller
{
    use ResponseTrait;

    public $alumniService;
    public $userService;

    public function __construct()
    {
        $this->alumniService = new AlumniService();
        $this->userService = new UserService();
    }

    public function view($id)
    {
        $data['user'] = $this->userService->userData($id);
        return view('admin.public-profile', $data);
    }

    public function alumniListWithAdvanceFilter(Request $request)
    {

        if ($request->ajax()) {
            $alumniData=Alumni::all();
            return datatables($alumniData)
                ->addIndexColumn()
                ->addColumn('first_name', function ($data) {

                    return $data->first_name;
                })
                ->addColumn('last_name', function ($data) {

                    return $data->last_name;
                })
                ->addColumn('graduation_year', function ($data) {
                    return $data->graduation_year;
                })
                ->addColumn('major', function ($data) {
                    return $data->major;
                })
//                ->addColumn('address', function ($data) {
//                    $location = "";
//                    return htmlspecialchars($location);
//                })
//                ->addColumn('change_status', function ($data) {
//                    $vassign =  '<select class="form-control form-select" name="change_status" data-id='.$data->id.' id="change_status"  required class="form-control" >';
//                    foreach(getAlumniGeneralStatus() as $key=>$value){
//                        $vassign .= '<option ';
//                        if($data->status==$key){
//                            $vassign .= ' selected ';
//                        }
//                        $vassign .= 'value="'.$key.'">'.$value.'</option>';
//                    }
//                    $vassign .='</select>';
//                    return $vassign;
//                })
                ->addColumn('action', function ($data) {
                   return '<button onclick="getEditModal(\'' . route('admin.alumni.gallery', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Upload').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="upload" />
                                    </button>';

                })
                ->rawColumns(['first_name','second_name', 'batch',  'passing_year', 'address','change_status', 'action'])
                ->make(true);
        }

        $data['title'] = __('Alumni List');
        $data['showAdminAlumni'] = 'show';
        $data['activeAlumniApprovedList'] = 'active-color-one';
        $data['department'] = Department::all();
        $data['passingYear'] = PassingYear::all();

        return view('admin.manage_alumni.alumni-list-with-search', $data);
    }

    public function alumniPendingListWithAdvanceFilter(Request $request)
    {
        if ($request->ajax()) {
            return $this->alumniService->getAlumniPendingListWithAdvanceFilter($request);
        }
        $data['title'] = __('Alumni Pending List');
        $data['showAdminAlumni'] = 'show';
        $data['activeAlumniPendingList'] = 'active-color-one';
        $data['department'] = Department::all();
        $data['passingYear'] = PassingYear::all();
        return view('admin.manage_alumni.alumni-pending-list-with-search', $data);
    }

    public function gallery(Request $request,Alumni $alumni)
    {
      return view('admin.manage_alumni.gallery', compact('alumni'));
    }

    public function alumniChangeStatus(Request $request)
    {
        return $this->alumniService->changeAlumniStatus($request);
    }

    public function gallery_store(Request $request)
    {
        // Store the uploaded file

        // Store the uploaded files
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . str_replace(' ', '_', $image->getClientOriginalName());
                $path = $image->storeAs('graduation_images', $imageName, 'public');
                $imagePaths[] = $imageName;
            }
        }


        $alumni = Alumni::findOrFail($request->alumni_id);

        $alumni->graduation_images = json_encode($imagePaths);
        $alumni->save();
    }
}
