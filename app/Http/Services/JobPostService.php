<?php

namespace App\Http\Services;
use App\Jobs\SendJobPostEmail;
use App\Models\Alumni;
use App\Models\AppliedJobs;
use App\Models\JobPost;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use App\Models\Notice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
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
        return JobPost::where('slug', $slug)
            ->with(['appliedJobs.alumni', 'appliedJobs.cv']) // Eager load alumni and cv data
            ->firstOrFail();
    }

    public function apply(Request $request, $company, $slug)
    {
        DB::beginTransaction();

        try {
            // Validate the request data, specifically ensuring cv_id is present
            $validatedData = $request->validate([
                'cv_id' => 'required|integer',  // Validate that cv_id is required and is an integer
            ]);

            $alumniId = Auth::user()->user_id;
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

    public function getMyJobPostList($request){
        $user=Auth::user();
        $query = JobPost::where('user_id', $user->id)
            ->where('posted_by','admin');

        if ($request->search['value']) {
            $search = $request->search['value'];
            $query->where('title', 'like', "%{$search}%");
        }

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                // Ensure the column exists in the database to avoid errors
                if (in_array($orderBy, ['company.name', 'title', 'application_deadline', 'posted_by', 'status'])) {
                    $orderDirection = $order['dir'];
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/company/' . $data->company->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
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


    public function getAllJobPostList(Request $request)
    {
        $authUser = $this->getAuthenticatedUser();

        $query = JobPost::with('company'); // Eager load the company relationship
        // Base query adjustments based on user type
        $query->where(function ($q) use ($authUser) {
            if ($authUser->role_id == 1) {
                $q->where('posted_by', 'admin')
                    ->orWhere('posted_by', 'company');
            } else {
                $q->where('user_id', $authUser->user_id)
                    ->where('posted_by', 'company');
            }
        });
        // Conditionally add status filter
        if (isset($request->status) && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Additional filters
        if (isset($request->postedBy) && $request->postedBy != 'all') {
            $query->where('posted_by', $request->postedBy);
        }

        if (isset($request->company) && $request->company != 'all') {
            $query->whereHas('company', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->company}%");
            });
        }

        // Handle search input only if it has a value
        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('company', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                // Ensure the column exists in the database to avoid errors
                if (in_array($orderBy, ['company.name', 'title', 'application_deadline', 'posted_by', 'status'])) {
                    $orderDirection = $order['dir'];
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('id', 'desc');
        }

        // Handle DataTables response
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) use ($authUser) {

                if ($authUser->role_id == 1) {
                    if ($data->posted_by == 'company') {
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/company/image' .'/'. $data->company->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
                    } else {
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/image' .'/'. $authUser->admin->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
                    }
                }
            })
            ->addColumn('company', function ($data) {
                return $data->company ? $data->company->name : '';
            })
            ->addColumn('posted_by', function ($data) {
                return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16' . ($data->posted_by == 'admin' ? ' text-0fa958 bg-0fa958-10' : ' text-f5b40a bg-f5b40a-10') . '">' . $data->posted_by . '</p>';
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
            ->addColumn('action', function ($data) use ($authUser) {
                $auth = $authUser->role_id == '3' ? 'company' : 'admin';
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                        <li class="d-flex gap-2">
                            <button onclick="getEditModal(\'' . route($auth . '.jobs.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                            </button>
                            <button onclick="deleteItem(\'' . route($auth . '.jobs.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                            </button>
                            <a href="' . route($auth . '.jobs.details', ['company' => Auth::user()->user_id, 'slug' => $data->slug]) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
                        </li>
                    </ul>';
            })
            ->rawColumns(['company_logo', 'posted_by', 'status', 'action', 'company'])
            ->make(true);
    }



    public function getPendingJobPostList($request){

        $authUser = $this->getAuthenticatedUser();
        $query = JobPost::with('company')->where('status',JOB_STATUS_APPROVED); // Eager load the company relationship

// Base query adjustments based on user type
        $query->where(function($q) use ($authUser, $request) {
            if ($authUser->role_id == 1) {
                $q->where('posted_by', 'admin')
                    ->orWhere('posted_by','company');
            } else {
                $q->where('user_id', $authUser->user_id)
                    ->where('posted_by', 'company');
            }

        });

        // Conditionally add status filter
        if (isset($request->status) && $request->status != 'all') {

            $query->where('status', $request->status);
        }
// Additional filters
        if (isset($request->postedBy) && $request->postedBy != 'all') {
            $query->where('posted_by', $request->postedBy);
        }

        if (isset($request->company) && $request->company != 'all') {
            $query->whereHas('company', function($q) use ($request) {
                $q->where('name', 'like', "%{$request->company}%");
            });
        }

// Handle search input only if it has a value
        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('company', function($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }
        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                // Ensure the column exists in the database to avoid errors
                if (in_array($orderBy, ['company.name', 'title', 'application_deadline', 'posted_by', 'status'])) {
                    $orderDirection = $order['dir'];
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('id', 'desc');
        }
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) use($authUser) {
                if ($authUser->role_id==1){
                    if ($data->posted_by=='company'){
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/company/image' . $data->company->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';
                    }
                    else{
                        return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/image' . $authUser->admin->image) . '" alt="Company Logo" class="rounded avatar-xs max-h-35">';

                    }
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

    public function changeStatus(Request $request, $id)
    {
        $job = JobPost::with('company')->find($id);
        if (!$job) {
            return response()->json(['success' => false, 'message' => 'Job not found.']);
        }

        if (Auth::user() && Auth::user()->role_id==1 && $job->company && $job->company->status == 0) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update job status because the associated company is inactive. Please update the company status first.'
            ]);
        }

        // Proceed with updating the job status
        $job->status = $request->status;
        $job->save();

        return response()->json(['success' => true, 'message' => 'Job status updated successfully.']);
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
            $jobPost->user_id = $authUser->user()->id;
            $jobPost->posted_by = $authUser->name; // Use table name as a proxy for role if roles are distinct by table
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
            SendJobPostEmail::dispatch($jobPost);
            dd('da');
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
    private function getAuthenticatedUser()
    {
        return Auth::user();
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
            $jobPost->placement_link = $request->placement_link;
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

    public function applied($request,$id)
    {
        $applied = AppliedJobs::with(['alumni', 'cv'])
            ->where('company_id', Auth::user()->user_id)
            ->where('job_id', $id)
            ->when($request->filled('selectedMajor') && $request->selectedMajor != "0", function ($query) use ($request) {
                return $query->whereHas('alumni', function ($query) use ($request) {
                    $query->where('major', $request->selectedMajor);
                });
            })
            ->when($request->filled('selectedYear') && $request->selectedYear != "0", function ($query) use ($request) {
                return $query->whereHas('alumni', function ($query) use ($request) {
                    $query->where('graduation_year', $request->selectedYear);
                });
            })
            ->when($request->filled('gpa') && $request->gpa != "-1", function ($query) use ($request) {
                $gpa = (float) $request->gpa;
                $lowerBound = $gpa - 1;
                return $query->whereHas('alumni', function ($query) use ($lowerBound, $gpa) {
                    $query->whereBetween('GPA', [$lowerBound, $gpa]);
                });
            });

        // Handle ordering
        if ($request->has('order')) {
            $columns = ['name', 'gpa', 'major', 'graduation_year', 'action'];
            $order = $request->input('order')[0];
            $orderColumn = $columns[$order['column']];
            $orderDirection = $order['dir'];

            // Adding additional order columns
            switch ($orderColumn) {
                case 'name':
                    $applied->orderBy(Alumni::select('first_name')
                        ->whereColumn('alumnis.id', 'applied_jobs.alumni_id'), $orderDirection);
                    break;
                case 'gpa':
                    $applied->orderBy(Alumni::select('GPA')
                        ->whereColumn('alumnis.id', 'applied_jobs.alumni_id'), $orderDirection);
                    break;
                case 'major':
                    $applied->orderBy(Alumni::select('major')
                        ->whereColumn('alumnis.id', 'applied_jobs.alumni_id'), $orderDirection);
                    break;
                case 'graduation_year':
                    $applied->orderBy(Alumni::select('graduation_year')
                        ->whereColumn('alumnis.id', 'applied_jobs.alumni_id'), $orderDirection);
                    break;
                default:
                    $applied->orderBy($orderColumn, $orderDirection);
                    break;
            }
        } else {
            $applied->orderBy('id', 'desc');
        }

        $appliedData = $applied->get();

        return datatables($appliedData)
            ->addIndexColumn()
            ->addColumn('name', function ($data) {
                return '<a class="text-707070 text-decoration-underline" href="' . route('company.jobs.alumni-profile', ['id' => $data->alumni->id]) . '">' . $data->alumni->first_name . ' ' . $data->alumni->last_name . '</a>';
            })
            ->addColumn('gpa', function ($data) {
                return $data->alumni->GPA;
            })
            ->addColumn('major', function ($data) {
                return $data->alumni->major;
            })
            ->addColumn('graduation_year', function ($data) {
                return $data->alumni->graduation_year;
            })
            ->addColumn('action', function ($data) {
                return '<a href="' . asset('public/storage/alumni/cv/' . $data->cv->name) . '" class="btn btn-sm bg-71e3ba" download><i class="fa text-white fa-download"></i></a>';
            })
            ->rawColumns(['name', 'gpa', 'major', 'graduation_year', 'action'])
            ->make(true);
    }

}
