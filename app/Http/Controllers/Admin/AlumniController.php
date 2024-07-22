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

    public function alumniList(Request $request)
    {

        if ($request->ajax()){
            return $this->alumniService->getAlumni($request);
        }

        // Extract unique graduation years and majors
        $graduationYears = Alumni::pluck('graduation_year')->unique()->sort()->values();
        $majors = Alumni::pluck('major')->unique()->sort()->values();

        $data = [
            'title' => __('Alumni List'),
            'showAdminAlumni' => 'show',
            'activeAlumniApprovedList' => 'active-color-one',
            'graduationYears' => $graduationYears,
            'majors' => $majors,
        ];
        return view('admin.alumni.list', $data);
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
        return view('admin.alumni.alumni-pending-list-with-search', $data);
    }

    public function gallery(Request $request,Alumni $alumni)
    {
      return view('admin.alumni.gallery', compact('alumni'));
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
