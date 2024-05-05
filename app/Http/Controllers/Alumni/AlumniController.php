<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\AlumniService;
use App\Http\Services\UserService;
use App\Models\Batch;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Models\PassingYear;
use App\Models\User;
use App\Models\UserMembershipPlan;
use App\Traits\ResponseTrait;
class AlumniController extends Controller
{
    use ResponseTrait;
    public $alumniService ;
    public $userService ;
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
            return $this->alumniService->getAlumniListWithAdvanceFilter($request);
        }
        $data['title'] = __('Alumni List');
        $data['activeAlumniList'] = 'active';
        $data['department'] = Department::all();
        $data['passingYear'] = PassingYear::all();
        return view('alumni.manage_alumni.alumni-list-with-search', $data);
    }
}
