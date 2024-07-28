<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alumni;
use App\Models\AppliedJobs;
use App\Models\Company;
use App\Models\JobPost;
use App\Models\Major;
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

    public function alumniProfile($id)
    {
// Check if the id exists in the applied_jobs table
        $existsInAppliedJobs = AppliedJobs::where('alumni_id', $id)->exists();


        if (!$existsInAppliedJobs) {
            // Return an error response or redirect to an appropriate page
            return redirect()->back()->with('error', 'Student ID not found in applied jobs.');
        }

        // Proceed to fetch the alumni profile
        $data['activeProfile'] = 'active';
        $data['showProfileManagement'] = 'show';
        $data['user'] = Alumni::where('user_id', $id)->first();

        // Check if the user exists in the Alumni table
        if (!$data['user']) {
            // Return an error response or redirect to an appropriate page
            return redirect()->route('admin.jobs.index')->with('error', 'Alumni profile not found.');
        }

        return view('admin.jobs.alumni_profile', $data);
    }

    public function add(Request $request)
    {
      return $this->jobPostService->store($request);
    }

    public function myJobPost(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getMyJobPostList($request);
        }
        $data['title'] = __('My Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeMyJobPostList'] = 'active-color-one';
        return view('admin.jobs.my-job-post', $data);
    }
    public function info($slug)
    {
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        return view('admin.jobs.edit-form', $data);
    }
    public function applied(Request $request, $id)
    {
        if ($request->ajax()) {
            return $this->jobPostService->applied($request,$id);
        }
    }
    public function toggleStatus(Request $request, $id)
    {
       return $this->jobPostService->changeStatus($request,$id);

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


        // Get job post data by slug with eager loaded relationships
        $jobPostData = $this->jobPostService->getBySlug($slug);

        // Get the major IDs from the jobPostData
        $majorIds = $jobPostData->appliedJobs->pluck('alumni.major')->unique()->toArray();
        // Get distinct majors, years, and GPAs from the alumni who applied
        $data['majors'] = Major::whereIn('name', $majorIds)->get();

        $data['years'] = $jobPostData->appliedJobs->pluck('alumni.graduation_year')->unique()->toArray();

        $data['gpas'] = $jobPostData->appliedJobs->pluck('alumni.GPA')->map(function ($gpa) {
            return round($gpa);
        })->unique()->toArray();


        $data['jobPostData'] = $jobPostData;

        return view('admin.jobs.job_post_view', $data);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
         return $this->jobPostService->getAllJobPostList($request);
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';

        $data['companies'] = JobPost::with('company')->get();
        return view('admin.jobs.all-job-post', $data);
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getPendingJobPostList($request);
        }
        $data['title'] = __('Active Job List');
        $data['showJobPostManagement'] = 'show';
        $data['activePendingJobPostList'] = 'active-color-one';
        $data['companies'] = JobPost::with('company','admin')->get();
        return view('admin.jobs.pending-job-post', $data);
    }
}
