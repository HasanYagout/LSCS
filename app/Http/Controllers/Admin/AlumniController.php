<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\UserService;
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
        return view('alumni.public-profile', $data);
    }

    public function alumniListWithAdvanceFilter(Request $request)
    {
        if ($request->ajax()) {
            return $this->alumniService->getAlumniListAllWithAdvanceFilter($request);
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

    public function alumniChangeStatus(Request $request)
    {
        return $this->alumniService->changeAlumniStatus($request);
    }
}
