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

        $data['cvs']=CV::where('alumni_id',Auth::user()->id)->get();
        $data['company']=$company;
        $data['slug']=$slug;
        return view('alumni.jobs.job_post_view', $data);
    }


    public function apply(Request $request, $slug)
    {
       return $this->jobPostService->apply($request, $slug);
    }

    public function all(Request $request)
    {
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';

        // Retrieve the search term from the request
        $searchTerm = $request->input('search');

        // Filter jobs based on the search term
        $jobs = JobPost::leftJoin('companies', function($join) {
            $join->on('job_posts.user_id', '=', 'companies.id')
                ->where('job_posts.posted_by', '=', 'company');
        })
            ->leftJoin('admins', function($join) {
                $join->on('job_posts.user_id', '=', 'admins.id')
                    ->where('job_posts.posted_by', '=', 'admin');
            })
            ->select('job_posts.*', 'companies.name as company_name', 'admins.first_name as admin_name')
            ->where(function ($query) {
                $query->where('job_posts.status', STATUS_ACTIVE)
                    ->orWhere('job_posts.status', STATUS_INACTIVE);
            });

        if ($searchTerm) {
            $jobs->where(function ($query) use ($searchTerm) {
                $query->where('job_posts.title', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('companies.name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('admins.first_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        $data['jobs'] = $jobs->orderBy('job_posts.id', 'desc')
            ->paginate(10);

        return view('alumni.jobs.all-job-post', $data);
    }

}
