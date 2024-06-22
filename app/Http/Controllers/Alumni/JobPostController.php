<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AppliedJobs;
use App\Models\Company;
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


    public function pending(Request $request)
    {

        $data['title'] = __('Pending Jobs');
        $data['showJobPostManagement'] = 'show';
        $data['activeMyJobPostList'] = 'active-color-one';
        $data['appliedJobs'] = AppliedJobs::with('job')->where('alumni_id',auth('alumni')->id())->get();
        return view('alumni.jobs.pending', $data);
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
    public function details(Company $company,$slug)
    {

        $data['title'] = __('Post Details');
        $data['showJobPostManagement'] = 'show';
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        $data['cvs']=CV::where('alumni_id',auth('alumni')->id())->get();
        $data['company']=$company;
        $data['slug']=$slug;
        return view('alumni.jobs.job_post_view', $data);
    }
    public function jobDetails($slug)
    {
        $data['title'] = __('Job Details');
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);;
        return view('alumni.jobs.job_details', $data);
    }

    public function apply(Request $request,$company,$slug)
    {
        $job = new AppliedJobs();
        $job->alumni_id = auth('alumni')->id();
        $job->company_id = $company;
        $job->cv_id=$request->cv_id;
        $jobPost = JobPost::where('slug', $slug)->first();
        $job->job_id = $jobPost->id;
        $jobPost->applied_by += 1; // Increment the applied_by field by 1
        $jobPost->save(); // Save the updated job post
        $job->save();
    }

    public function all(Request $request)
    {

        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        $data['jobs']=JobPost::where('status', STATUS_ACTIVE)
            ->orWhere('status', STATUS_INACTIVE)
            ->get();
        return view('alumni.jobs.all-job-post', $data);
    }
}
