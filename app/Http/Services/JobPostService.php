<?php

namespace App\Http\Services;
use App\Models\JobPost;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use App\Models\Notice;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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


    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (JobPost::where('slug', getSlug($request->title))->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $jobPost = new JobPost();
            $jobPost->title = $request->title;
            $jobPost->slug = $slug;
            $jobPost->user_id = auth('company')->id();
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

            if ($request->hasFile('company_logo')) {
                // Get the original file extension
                $extension = $request->company_logo->getClientOriginalExtension();

                // Generate the new file name
                $date = Carbon::now()->format('Ymd');
                $slug = Str::slug($request->title);
                $randomNumber = rand(1000, 9999);
                $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
                // Save the file to the specified directory
                $request->company_logo->storeAs('public/company/logo/', $newFileName);


                // Get the file URL or ID depending on your file manager
                $jobPost->company_logo = $newFileName; // Assuming you want to save the file path
            }
            $jobPost->save();
            DB::commit();
            session()->flash('success','Job Created Successfully');
            return redirect()->route('company.jobs.all-job-post');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

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
            $jobPost->compensation_n_benefits = $request->compensation_n_benefits;
            $jobPost->salary = $request->salary;
            $jobPost->location = $request->location;
            $jobPost->post_link = $request->post_link;
            $jobPost->application_deadline = $request->application_deadline;
            $jobPost->job_responsibility = $request->job_responsibility;
            $jobPost->educational_requirements = $request->educational_requirements;
            $jobPost->additional_requirements = $request->additional_requirements;
            $jobPost->employee_status = $request->employee_status;
            if($request->status != NULL){
                $jobPost->status = $request->status;
            }
            $jobPost->job_context = $request->job_context;
            if ($request->hasFile('company_logo')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('job_post', $request->company_logo);
                $jobPost->company_logo = $uploaded->id;
            }
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
