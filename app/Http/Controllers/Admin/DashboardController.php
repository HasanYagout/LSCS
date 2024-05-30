<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Models\Recommendation;
use App\Traits\General;
use App\Traits\ResponseTrait;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
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
        if ($request->ajax()) {
            $recommendation=Recommendation::with('alumni')->where('admin_id',auth('admin')->user()->id);

            return datatables($recommendation)
                ->addIndexColumn()
                ->addColumn('checkbox', function ($data) {
                    return '<input type="checkbox" class="record-checkbox" value="'.$data->id.'">';
                })
                ->addColumn('id', function ($data) {

                    return $data->alumni->student_id;
                })
                ->addColumn('name', function ($data) {

                    return $data->alumni->first_name.' '.$data->alumni->last_name;
                })
                ->addColumn('gpa', function ($data) {

                    return $data->alumni->GPA;
                })
                ->addColumn('status', function ($data) {

                    $status = $data->status;
                    $color = '';
                    $statusText = '';

                    switch ($status) {
                        case '1':
                            $color = 'background-color: rgba(0, 0, 255, 0.6); color: white;'; // blue with opacity
                            $statusText = 'Confirmed';
                            break;
                        case '2':
                            $color = 'background-color: rgba(0, 128, 0, 0.6); color: white;'; // green with opacity
                            $statusText = 'Done';
                            break;
                        case '3':
                            $color = 'background-color: rgba(255, 0, 0, 0.6); color: white;'; // red with opacity
                            $statusText = 'Rejected';
                            break;
                        case '0':
                        default:
                            $color = 'background-color: rgba(255, 255, 0, 0.6); color: black;'; // yellow with opacity
                            $statusText = 'Pending';
                            break;
                    }

                    return '<span class="p-2 rounded-5" style="' . $color . '">' . $statusText . '</span>';
                })
                ->addColumn('action', function ($data) {
                    return '<button onclick="getEditModal(\'' . route('admin.instructor.recommendation.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Upload').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="upload" />
                                    </button>';
                })
                ->rawColumns(['id','name', 'status', 'checkbox', 'action'])
                ->make(true);
        }
        $data['pageTitle'] = __('Dashboard');
        $data['activeDashboard'] = 'active';
        if (auth('admin')->user()->role_id==USER_ROLE_ADMIN){
        return view('admin.dashboard', $data);
        }
        elseif (auth('admin')->user()->role_id==USER_ROLE_INSTRUCTOR){
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
        if ($request->hasFile('recommendations')) {
            $files = $request->file('recommendations');
            $recommendation = Recommendation::with('alumni')->find($request->id);
            $id = $recommendation->alumni->student_id;

            $existingRecommendations = $recommendation->recommendation ?: [];

            if (!empty($existingRecommendations)) {
                $decodedRecommendations = json_decode($existingRecommendations, true);

                // Check the limit for the number of recommendations
                $recommendationLimit = 3;
                $remainingSlots = $recommendationLimit - count($decodedRecommendations);

                if ($remainingSlots <= 0) {
                    Toastr::error('Limit reached. You can\'t upload more recommendations.');
                    return redirect()->back();
                }
                $newRecommendations = [];

                // Add existing recommendations to the new array
                foreach ($decodedRecommendations as $existingRecommendation) {
                    $newRecommendations[] = $existingRecommendation;
                }
                foreach ($files as $file) {
                    $randomSlug = Str::random(10);
                    $fileName = $id . '_' . $randomSlug . '.pdf';

                    // Store the file
                    Storage::disk('public')->putFileAs('alumni/recommendation', $file, $fileName);

                    $newRecommendations[] = $fileName;

                    $remainingSlots--;

                    if ($remainingSlots <= 0) {
                        break; // Reached the limit, exit the loop
                    }
                }

                // Update the recommendation field
                $recommendation->recommendation = json_encode($newRecommendations);
                $recommendation->save();

                Toastr::success('Files uploaded successfully');
                return redirect()->route('admin.instructor.dashboard');
            } else {
                $newRecommendations = [];
                foreach ($files as $file) {
                    $randomSlug = Str::random(10);
                    $fileName = $id . '_' . $randomSlug . '.pdf';
                    $newRecommendations[] = $fileName;
                    // Store the file
                    Storage::disk('public')->putFileAs('alumni/recommendation', $file, $fileName);
                    $recommendation->recommendation = json_encode($newRecommendations);
                    $recommendation->save();
                }

                Toastr::success('Files uploaded successfully');
                return redirect()->route('admin.instructor.dashboard');
            }
        }

        Toastr::error('No files were uploaded.');
        return redirect()->back();
    }







}
