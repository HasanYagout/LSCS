<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Admin;
use App\Models\Alumni;
use App\Models\Company;
use App\Models\Event;
use App\Models\JobPost;
use App\Models\Recommendation;
use App\Traits\General;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{

    use ResponseTrait;
    use General;
    public $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index(Request $request)
    {
        $data['pageTitle'] = __('Dashboard');
        $data['activeDashboard'] = 'active';
        $data['totalAlumni'] = Cache::remember('totalAlumni', 60, function () {
            return Alumni::count();
        });
        $data['totalCompany'] = Cache::remember('totalCompany', 60, function () {
            return Company::count();
        });
        $data['totalInstructors'] = Cache::remember('totalInstructors', 60, function () {
            return Admin::where('role_id', USER_ROLE_INSTRUCTOR)->count();
        });
        $data['totalAdmins'] = Cache::remember('totalAdmins', 60, function () {
            return Admin::where('role_id', USER_ROLE_ADMIN)->count();
        });
        $data['totalJobs'] = Cache::remember('totalJobs', 60, function () {
            return JobPost::count();
        });
        $data['totalEvents'] = Cache::remember('totalEvents', 60, function () {
            return Event::count();
        });

        if (auth('admin')->user()->role_id == USER_ROLE_ADMIN) {
            return view('admin.dashboard', $data);
        } elseif (auth('admin')->user()->role_id == USER_ROLE_INSTRUCTOR) {
            $recommendations = Recommendation::whereIn('status', [0, 1, 2, 3])->get();

            $data['recommendations'] = [
                'Total' => [
                    'count' => $recommendations->count(),
                    'icon' => 'bi-list',
                ],
                'Pending' => [
                    'count' => $recommendations->where('status', 0)->count(),
                    'icon' => 'bi-clock',
                ],
                'Confirmed' => [
                    'count' => $recommendations->where('status', 1)->count(),
                    'icon' => 'bi-check-circle',
                ],
                'Rejected' => [
                    'count' => $recommendations->where('status', 3)->count(),
                    'icon' => 'bi-x-circle',
                ],
                'Done' => [
                    'count' => $recommendations->where('status', 2)->count(),
                    'icon' => 'bi-check',
                ],
            ];

            if ($request->ajax()) {
                $recommendation = Recommendation::with('alumni')
                    ->where('admin_id', auth('admin')->user()->id);

                return datatables($recommendation)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($data) {
                        return '<input type="checkbox" class="record-checkbox" value="' . $data->id . '">';
                    })
                    ->addColumn('id', function ($data) {
                        return $data->alumni->student_id;
                    })
                    ->addColumn('name', function ($data) {
                        return $data->alumni->first_name . ' ' . $data->alumni->last_name;
                    })
                    ->addColumn('gpa', function ($data) {
                        return $data->alumni->GPA;
                    })
                    ->addColumn('recommendation_count', function ($data) {
                        if (!is_null($data->recommendation) && !empty($data->recommendation)) {
                            $decodedRecommendations = json_decode($data->recommendation, true);
                            if (is_array($decodedRecommendations)) {
                                return count($decodedRecommendations);
                            }
                        }
                        return 0;
                    })
                    ->addColumn('status', function ($data) {
                        $status = $data->status;
                        $statusClasses = [
                            '0' => 'background-color: rgba(255, 255, 0, 0.6); color: black;',
                            '1' => 'background-color: rgba(0, 0, 255, 0.6); color: white;',
                            '2' => 'background-color: rgba(0, 128, 0, 0.6); color: white;',
                            '3' => 'background-color: rgba(255, 0, 0, 0.6); color: white;',
                        ];
                        $statusTexts = [
                            '0' => 'Pending',
                            '1' => 'Confirmed',
                            '2' => 'Done',
                            '3' => 'Rejected',
                        ];
                        return '<span class="p-2 rounded-5" style="' . $statusClasses[$status] . '">' . $statusTexts[$status] . '</span>';
                    })
                    ->addColumn('action', function ($data) {
                        return '<button onclick="getEditModal(\'' . route('admin.instructor.recommendation.edit', $data->id) . '\', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Upload') . '">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="upload" />
                        </button>';
                    })
                    ->rawColumns(['id', 'name', 'status', 'checkbox', 'action'])
                    ->make(true);
            }
            return view('admin.instructor.dashboard', $data);
        }
    }



    public function status_update(Request $request)
    {
        Recommendation::where('admin_id', auth('admin')->id())
            ->whereIn('id', $request->ids)
            ->update(['status' => $request->status]);

        return response()->json(['message' => 'Recommendation request submitted successfully.']);
    }



    public function recommendation_edit(Request $request,$id)
    {
        $data['recommendation']=Recommendation::findOrFail($id);
        return view('admin.instructor.recommendation.edit',$data);
    }

    public function store(Request $request)
    {

        // Ensure files are present in the request
        if ($request->hasFile('recommendations')) {
            $files = array_filter($request->file('recommendations')); // Filter out null values
            $recommendation = Recommendation::with('alumni')->find($request->id);
            $id = $recommendation->alumni->student_id;

            // Get existing recommendations and decode them
            $existingRecommendations = json_decode($recommendation->recommendation, true) ?: [];

            // Check the limit for the number of recommendations
            $recommendationLimit = 3;
            $remainingSlots = $recommendationLimit - count($existingRecommendations);

            if (count($files) > $remainingSlots) {
                Toastr::error('Limit reached. You can upload only ' . $remainingSlots . ' more recommendation(s).');
                return redirect()->back();
            }

            $newRecommendations = $existingRecommendations;

            foreach ($files as $file) {
                if ($remainingSlots <= 0) {
                    break; // Reached the limit, exit the loop
                }

                $randomSlug = Str::random(10);
                $fileName = $id . '_' . $randomSlug . '.pdf';

                // Store the file
                $file->move(storage_path('app/public/alumni/recommendation'), $fileName);

                $newRecommendations[] = $fileName;
                $remainingSlots--;
            }

            // Update the recommendation field
            $recommendation->recommendation = json_encode($newRecommendations);
            $recommendation->save();

            Toastr::success('Files uploaded successfully');
            return redirect()->route('admin.instructor.dashboard');
        }

        Toastr::error('No files were uploaded.');
        return redirect()->back();
    }






}
