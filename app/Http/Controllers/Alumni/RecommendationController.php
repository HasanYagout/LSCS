<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Recommendation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
                ->addColumn('action', function ($data) {
                    return '<button onclick="getEditModal(\'' . route('alumni.recommendation.edit', $data->admin_id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Upload').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="upload" />
                                    </button>';
                })
                ->rawColumns(['status','action'])
                ->make(true);
        }


    }

    public function create(Request $request){
        $data['title'] = __('Create Recommendation');
        $data['admins']=Admin::where('role_id',4)->get();
        return view('alumni.recommendation.create',$data);
    }

    public function edit(Request $request,$id)
    {
        $data['recommendations']=Recommendation::where('admin_id',$id)
        ->where('alumni_id', auth('alumni')->id())->value('recommendation');

        return view('alumni.recommendation.view',$data);
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
    public function view($file)
    {

        $filePath = public_path('storage/alumni/recommendation/' . $file);

        if (file_exists($filePath)) {
            return response()->file($filePath, [
                'Content-Type' => 'application/pdf',
            ]);
        }

        abort(404, 'File not found.');
    }

    public function download($file)
    {
        $filePath = public_path('storage/alumni/recommendation/' . $file);

        if (file_exists($filePath)) {
            return response()->download($filePath);
        }

        abort(404, 'File not found.');
    }
}
