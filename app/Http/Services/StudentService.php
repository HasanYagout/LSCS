<?php

namespace App\Http\Services;



use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Student;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class StudentService
{
    use ResponseTrait;

    public function list($request)
    {
        // Query to get students with their major
        $studentsQuery = Student::with('major')
            ->where('credits_left', 0);

        // Handle search input
        if ($request->has('search') && isset($request->search['value']) && $request->search['value'] != '') {
            $search = $request->search['value'];
            $studentsQuery->where(function ($q) use ($search) {
                $q->where('student_id', 'like', "%{$search}%")
                    ->orWhere('first_name', 'like', "%{$search}%")
                    ->orWhere('middle_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%");
            });
        }

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                if (in_array($orderBy, ['student_id', 'first_name', 'middle_name', 'last_name', 'gpa', 'major', 'credits_left'])) {
                    // Handle ordering by related column (major)
                    if ($orderBy == 'major') {
                        $studentsQuery->leftJoin('majors', 'students.major_id', '=', 'majors.id')
                            ->orderBy('majors.name', $orderDirection);
                    } else {
                        $studentsQuery->orderBy($orderBy, $orderDirection);
                    }
                }
            }
        } else {
            $studentsQuery->orderBy('student_id', 'desc');
        }

        // Get the student IDs to find active alumni
        $students = $studentsQuery->get();
        $studentIds = $students->pluck('student_id');
        $activeAlumni = Alumni::whereIn('student_id', $studentIds)
            ->whereNull('deleted_at')
            ->pluck('student_id')
            ->all();

        // Return datatables response
        return datatables($studentsQuery)
            ->addIndexColumn()
            ->addColumn('major', function ($student) {
                return $student->major ? $student->major->name : '';
            })
            ->addColumn('student_id', function ($student) {
                return $student->student_id;
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




}
