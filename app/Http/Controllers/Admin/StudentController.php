<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $studentsQuery = Student::with('major')->where('credits_left','==',0)->orderBy('student_id', 'DESC');

            // Handle searching
            if ($request->has('search') && $request->search['value'] != '') {
                $searchValue = $request->search['value'];
                $studentsQuery->where('student_id', 'LIKE', "%{$searchValue}%")
                    ->orWhere('first_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchValue}%");
            }

            $students = $studentsQuery->get();
            $studentIds = $students->pluck('student_id');
            $activeAlumni = Alumni::whereIn('student_id', $studentIds)->whereNull('deleted_at')->pluck('student_id')->all();

            return DataTables::of($students)
                ->addIndexColumn()
                ->addColumn('major', function ($student) {
                    return $student->major ? $student->major->name : '';
                })
                ->addColumn('action', function ($student) use ($activeAlumni) {
                    $checked = in_array($student->student_id, $activeAlumni) ? 'checked' : '';
                    return '<div class="form-check form-switch">
                    <input class="form-check-input toggle-status" type="checkbox" data-id="' . $student->student_id . '" id="toggleStatus' . $student->student_id . '" ' . $checked . '>
                    <label class="form-check-label" for="toggleStatus' . $student->student_id . '"></label>
                </div>';
                })
                ->rawColumns(['action'])
                ->make(true);
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
