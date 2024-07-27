<?php

namespace App\Http\Services;

use App\Models\Story;
use App\Traits\ResponseTrait;
use App\Models\FileManager;
use Brian2694\Toastr\Facades\Toastr;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class StoryService
{
    use ResponseTrait;



    public function getBySlug($slug)
    {
        return Story::where('slug', $slug)->firstOrFail();
    }

    public function allActiveList($request)
    {
        $query = Story::where('posted_by', Auth::user()->id)->where('status',STATUS_ACTIVE);


        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where('title', 'like', "%{$search}%");
        }


        return datatables($query)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/story'.'/'.$data->thumbnail) . '" alt="Story" class="rounded avatar-xs max-h-35">';
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

    public function getMyStoryList($request)
    {
        $query = Story::where('posted_by', Auth::user()->id);

        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where('title', 'like', "%{$search}%");
        }


        return datatables($query)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/story'.'/'.$data->thumbnail) . '" alt="Story" class="rounded avatar-xs max-h-35">';
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


    public function getAllStoryList($request)
    {

        $query = Story::where('posted_by', Auth::user()->id);


        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where('title', 'like', "%{$search}%");
        }


        return datatables($query)
            ->addIndexColumn()
            ->addColumn('thumbnail', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/story'.'/'.$data->thumbnail) . '" alt="Story" class="rounded avatar-xs max-h-35">';
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
                'posted_by' => Auth::user()->id,
                'title' => $request->title,
                'slug' => $slug,
                'body' => $request->body,
                'thumbnail' => $thumbnail,
                'status' => 0,
            ]);

            DB::commit();
            return response()->json(['success' => true, 'message' => __(CREATED_SUCCESSFULLY)]);
        } catch (Exception $e) {
            dd($e);
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

            $story = Story::where('slug', $oldSlug)->where('posted_by',Auth::user()->id)->firstOrFail();
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
