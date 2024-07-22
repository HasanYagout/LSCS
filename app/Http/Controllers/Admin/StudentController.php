<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\StudentService;
use App\Models\Alumni;
use App\Models\AppliedJobs;
use App\Models\Department;
use App\Models\Student;
use App\Models\User;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;


class StudentController extends Controller
{
    use ResponseTrait;
    public $StudentService;

    public function __construct()
    {
        $this->StudentService = new StudentService();
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
          return $this->StudentService->list($request);
        }

        $data['title'] = __('Students List');
        return view('admin.students.all', $data);
    }


    public function info($id)
    {
        $data['student'] = Student::where('id', $id)->firstOrFail();
        return view('admin.students.info', $data);
    }

    public function update(Request $request)
    {
        $student = Student::with('major')->find($request->id);

        if (!$student) {
            return response()->json(['success' => false, 'message' => __('Student not found')]);
        }

        $student->update(['is_alumni' => $request->status]);

        // Check if there's an Alumni record
        $alumni = Alumni::where('id', $student->id)->first();
        $user = User::where('email', $student->id)->where('role_id', 2)->first();

        if ($request->status) {
            // If we're setting this student as an alumni
            if (!$alumni) {
                // No alumni record exists, create a new one
                $alumni = new Alumni();
            }

            // Update or set the alumni details
            $alumni->id = $student->id;
            $alumni->first_name = $student->first_name;
            $alumni->last_name = $student->last_name;
            $alumni->phone = $student->phone;
            $alumni->gpa = $student->gpa;
            $alumni->major = $student->major->name;
            $alumni->graduation_year = Carbon::now()->format('Y');
            $alumni->email = $student->email;
            $alumni->status = 1; // Active status
            $alumni->save();

            // Update or set the user details
            if (!$user) {
                $user = new User();
                $user->user_id = $student->id;
                $user->role_id = 2;
            }

            $user->email = $student->email;
            $user->password = Hash::make($student->id);
            $user->status = 1; // Active status
            $user->save();
            return response()->json(['success' => true, 'message' => __('Alumni updated successfully')]);
        } else {
            // If we're setting this student as inactive alumni
            if ($alumni) {
                $appliedJobs=AppliedJobs::where('alumni_id', $student->id)->get();
                foreach ($appliedJobs as $job){
                    $job->status=0;
                }
                $alumni->status = 0; // Inactive status
                $alumni->save();
            }
            if ($user) {
                $user->status = 0; // Inactive status
                $user->save();
            }

            return response()->json(['success' => true, 'message' => __('Alumni record deactivated')]);
        }
    }



}
