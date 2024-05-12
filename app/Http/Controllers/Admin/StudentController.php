<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\Department;
use App\Models\Student;
use Illuminate\Http\Request;


class StudentController extends Controller
{
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
        Alumni::create([
            'name' => $request->name,
        ]);
    }

    public function list()
    {
        $students = Student::orderBy('id','DESC');

        return datatables($students)
            ->addIndexColumn()
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
