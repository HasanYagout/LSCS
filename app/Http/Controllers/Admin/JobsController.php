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
      return $this->jobPostService->store($request);
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
        return view('admin.jobs.edit-form', $data);
    }
    public function toggleStatus(Request $request, $id)
    {
        $job = JobPost::with('company')->find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Job not found.']);
        }

        // Check if the company's status is 0 (inactive)
        if ($job->posted_by=='company' && $job->company->status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update job status because the associated company is inactive. Please update the company status first.'
            ]);
        }


        // Proceed with updating the job status if the company is active
        $job->status = $request->status;
        $job->save();

        return response()->json(['success' => true, 'message' => 'Job status updated successfully.']);
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
        return view('admin.jobs.job_post_view', $data);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            $jobs = JobPost::with('company')->orderBy('id','desc')->get();

            return datatables($jobs)
                ->addIndexColumn()
                ->addColumn('company_logo', function ($data) {
                    if ($data->posted_by=='company'){
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/company/' . $data->company->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
                    }
                    else{
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/' . auth('admin')->user()->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';

                    }
                })
            ->addColumn('title', function ($data) {
                return htmlspecialchars($data->title);
            })
                ->addColumn('company', function ($data) {
//                    $companyName = htmlspecialchars($data->company->name);
//                    $companyId = $data->company; // Assuming you have an ID field for the company
//                    $url = route('admin.company.detail', $companyId); // Generate the URL for the company show route
                    return '<a class="text-f1a527" href="'.route('admin.company.details',$data->company->slug).'" >'.$data->company->name.'</a>';
                })

//            ->addColumn('salary', function ($data) {
//                return htmlspecialchars($data->salary);
//            })
            ->addColumn('application_deadline', function ($data) {
               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
                ->addColumn('posted_by', function ($data) {
                        return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__($data->posted_by).'</span>';

                })
                ->addColumn('status', function ($data) {
                    $checked = $data->status ? 'checked' : '';
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <div class="form-check form-switch">
                        <input class="form-check-input toggle-status" type="checkbox" data-id="' . $data->id . '" id="toggleStatus' . $data->id . '" ' . $checked . '>
                        <label class="form-check-label" for="toggleStatus' . $data->id . '"></label>
                    </div>
                </li>
            </ul>';
                })
                ->addColumn('action', function ($data) {
                    if(auth('admin')->user()->role_id == USER_ROLE_ADMIN){
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('admin.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('admin.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                    <a href="' . route('admin.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';
                    }

                })

                ->rawColumns(['company_logo','status', 'posted_by','company','action', 'title', 'employee_status','action', 'salary', 'application_deadline'])
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
