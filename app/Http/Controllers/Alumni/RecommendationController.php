<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Recommendation;
use Illuminate\Http\Request;

class RecommendationController extends Controller
{
    public function index()
    {
        return view('alumni.recommendation.index');
    }

    public function list(Request $request)
    {
        if ($request->ajax()) {
            $recommendations = Recommendation::with(['alumni', 'admin'])
                ->where('alumni_id', auth('alumni')->id())
                ->get();

            return datatables($recommendations)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return $data->admin->first_name . ' ' . $data->admin->last_name;
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
                ->rawColumns(['status'])
                ->make(true);
        }


    }

    public function create(Request $request){
        $data['title'] = __('Create Recommendation');
        $data['admins']=Admin::where('role_id',4)->get();
        return view('alumni.recommendation.create',$data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'instructor' => 'required|exists:admins,id', // assuming instructors are users
            'details' => 'required|string|max:2000',
        ]);

        Recommendation::create(['alumni_id'=>auth('alumni')->id(),
            'admin_id'=>$request->instructor,'status'=>0]);
        return back()->with('success', 'Recommendation request submitted successfully.');

    }
}
