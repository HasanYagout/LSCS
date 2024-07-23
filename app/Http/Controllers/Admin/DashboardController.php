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
use App\Models\User;
use App\Traits\General;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Facades\Toastr;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        $user = Auth::user();

        $roleUserInfoMap = [
            1 => ['userInfo' => $user->admin, 'role' => 'admin'],
            4 => ['userInfo' => $user->alumni, 'role' => 'instructor']
        ];

        $userData = $roleUserInfoMap[$user->role_id] ?? abort(403, 'Unauthorized action.');
        $userInfo = $userData['userInfo'];
        $role = $userData['role'];

        $data = [
            'pageTitle' => __('Dashboard'),
            'activeDashboard' => 'active',
            'totalAlumni' => Cache::remember('totalAlumni', 60, fn() => User::where('role_id',2)->count()),
            'totalCompany' => Cache::remember('totalCompany', 60, fn() => User::where('role_id',3)->count()),
            'totalInstructors' => Cache::remember('totalInstructors', 60, fn() => User::where('role_id',4)->count()),
            'totalAdmins' => Cache::remember('totalAdmins', 60, fn() => User::where('role_id',1)->count()),
            'totalJobs' => Cache::remember('totalJobs', 60, fn() => JobPost::count()),
            'totalEvents' => Cache::remember('totalEvents', 60, fn() => Event::count()),
            'userInfo' => $userInfo,
            'role' => $role,
            'items' => [
                [
                    'title' => __('Total Alumni'),
                    'count' => Cache::remember('totalAlumni', 60, fn() => Alumni::count()),
                    'color' => '#f1a527',
                    'icon' => 'bi-person',
                    'svg' => '<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/>'
                ],
                [
                    'title' => __('Total Instructors'),
                    'count' => Cache::remember('totalInstructors', 60, fn() => Admin::where('role_id', USER_ROLE_INSTRUCTOR)->count()),
                    'color' => '#ae75c4',
                    'icon' => 'bi-person',
                    'svg' => '<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/>'
                ],
                [
                    'title' => __('Total Admins'),
                    'count' => Cache::remember('totalAdmins', 60, fn() => Admin::where('role_id', USER_ROLE_ADMIN)->count()),
                    'color' => '#17a2b8',
                    'icon' => 'bi-person',
                    'svg' => '<path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/>'
                ],
                [
                    'title' => __('Upcoming Event'),
                    'count' => Cache::remember('totalEvents', 60, fn() => Event::count()),
                    'color' => '#dc3545',
                    'icon' => 'bi-calendar-minus',
                    'svg' => '<path d="M5.5 9.5A.5.5 0 0 1 6 9h4a.5.5 0 0 1 0 1H6a.5.5 0 0 1-.5-.5"/><path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z"/>'
                ],
                [
                    'title' => __('Total Companies'),
                    'count' => Cache::remember('totalCompany', 60, fn() => Company::count()),
                    'color' => '#17a2b8',
                    'icon' => 'bi-building',
                    'svg' => '<path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5z"/><path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>'
                ],
                [
                    'title' => __('Total Jobs'),
                    'count' => Cache::remember('totalJobs', 60, fn() => JobPost::count()),
                    'color' => '#f1a527',
                    'icon' => 'bi-briefcase',
                    'svg' => '<path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v8A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5v-8A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5m1.886 6.914L15 7.151V12.5a.5.5 0 0 1-.5.5h-13a.5.5 0 0 1-.5-.5V7.15l6.614 1.764a1.5 1.5 0 0 0 .772 0M1.5 4h13a.5.5 0 0 1 .5.5v1.616L8.129 7.948a.5.5 0 0 1-.258 0L1 6.116V4.5a.5.5 0 0 1 .5-.5"/>'
                ]
            ]
        ];

        if ($role == 'admin') {
            return view('admin.dashboard', $data);
        } elseif ($role == 'instructor') {
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
                    ->where('recommendations.admin_id', auth('admin')->user()->id)
                    ->join('alumnis', 'recommendations.alumni_id', '=', 'alumnis.id')
                    ->select(
                        'recommendations.*',
                        'alumnis.id as alumni_unique_id',
                        'alumnis.first_name as alumni_first_name',
                        'alumnis.last_name as alumni_last_name'
                    );

                if ($request->has('search') && $request->search['value'] != '') {
                    $search = $request->search['value'];
                    $recommendation->where(function ($q) use ($search) {
                        $q->where('alumnis.first_name', 'like', "%{$search}%")
                            ->orWhere('alumnis.last_name', 'like', "%{$search}%")
                            ->orWhere('alumnis.id', 'like', "%{$search}%");
                    });
                }

                if ($request->has('order') && $request->has('columns')) {
                    foreach ($request->order as $order) {
                        $orderBy = $request->columns[$order['column']]['data'];
                        $orderDirection = $order['dir'];

                        if (in_array($orderBy, ['id', 'name', 'gpa'])) {
                            if ($orderBy == 'name') {
                                $recommendation->orderBy('alumnis.first_name', $orderDirection);
                            } else {
                                $recommendation->orderBy($orderBy, $orderDirection);
                            }
                        }
                    }
                } else {
                    $recommendation->orderBy('alumnis.id', 'desc');
                }

                return datatables($recommendation)
                    ->addIndexColumn()
                    ->addColumn('checkbox', function ($data) {
                        return '<input type="checkbox" class="record-checkbox" value="' . $data->id . '">';
                    })
                    ->addColumn('id', function ($data) {
                        return $data->alumni_id;
                    })
                    ->addColumn('name', function ($data) {
                        return $data->alumni_first_name . ' ' . $data->alumni_last_name;
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
            $id = $recommendation->alumni->id;

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
