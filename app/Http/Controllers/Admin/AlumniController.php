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
        $alumniData = Alumni::query();

        // Filter by selected year
        if ($request->selectedYear && $request->selectedYear != 0) {
            $alumniData = $alumniData->where('graduation_year', $request->selectedYear);
        }

        // Filter by selected major
        if ($request->selectedMajor && $request->selectedMajor != 0) {
            $alumniData = $alumniData->where('major', $request->selectedMajor);
        }

        // Extract unique graduation years and majors
        $graduationYears = Alumni::pluck('graduation_year')->unique()->sort()->values();
        $majors = Alumni::pluck('major')->unique()->sort()->values();

        if ($request->ajax()) {
            return datatables($alumniData)
                ->addIndexColumn()
                ->addColumn('student_id', function ($data) {
                    return $data->student_id;
                })
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
//                ->addColumn('recommendation', function ($data) {
//                    return '<button onclick="getEditModal(\'' . route('admin.alumni.gallery', $data->id) . '\', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Upload') . '">
//                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="upload" />
//                        </button>';
//                })
                ->rawColumns(['first_name', 'last_name', 'graduation_year', 'major', 'recommendation','status'])
                ->make(true);
        }

        $data = [
            'title' => __('Alumni List'),
            'showAdminAlumni' => 'show',
            'activeAlumniApprovedList' => 'active-color-one',
            'graduationYears' => $graduationYears,
            'majors' => $majors,
        ];
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
