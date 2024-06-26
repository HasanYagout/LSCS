<?php

namespace App\Http\Services;
use App\Models\AppliedJobs;
use App\Models\JobPost;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use App\Models\Notice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JobPostService
{
    use ResponseTrait;

    public function getById($id)
    {
        return JobPost::where('tenant_id', getTenantId())->firstOrFail($id);
    }
    public function getBySlug($slug)
    {
        return JobPost::where('slug', $slug)->firstOrFail();
    }

    public function apply(Request $request, $company, $slug)
    {
        DB::beginTransaction();

        try {
            // Validate the request data, specifically ensuring cv_id is present
            $validatedData = $request->validate([
                'cv_id' => 'required|integer',  // Validate that cv_id is required and is an integer
            ]);

            $alumniId = auth('alumni')->id();
            $jobPost = JobPost::where('slug', $slug)->firstOrFail();

            // Check if the alumni has already applied for the job
            $alreadyApplied = AppliedJobs::where('alumni_id', $alumniId)
                ->where('job_id', $jobPost->id)
                ->exists();

            if ($alreadyApplied) {
                session()->flash('error', 'You have already applied for this job.');
                return redirect()->route('alumni.jobs.all-job-post');
            }

            // Proceed with the application
            $job = new AppliedJobs();
            $job->alumni_id = $alumniId;
            $job->company_id = $company;
            $job->cv_id = $validatedData['cv_id']; // Use the validated cv_id
            $job->job_id = $jobPost->id;
            $jobPost->applied_by += 1;  // Increment the applied_by field by 1
            $jobPost->save(); // Save the updated job post
            $job->save();

            // Commit the transaction
            DB::commit();

            session()->flash('success', 'Job Applied Successfully');
            return redirect()->route('alumni.jobs.all-job-post');
        } catch (\Exception $e) {
            // Roll back the transaction on error
            DB::rollBack();
            // Log the error for administrative review
            Log::error('Job application error: ' . $e->getMessage());
            // Flash a more descriptive error message to the session
            session()->flash('error',  $e->getMessage());
            return redirect()->route('alumni.jobs.all-job-post');
        }
    }

    public function getMyJobPostList(){
        $features = JobPost::where('user_id', auth('admin')->id())
            ->where('posted_by','admin')
            ->orderBy('id','desc')->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) {
                return '<img src="' . asset('public/storage/company').'/'.$data->company->image . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('title', function ($data) {
                return htmlspecialchars($data->title);
            })
            ->addColumn('employee_status', function ($data) {
                return $data->employee_status;
            })
            ->addColumn('application_deadline', function ($data) {
               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('status', function ($data) {
                if($data->status == JOB_STATUS_PENDING ){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">Pending</p>';
                    } else if($data->status == JOB_STATUS_APPROVED ){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Approved</p>';
                    } else if($data->status == JOB_STATUS_CANCELED ){
                        return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-ea4335 bg-ea4335-10">Canceled</p>';
                }
            })

            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.jobs.delete', $data->slug) . '\', \'jobPostDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                            <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                        <a href="' . route('admin.jobs.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'company_logo', 'action', 'title', 'employee_status', 'salary', 'application_deadline'])
            ->make(true);
    }


    public function getAllJobPostList(){
        $features = JobPost::where('tenant_id', getTenantId())->where('status',JOB_STATUS_APPROVED)->orderBy('id','desc')->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) {
                return '<img src="' . getFileUrl($data->company_logo) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('title', function ($data) {
                return htmlspecialchars($data->title);
            })
            ->addColumn('employee_status', function ($data) {
                return $this->getEmployeeStatusById($data->employee_status);
            })

            ->addColumn('application_deadline', function ($data) {
               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('status', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('action', function ($data) {
                if(auth()->user()->role == USER_ROLE_ADMIN){
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('jobPost.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('jobPost.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                    <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
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


    public function getPendingJobPostList(){
        $features = JobPost::where('status',JOB_STATUS_APPROVED)->where('posted_by','company')->orderBy('id','desc')->get();
        return datatables($features)
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
            ->addColumn('employee_status', function ($data) {
                return $data->employee_status;
            })

            ->addColumn('application_deadline', function ($data) {
               return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('status', function ($data) {
                if($data->status == JOB_STATUS_PENDING ){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">Pending</p>';
                    } else if($data->status == JOB_STATUS_APPROVED ){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Approved</p>';
                    } else if($data->status == JOB_STATUS_CANCELED ){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-ea4335 bg-ea4335-10">Canceled</p>';
                }
            })

            ->rawColumns(['status', 'company_logo', 'title', 'employee_status', 'application_deadline'])
            ->make(true);
    }


    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Helper to get the authenticated user from multiple guards
            $authUser = $this->getAuthenticatedUser(['company', 'admin']);
            if (!$authUser) {
                return redirect()->route('login')->with('error', 'Not authenticated');
            }

            // Generate a unique slug
            $slugBase = Str::slug($request->title);
            $slug = JobPost::where('slug', 'like', $slugBase . '%')->exists() ?
                $slugBase . '-' . rand(100000, 999999) : $slugBase;

            $jobPost = new JobPost();
            $jobPost->title = $request->title;
            $jobPost->slug = $slug;
            $jobPost->user_id = $authUser->id;
            $jobPost->posted_by = $authUser->getTable(); // Use table name as a proxy for role if roles are distinct by table
            $jobPost->location = $request->location;
            $jobPost->post_link = $request->post_link ?: '';
            $jobPost->application_deadline = $request->application_deadline;
            $jobPost->job_responsibility = $request->job_responsibility;
            $jobPost->job_context = $request->job_context;
            $jobPost->educational_requirements = $request->educational_requirements;
            $jobPost->additional_requirements = $request->additional_requirements;
            $jobPost->employee_status = $request->employee_status;
            $jobPost->status = JOB_STATUS_PENDING;
            $jobPost->skills = json_encode($request->skills);

            $jobPost->save();
            DB::commit();
            session()->flash('success', 'Job Created Successfully');
            return redirect()->route('company.jobs.all-job-post');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Failed to create job: ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Helper to get the authenticated user from multiple guards.
     */
    private function getAuthenticatedUser(array $guards)
    {
        foreach ($guards as $guard) {
            if (auth($guard)->check()) {
                return auth($guard)->user();
            }
        }
        return null;
    }

    public function update($oldSlug, $request)
    {
        DB::beginTransaction();
        try {

            if (JobPost::where('slug', getSlug($request->title))->where('slug', '!=', $oldSlug)->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $jobPost = JobPost::where('slug',$oldSlug)->firstOrFail();
            $jobPost->title = $request->title;

            $jobPost->location = $request->location;
            $jobPost->placement_link = $request->post_link;
            $jobPost->application_deadline = $request->application_deadline;
            $jobPost->skills = $request->skills;
            $jobPost->job_responsibility = $request->job_responsibility;
            $jobPost->educational_requirements = $request->educational_requirements;
            $jobPost->additional_requirements = $request->additional_requirements;
            $jobPost->employee_status = $request->employee_status;
            if($request->status != NULL){
                $jobPost->status = $request->status;
            }
            $jobPost->job_context = $request->job_context;


            $jobPost->save();
            DB::commit();
            session()->flash('success','Job updated successfully');
            return redirect()->route('company.jobs.all-job-post');
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function deleteById($slug)
    {
        try {
            DB::beginTransaction();
            $jobPost = JobPost::where('slug', $slug)->firstOrFail();
            $jobPost->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getEmployeeStatusById($employee_status_id){
        return getEmployeeStatus($employee_status_id);
    }
}
