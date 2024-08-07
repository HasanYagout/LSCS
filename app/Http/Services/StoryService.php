<?php

namespace App\Http\Services;

use App\Models\Story;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoryService
{
    use ResponseTrait;

    public function getById($id)
    {
        return Story::where('tenant_id', getTenantId())->firstOrFail($id);
    }

    public function getBySlug($slug)
    {
        return Story::where('slug', $slug)->firstOrFail();
    }

    public function allActiveList()
    {
        $pendingStory = Story::orderBy('id', 'desc')->where('status', STATUS_ACTIVE);
        return datatables($pendingStory)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . asset('public/storage/admin/story').'/'.$data->thumbnail . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.stories.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Edit') . '">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.stories.delete', $data->slug) . '\', \'storyDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns([ 'thumbnail', 'action'])
            ->make(true);
    }

    public function getMyStoryList()
    {
        $features = Story::where('posted_by', auth('admin')->id())->orderBy('id', 'desc')->get();

        return datatables($features)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . asset('public/storage/admin/story'.'/'.$data->thumbnail) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('status', function ($data) {
                if($data->status == STATUS_ACTIVE){
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">' . __("Published") . '</p>';
                }else{
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">' . __("Pending") . '</p>';
                }
            })

            ->rawColumns(['status', 'thumbnail'])
            ->make(true);
    }


    public function getAllStoryList()
    {

        $features = Story::where('posted_by', auth('admin')->id())->orderBy('id', 'desc')->get();

        return datatables($features)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img src="' . asset('public/storage/admin/story'.'/'.$data->thumbnail) . '" alt="icon" class="rounded avatar-xs max-h-35">';
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
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.stories.info', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Edit') . '">
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.stories.delete', $data->slug) . '\', \'storyDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })
            ->rawColumns(['status', 'thumbnail', 'action'])
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
                            <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.jobPost.delete', $data->slug) . '\', \'jobPostPendingdataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                            <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                        <a href="' . route('jobPost.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View"><img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="" /></a>
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
            // Generate a unique slug
            $slug = getSlug($request->title);
            if (Story::where('slug', $slug)->count() > 0) {
                $slug = $slug . '-' . rand(100000, 999999);
            }
            $thumbnail = NULL;
            if ($request->hasFile('thumbnail')) {
                $file = $request->file('thumbnail');
                $date = now()->format('Ymd'); // Get current date in YYYYMMDD format
                $randomSlug = Str::random(10); // Generate a random string of 10 characters
                $randomNumber = rand(100000, 999999); // Generate a random number

                $fileName = $date . '_' . $randomSlug . '_' . $randomNumber . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('storage/admin/story'), $fileName); // Save the file to the specified path

                $thumbnail = $fileName; // Save only the file name to the database
            }

            Story::create([
                'posted_by' => auth('admin')->id(),
                'title' => $request->title,
                'slug' => $slug,
                'body' => $request->body,
                'thumbnail' => $thumbnail,
                'status' => 0,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => __(CREATED_SUCCESSFULLY)]);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }


    public function update($oldSlug, $request)
    {
        DB::beginTransaction();
        try {

            if (Story::where('slug', getSlug($request->title))->where('slug', '!=', $oldSlug)->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $story = Story::where('slug', $oldSlug)->where('posted_by',auth('admin')->id())->firstOrFail();
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
        return Story::orderBy('stories.id', 'DESC')->where('status', STATUS_ACTIVE)->paginate($limit);
    }
}
