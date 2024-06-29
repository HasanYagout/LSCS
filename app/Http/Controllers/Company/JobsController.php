<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\company\CreateJobRequest;
use App\Models\Alumni;
use App\Models\AppliedJobs;
use App\Models\JobPost;
use App\Models\Major;
use Illuminate\Http\Request;
use App\Http\Services\JobPostService;
use App\Traits\ResponseTrait;
use App\Http\Requests\JobPostRequest;
use App\Http\Services\NoticeCategoryService;
use Illuminate\Support\Str;

class JobsController extends Controller
{
    use ResponseTrait;
    public $jobPostService ;
    public function __construct()
    {
        $this->jobPostService = new JobPostService();
    }

    public function create(Request $request)
    {
        $data['title'] = __('Create Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeJobPostCreate'] = 'active-color-one';
        return view('company.jobs.create', $data);

    }

    public function add(CreateJobRequest $request)
    {
        return $this->jobPostService->store($request);
    }

    public function info($slug)
    {
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        return view('company.jobs.edit-form', $data);
    }

    public function update(JobPostRequest $request, $slug)
    {
        return $this->jobPostService->update($slug, $request);
    }
    public function delete($slug)
    {
        return $this->jobPostService->deleteById($slug);
    }
    public function details($company,$slug)
    {
        $data['title'] = __('Post Details');
        $data['showJobPostManagement'] = 'show';
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        $data['majors']=Major::all();
        $data['years']=Alumni::distinct()->pluck('graduation_year')->toArray();
        $data['gpas'] = Alumni::select('gpa')->get()->map(function ($user) {
            return round($user->gpa);
        })->toArray();

        return view('company.jobs.job_post_view', $data);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getAllJobPostList();
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('company.jobs.all-job-post', $data);
    }

    public function applied(Request $request,$id)
    {

        if ($request->ajax()) {
            $applied = AppliedJobs::with('alumni')->where('company_id', auth('company')->id())->where('job_id',$id)->orderBy('id', 'desc')->get();

            return datatables($applied)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {

                    return $data->alumni->first_name . ' ' . $data->alumni->last_name;
                })
                ->addColumn('gpa', function ($data) {
                    return $data->alumni->GPA;
                })
                ->addColumn('major',function ($data){
                    return $data->alumni->major;
                })
                ->addColumn('graduation_year', function ($data){
                    return $data->alumni->graduation_year;
                })
//                ->addColumn('action', function ($data) {
//                    if (auth('company')->user()->role_id == USER_ROLE_COMPANY) {
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                                <li class="d-flex gap-2">
//                                    <button onclick="getEditModal(\'' . route('company.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Edit') . '">
//                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
//                                    </button>
//                                    <button onclick="deleteItem(\'' . route('company.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
//                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
//                                    </button>
//                                    <a href="' . route('company.jobs.details', ['company' => auth('company')->id(), 'slug' => $data->slug]) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
//                                </li>
//                            </ul>';
//                    } else {
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                    <li class="d-flex gap-2">
//                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
//                    </li>
//                </ul>';
//                    }
//
//                })
                ->rawColumns(['name','gpa','major','graduation_year'])
                ->make(true);
        }
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getPendingJobPostList();
        }
        $data['title'] = __('Pending Job List');
        $data['showJobPostManagement'] = 'show';
        $data['activePendingJobPostList'] = 'active-color-one';
        return view('company.jobs.pending-job-post', $data);
    }
    public function toggleStatus(Request $request,$id)
    {
        return $this->jobPostService->changeStatus($request,$id);
//        $job = JobPost::find($request->id);
//        if ($job) {
//            $job->status = $job->status == STATUS_ACTIVE ? STATUS_INACTIVE : STATUS_ACTIVE;
//            $job->save();
//            return response()->json(['success' => true]);
//        }
//        return response()->json(['success' => false]);
    }
}
