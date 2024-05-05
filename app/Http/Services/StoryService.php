<?php

namespace App\Http\Services;

use App\Models\Story;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use Exception;
use Illuminate\Support\Facades\DB;

class StoryService
{
    use ResponseTrait;

    public function getById($id)
    {
        return Story::where('tenant_id', getTenantId())->firstOrFail($id);
    }

    public function getBySlug($slug)
    {
        return Story::where('slug', $slug)->where('tenant_id', getTenantId())->firstOrFail();
    }

    public function allPendingList()
    {
        $pendingStory = Story::orderBy('id', 'desc')->where('status', STATUS_PENDING)->where('tenant_id', getTenantId());
        return datatables($pendingStory)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . getFileUrl($data->thumbnail) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('status', function ($data) {
                return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">' . __("Pending") . '</p>';
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('stories.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Edit') . '">
                            <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('stories.delete', $data->slug) . '\', \'storyDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'thumbnail', 'action'])
            ->make(true);
    }

    public function getMyStoryList()
    {
        $features = Story::where('user_id', auth()->id())->where('tenant_id', getTenantId())->orderBy('id', 'desc')->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . getFileUrl($data->thumbnail) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('status', function ($data) {
                if($data->status == STATUS_ACTIVE){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">' . __("Published") . '</p>';
                }else{
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">' . __("Pending") . '</p>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('stories.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Edit') . '">
                            <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('stories.delete', $data->slug) . '\', \'storyDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'thumbnail', 'action'])
            ->make(true);
    }


    public function getAllStoryList()
    {
        $features = Story::where('status', JOB_STATUS_APPROVED)->orderBy('id', 'desc')->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) {
                return '<img src="' . getFileUrl($data->company_logo) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('title', function ($data) {
                return htmlspecialchars($data->title);
            })
            ->addColumn('salary', function ($data) {
                return htmlspecialchars($data->salary);
            })
            ->addColumn('application_deadline', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('action', function ($data) {
                if (auth()->user()->role == USER_ROLE_ADMIN) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <button onclick="getEditModal(\'' . route('jobPost.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Edit') . '">
                                        <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                    </button>
                                    <button onclick="deleteItem(\'' . route('jobPost.delete', $data->slug) . '\', \'jobPostAlldataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                                        <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                    </button>
                                    <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                                </li>
                            </ul>';
                } else {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                    </li>
                </ul>';
                }

            })
            ->rawColumns(['company_logo', 'action', 'title', 'salary', 'application_deadline'])
            ->make(true);
    }


    public function getPendingStoryList()
    {
        $features = Story::where('status', JOB_STATUS_PENDING)->where('tenant_id', getTenantId())->orderBy('id', 'desc')->get();
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('company_logo', function ($data) {
                return '<img src="' . getFileUrl($data->company_logo) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('title', function ($data) {
                return htmlspecialchars($data->title);
            })
            ->addColumn('salary', function ($data) {
                return htmlspecialchars($data->salary);
            })
            ->addColumn('application_deadline', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->application_deadline)->format('l, F j, Y');
            })
            ->addColumn('status', function ($data) {
                if ($data->status == JOB_STATUS_PENDING) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">Pending</p>';
                } else if ($data->status == JOB_STATUS_APPROVED) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Approved</p>';
                } else if ($data->status == JOB_STATUS_CANCELED) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-ea4335 bg-ea4335-10">Canceled</p>';
                }
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.jobPost.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Edit') . '">
                            <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.jobPost.delete', $data->slug) . '\', \'jobPostPendingdataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('assets/images/icon/eye.svg') . '" alt="" /></a>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'company_logo', 'action', 'title', 'salary', 'application_deadline'])
            ->make(true);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (Story::where('slug', getSlug($request->title))->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $thumbnail = NULL;
            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('stories', $request->thumbnail);
                $thumbnail = $uploaded->id;
            }

            Story::create([
                'user_id' => auth()->id(),
                'title' => $request->title,
                'tenant_id' => getTenantId(),
                'slug' => $slug,
                'body' => $request->body,
                'thumbnail' => $thumbnail,
            ]);

            DB::commit();
            return $this->success([], __("Save successfully wait for approval"));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }


    public function update($oldSlug, $request)
    {
        DB::beginTransaction();
        try {

            if (Story::where('slug', getSlug($request->title))->where('slug', '!=', $oldSlug)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $story = Story::where('slug', $oldSlug)->where('tenant_id', getTenantId())->firstOrFail();
            $story->title = $request->title;
            $story->slug = $slug;
            $story->body = $request->body;
            if ($request->status != NULL) {
                $story->status = $request->status;
            }
            if ($request->hasFile('thumbnail')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('stories', $request->thumbnail);
                $story->thumbnail = $uploaded->id;
            }
            $story->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function deleteBySlug($slug)
    {
        try {
            DB::beginTransaction();
            $jobPost = Story::where('slug', $slug)->firstOrFail();
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

    public function getAll($limit)
    {
        return Story::orderBy('stories.id', 'DESC')->where('tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->paginate($limit);
    }
}
