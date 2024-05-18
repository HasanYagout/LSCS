<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Department;
use App\Models\Student;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;


class StudentController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $data['title'] = __('Students List');
        $data['showManageStudents'] = 'show';
        $data['activeAlumniApprovedList'] = 'active-color-one';
        $data['department'] = Department::all();
//        $data['passingYear'] = PassingYear::all();

        return view('admin.students.all', $data);
    }

    public function info($id)
    {


        $data['student'] = Student::where('student_id', $id)->firstOrFail();
        return view('admin.students.info', $data);
    }

    public function update(Request $request)
    {
        $student=Student::where('student_id',$request->buttonValue)->first();
        $alumni= new Alumni();
        $alumni->student_id=$student->student_id;
        $alumni->first_name=$student->first_name;
        $alumni->last_name=$student->last_name;
        $alumni->phone=$student->number;
        $alumni->gpa=$student->gpa;
        $alumni->major=$student->major;
        $alumni->password=Hash::make($student->student_id);
        $alumni->save();
        return $this->success([],__('Alumni added successfully'));

    }

    public function list()
    {
        $students = Student::with('major')->orderBy('id','DESC');
        return datatables($students)
            ->addIndexColumn()
            ->addColumn('major', function ($data) {
                return $data->major->name; // Access the name property of the associated major
            })
            ->addColumn('action', function ($data) {

                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button class="editStudent" value="' . $data->student_id . '">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
