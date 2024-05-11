<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPost;
use Illuminate\Http\Request;
use App\Http\Services\JobPostService;
use App\Traits\ResponseTrait;
use App\Http\Requests\JobPostRequest;
use App\Http\Services\NoticeCategoryService;

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
            return $this->jobPostService->getAllJobPostList();
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
