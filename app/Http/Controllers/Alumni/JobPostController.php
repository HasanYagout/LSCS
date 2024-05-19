<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\CV;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Services\JobPostService;
use App\Traits\ResponseTrait;
use App\Http\Requests\JobPostRequest;
use App\Http\Services\NoticeCategoryService;

class JobPostController extends Controller
{
    use ResponseTrait;
    public $jobPostService ;
    public function __construct()
    {
        $this->jobPostService = new JobPostService();
    }
    public function createJobPost(Request $request)
    {
        $data['title'] = __('Create Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeJobPostCreate'] = 'active-color-one';
        return view('alumni.jobs.create', $data);

    }

    public function addJobPost(JobPostRequest $request)
    {
        return  $this->jobPostService->store($request);
    }

    public function myJobPost(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getMyJobPostList();
        }
        $data['title'] = __('My Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeMyJobPostList'] = 'active-color-one';
        return view('alumni.jobs.my-job-post', $data);
    }
    public function info($slug)
    {
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        return view('alumni.jobs.edit-form', $data);
    }

    public function update(JobPostRequest $request, $slug)
    {
        return $this->jobPostService->update($slug, $request);
    }
    public function delete($slug)
    {
        return $this->jobPostService->deleteById($slug);
    }
    public function details($slug)
    {
        $data['title'] = __('Post Details');
        $data['showJobPostManagement'] = 'show';
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        $data['cvs']=CV::where('alumni_id',auth('alumni')->id())->get();

        return view('alumni.jobs.job_post_view', $data);
    }

    public function apply(Request $request)
    {
        dd($request->all());
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            $jobs = JobPost::orderBy('id','desc')->get();

            return datatables($jobs)
                ->addIndexColumn()
                ->addColumn('company_logo', function ($data) {
                    return '<img src="' . $data->company->logo . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
                })

                ->addColumn('action', function ($data) {
                    if(auth('alumni')->user()->role_id == USER_ROLE_ALUMNI){
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('admin.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                    <a href="' . route('admin.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';
                    }
                    else{
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <a href="' . route('alumni.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                    </li>
                </ul>';
                    }

                })

                ->rawColumns(['company_logo', 'action', 'title', 'employee_status', 'salary', 'application_deadline'])
                ->make(true);
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('alumni.jobs.all-job-post', $data);
    }
}
