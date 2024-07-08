<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\StudentService;
use App\Models\Alumni;
use App\Models\Department;
use App\Models\Student;
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
        $data['student'] = Student::where('student_id', $id)->firstOrFail();
        return view('admin.students.info', $data);
    }

    public function update(Request $request)
    {

        $student = Student::with('major')->where('student_id', $request->student_id)->first();

        if (!$student) {
            return response()->json(['success' => false, 'message' => __('Student not found')]);
        }

        $student->update(['is_alumni' => $request->status]);

        // Check if there's an Alumni record, including soft-deleted ones
        $alumni = Alumni::withTrashed()->where('student_id', $student->student_id)->first();

        if ($request->status) {
            // If we're setting this student as an alumni
            if (!$alumni) {
                // No alumni record exists, create a new one
                $alumni = new Alumni();
            } else {
                // Alumni record exists (possibly soft-deleted), restore it if it was soft-deleted
                if ($alumni->trashed()) {
                    $alumni->restore();
                }
            }

            // Update or set the alumni details
            $alumni->student_id = $student->student_id;
            $alumni->first_name = $student->first_name;
            $alumni->last_name = $student->last_name;
            $alumni->phone = $student->number;
            $alumni->gpa = $student->gpa;
            $alumni->major = $student->major->name;
            $alumni->graduation_year = Carbon::now()->format('o');
            $alumni->password = Hash::make($student->student_id);  // Consider security implications
            $alumni->role_id = 2;  // Ensure role_id '2' is correct
            $alumni->email = $student->email;
            $alumni->status = 1;
            $alumni->save();

            return response()->json(['success' => true, 'message' => __('Alumni updated successfully')]);
        } else {
            // If we're removing this student from alumni
            if ($alumni) {
                $alumni->delete();  // Soft-delete the alumni record
            }
            return response()->json(['success' => true, 'message' => __('Alumni record removed')]);
        }
    }


}
