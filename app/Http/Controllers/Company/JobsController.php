<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
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

    public function add(Request $request)
    {

        $jobPost = new JobPost();
        $slug = getSlug($request->title) . '-' . rand(100000, 999999).'-'.Str::random(6);

        $jobPost->title = $request->title;
        $jobPost->slug = $slug;
        $jobPost->company_id = auth('company')->id();
        $jobPost->compensation_n_benefits = $request->compensation_n_benefits;
        $jobPost->salary = $request->salary;
        $jobPost->location = $request->location;
        $jobPost->post_link = $request->post_link?$request->post_link:'';
        $jobPost->application_deadline = $request->application_deadline;
        $jobPost->job_responsibility = $request->job_responsibility;
        $jobPost->job_context = $request->job_context;
        $jobPost->educational_requirements = $request->educational_requirements;
        $jobPost->additional_requirements = $request->additional_requirements;
        $jobPost->employee_status = $request->employee_status;
        $jobPost->status = JOB_STATUS_PENDING;
        $jobPost->posted_by= 'company';
        $jobPost->save();
    }

    public function myJobPost(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getMyJobPostList();
        }
        $data['title'] = __('My Job Post');
        $data['showJobPostManagement'] = 'show';
        $data['activeMyJobPostList'] = 'active-color-one';
        return view('company.jobs.my-job-post', $data);
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
    public function details($company,$slug)
    {
        $data['title'] = __('Post Details');
        $data['showJobPostManagement'] = 'show';
        $data['jobPostData'] = $this->jobPostService->getBySlug($slug);
        $data['majors']=Major::all();
        $data['years']=Alumni::distinct()->pluck('graduation_year')->toArray();
        $data['gpas'] = Alumni::select('gpa')->get()->map(function ($user) {
            return round($user->gpa);
        })->toArray();

        return view('company.jobs.job_post_view', $data);
    }

    public function all(Request $request)
    {
        if ($request->ajax()) {
            $features = JobPost::where('company_id',auth('company')->id())->orderBy('id','desc')->get();
            return datatables($features)
                ->addIndexColumn()
//            ->addColumn('company_logo', function ($data) {
//
//                return '<img src="' . getFileUrl($data->company_logo) . '" alt="icon" class="rounded avatar-xs max-h-35">';
//            })
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
                    if(auth('company')->user()->role_id == USER_ROLE_COMPANY){
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('company.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('company.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                    <a href="' . route('company.jobs.details', ['company'=>auth('company')->id(),'slug'=>$data->slug]) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';
                    }else{
                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
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
        return view('company.jobs.all-job-post', $data);
    }

    public function applied(Request $request,$id)
    {


        if ($request->ajax()) {
            $applied = AppliedJobs::with('alumni')->where('company_id', auth('company')->id())->where('job_id',$id)->orderBy('id', 'desc')->get();

            return datatables($applied)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {

                    return $data->alumni->first_name . ' ' . $data->alumni->last_name;
                })
                ->addColumn('gpa', function ($data) {
                    return $data->alumni->GPA;
                })
                ->addColumn('major',function ($data){
                    return $data->alumni->major;
                })
                ->addColumn('graduation_year', function ($data){
                    return $data->alumni->graduation_year;
                })
//                ->addColumn('action', function ($data) {
//                    if (auth('company')->user()->role_id == USER_ROLE_COMPANY) {
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                                <li class="d-flex gap-2">
//                                    <button onclick="getEditModal(\'' . route('company.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Edit') . '">
//                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
//                                    </button>
//                                    <button onclick="deleteItem(\'' . route('company.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
//                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
//                                    </button>
//                                    <a href="' . route('company.jobs.details', ['company' => auth('company')->id(), 'slug' => $data->slug]) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
//                                </li>
//                            </ul>';
//                    } else {
//                        return '<ul class="d-flex align-items-center cg-5 justify-content-center">
//                    <li class="d-flex gap-2">
//                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
//                    </li>
//                </ul>';
//                    }
//
//                })
                ->rawColumns(['name','gpa','major','graduation_year'])
                ->make(true);
        }
    }
    public function pending(Request $request)
    {
        if ($request->ajax()) {
            return $this->jobPostService->getPendingJobPostList();
        }
        $data['title'] = __('Pending Job List');
        $data['showJobPostManagement'] = 'show';
        $data['activePendingJobPostList'] = 'active-color-one';
        return view('company.jobs.pending-job-post', $data);
    }
}
