<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Http\Services\JobPostService;
use App\Traits\ResponseTrait;
use App\Http\Requests\JobPostRequest;
use App\Http\Services\NoticeCategoryService;

class   JobsController extends Controller
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
        return view('admin.jobs.create', $data);

    }

    public function add(Request $request)
    {
        $jobPost = new JobPost();
        if (JobPost::where('slug', getSlug($request->title))->withTrashed()->count() > 0) {
            $slug = getSlug($request->title) . '-' . rand(100000, 999999);
        } else {
            $slug = getSlug($request->title);
        }
        $jobPost->title = $request->title;
        $jobPost->slug = $slug;
        $jobPost->compensation_n_benefits = $request->compensation_n_benefits;
        $jobPost->salary = $request->salary;
        $jobPost->location = $request->location;
        $jobPost->post_link = $request->post_link;
        dd($jobPost);
        $jobPost->application_deadline = $request->application_deadline;
        $jobPost->job_responsibility = $request->job_responsibility;
        $jobPost->job_context = $request->job_context;
        $jobPost->educational_requirements = $request->educational_requirements;
        $jobPost->additional_requirements = $request->additional_requirements;
        $jobPost->employee_status = $request->employee_status;
        $jobPost->status = JOB_STATUS_PENDING;
        $jobPost->tenant_id = getTenantId();
        $jobPost->user_id = auth('admin')->id();
    }

    public function myJobPost(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getMyJobPostList();
        }
        $data['title'] = __('My Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeMyJobPostList'] = 'active-color-one';
        return view('admin.jobs.my-job-post', $data);
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
        return view('alumni.jobs.job_post_view', $data);
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
//            ->addColumn('title', function ($data) {
//                return htmlspecialchars($data->title);
//            })
//            ->addColumn('employee_status', function ($data) {
//                return $this->getEmployeeStatusById($data->employee_status);
//            })
//            ->addColumn('salary', function ($data) {
//                return htmlspecialchars($data->salary);
//            })
//            ->addColumn('application_deadline', function ($data) {
//               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
//            })
//
                ->addColumn('action', function ($data) {
                    if(auth('admin')->user()->role_id == USER_ROLE_COMPANY){
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
                    }else{
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <a href="' . route('company.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
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
        return view('admin.jobs.all-job-post', $data);
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getPendingJobPostList();
        }
        $data['title'] = __('Pending Job List');
        $data['showJobPostManagement'] = 'show';
        $data['activePendingJobPostList'] = 'active-color-one';
        return view('admin.jobs.pending-job-post', $data);
    }
}
