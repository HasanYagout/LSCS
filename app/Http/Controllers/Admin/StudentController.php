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
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {
        // Fetch students with their associated majors
        $students = Student::with('major')->orderBy('id', 'DESC');
        if ($request->ajax()) {

            return datatables($students)
                ->addIndexColumn()

                ->addColumn('major', function ($data) {
                    return $data->major ? $data->major->name : ''; // Ensure it handles null major
                })
                ->addColumn('credits_left', function ($data) {
                    return $data->credits_left; // Assuming credits_left is a property of the Student model
                })
                ->addColumn('action', function ($data) {
                    $checked = $data->is_alumni ? 'checked' : '';
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->student_id . '" id="toggleStatus' . $data->student_id . '" ' . $checked . '>
                            <label class="form-check-label" for="toggleStatus' . $data->student_id . '"></label>
                        </div>
                    </li>
                </ul>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data['title'] = __('Students List');
        $data['showManageStudents'] = 'show';
        $data['activeAlumniApprovedList'] = 'active-color-one';
        $students = Student::with('major')->orderBy('id', 'DESC')->get(); // Fetch the students
        $data['majors'] = $students->pluck('major.name', 'major_id')->unique()->sort()->values();
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
        $student->update(['is_alumni'=>$request->status]);
        if ($student) {
            if ($request->status){
                // Add the student to the alumni table
                $alumni = new Alumni();
                $alumni->student_id = $student->student_id;
                $alumni->first_name = $student->first_name;
                $alumni->last_name = $student->last_name;
                $alumni->phone = $student->number;
                $alumni->gpa = $student->gpa;
                $alumni->major = $student->major->name;
                $alumni->graduation_year = Carbon::now()->format('o');
                $alumni->password = Hash::make($student->student_id);
                $alumni->status = 1;
                $alumni->save();
            }
            else{
               Alumni::where('student_id', $student->student_id)->delete();
            }

        return response()->json(['success' => true, 'message' => __('Alumni added successfully')]);
        }

        return response()->json(['success' => false, 'message' => __('Student not found')]);
    }


}
