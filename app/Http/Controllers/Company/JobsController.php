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
    public function details(Request $request,$company,$slug)
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

        return view('company.jobs.job_post_view', $data);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getAllJobPostList($request);
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('company.jobs.all-job-post', $data);
    }

    public function applied(Request $request, $id)
    {
        if ($request->ajax()) {
            return $this->jobPostService->applied($request,$id);
        }
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
        $data['user'] = Alumni::where('id', $id)->first();

        // Check if the user exists in the Alumni table
        if (!$data['user']) {
            // Return an error response or redirect to an appropriate page
            return redirect()->route('company.jobs.index')->with('error', 'Alumni profile not found.');
        }

        return view('company.jobs.alumni_profile', $data);
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getPendingJobPostList($request);
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
