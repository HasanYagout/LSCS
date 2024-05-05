<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
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
        return view('alumni.job_posts.create', $data);

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
        return view('alumni.job_posts.my-job-post', $data);
    }
    public function info($slug)
    {
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        return view('alumni.job_posts.edit-form', $data);
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
        return view('alumni.job_posts.job_post_view', $data);
    }

    public function allJobPost(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getAllJobPostList();
        }
        $data['title'] = __('All Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeAllJobPostList'] = 'active-color-one';
        return view('alumni.job_posts.all-job-post', $data);
    }
}
