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
    public function details($company,$slug)
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

    public function applied(Request $request,$id)
    {

        if ($request->ajax()) {
            $applied = AppliedJobs::with(['alumni', 'cv'])
                ->where('company_id', auth('company')->id())
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
                })
                ->orderBy('id', 'desc')
                ->get();

            return datatables($applied)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return '<a class="text-707070 text-decoration-underline" href="' . route('company.jobs.alumni-profile', ['id' => $data->alumni->student_id]) . '">' . $data->alumni->first_name . ' ' . $data->alumni->last_name . '</a>';
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
    public function alumniProfile($id)
    {

        $data['activeProfile'] = 'active';
        $data['showProfileManagement'] = 'show';
        $data['user'] = Alumni::where('student_id', $id)->first();
        return view('alumni.profile', $data);
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
