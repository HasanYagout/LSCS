<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Models\AppliedJobs;
use App\Models\Company;
use App\Models\CV;
use App\Models\JobPost;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Http\Services\JobPostService;
use App\Traits\ResponseTrait;
use App\Http\Requests\JobPostRequest;
use App\Http\Services\NoticeCategoryService;
use Illuminate\Support\Facades\Auth;

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
        $data['activePendingJobPostList'] = 'active-color-one';
        $data['appliedJobs'] = AppliedJobs::with('job')
            ->where('alumni_id', Auth::user()->id)
            ->paginate(10); // Specify the number of items per page
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
        $data['cvs']=CV::where('alumni_id',Auth::user()->user_id)->get();
        $data['company']=$company;
        $data['slug']=$slug;
        return view('alumni.jobs.job_post_view', $data);
    }


    public function apply(Request $request, $company, $slug)
    {
       return $this->jobPostService->apply($request, $company, $slug);
    }

    public function all(Request $request)
    {
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';

        // Retrieve the search term from the request
        $searchTerm = $request->input('search');

        // Filter jobs based on the search term
        $data['jobs'] = JobPost::query()
            ->where(function($query) use ($searchTerm) {
                $query->where('title', 'LIKE', "%{$searchTerm}%")
                    ->orWhereHas('company', function($query) use ($searchTerm) {
                        $query->where('name', 'LIKE', "%{$searchTerm}%");
                    })
                    ->orWhere('location', 'LIKE', "%{$searchTerm}%");
            })
            ->where('status', STATUS_ACTIVE)  // Assuming you still want to filter by status
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('alumni.jobs.all-job-post', $data);
    }

}
