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
                $q->where('id', 'like', "%{$search}%")
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
                if (in_array($orderBy, ['id', 'first_name', 'middle_name', 'last_name', 'gpa', 'major', 'credits_left'])) {
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
            $studentsQuery->orderBy('id', 'desc');
        }

        // Get the student IDs to find active alumni
        $students = $studentsQuery->get();
        $studentIds = $students->pluck('id');
        $activeAlumni = Alumni::whereIn('id', $studentIds)
            ->whereNull('deleted_at')
            ->pluck('id')
            ->all();

        // Return datatables response
        return datatables($studentsQuery)
            ->addIndexColumn()
            ->addColumn('major', function ($student) {
                return $student->major ? $student->major->name : '';
            })
            ->addColumn('id', function ($student) {
                return $student->id;
            })
            ->addColumn('action', function ($student) use ($activeAlumni) {
                $checked = in_array($student->id, $activeAlumni) ? 'checked' : '';
                return '<div class="form-check form-switch">
                <input class="form-check-input toggle-status" type="checkbox" data-id="' . $student->id . '" id="toggleStatus' . $student->id . '" ' . $checked . '>
                <label class="form-check-label" for="toggleStatus' . $student->id . '"></label>
            </div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }




}
