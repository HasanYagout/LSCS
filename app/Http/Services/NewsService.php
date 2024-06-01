<?php

namespace App\Http\Services;

use App\Models\News;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class NewsService
{
    use ResponseTrait;

    public function list()
    {
        $news= News::with('author')->orderBy('id','DESC')->get();

        return datatables($news)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . asset('/public/storage/admin/news').'/'.$data->image . '" alt="icon" class="max-h-35 rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('title', function ($data) {

                return $data->title;
            })
            ->addColumn('author', function ($data) {

                return $data->author->first_name;
            })

            ->addColumn('category', function ($data) {
                return htmlspecialchars($data->category->name);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Published').'</span>';
                } else {
                    return '<span class="zBadge-free">'.__('Deactivate').'</span>';
                }
            })
            ->addColumn('action', function ($data){
                if(auth('admin')->user()->role_id == USER_ROLE_ADMIN){
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <a href="'. route('admin.news.details', $data->slug) .'" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View">
                                    <img src="' . asset('assets/images/icon/eye.svg') . '" alt="view">
                                </a>
                                <button onclick="getEditModal(\'' . route('admin.news.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.news.delete', $data->id) . '\', \'newsDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                }else{
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                                <li class="d-flex gap-2">
                                    <a href="'. route('news.details', $data->slug) .'" class="d-block min-w-130 text-decoration-underline fw-600 text-1b1c17">More Details</a>
                                </li>
                            </ul>';
                }
            })
            ->rawColumns(['author','image','status','action'])
            ->make(true);
    }

    public function store($request)
    {
        $slug = getSlug($request->title);
        $news = new News();
        $news->title = $request->title;
        $news->slug = $slug;
        $news->news_category_id = $request->category_id;
        $news->details = $request->details;
        $news->status = $request->status;
        $news->posted_by = auth('admin')->id();

        if ($request->hasFile('image')) {
            // Get the original file extension
            $extension = $request->image->getClientOriginalExtension();

            // Generate the new file name
            $date = Carbon::now()->format('Ymd');
            $slug = Str::slug($request->title);
            $randomNumber = rand(1000, 9999);
            $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
            // Save the file to the specified directory
            $filePath = $request->image->storeAs('public/admin/news', $newFileName);


            // Get the file URL or ID depending on your file manager
            $news->image = $newFileName; // Assuming you want to save the file path
        }

        $news->save();
        session()->flash('success', 'News category created successfully.');

        // Redirect back with a success message
        return redirect()->route('admin.news.index');
    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            if (News::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $news = News::where('id', $id)->where('tenant_id', getTenantId())->firstOrFail();
            $news->title = $request->title;
            $news->slug = $slug;
            $news->news_category_id = $request->category_id;
            $news->details = $request->details;
            $news->status = $request->status;

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('news', $request->image);
                $news->image = $uploaded->id;
            }

            $news->save();
            $news->tags()->sync($request->tag_ids);

            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getById($id)
    {
        return News::with(['category', 'author'])->where('id', $id)->firstOrFail();
    }

    public function getNewsBySlug($slug)
    {
        return News::where('slug', $slug)->with(['category', 'author'])->firstOrFail();
    }

    public function getFirst()
    {
        return News::where('status', STATUS_ACTIVE)->with(['category', 'author'])->first();
    }

    public function deleteById($id)
    {
        try {
            $news = News::where('id', $id)->firstOrFail();
            $news->delete();
            DB::beginTransaction();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getAllActive($limit = NULL)
    {
        $first = $this->getFirst()?->id;
        if(is_null($limit)){
            return News::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->where('id', '!=', $first)->with(['category', 'author'])->paginate(6);
        }else{
            return News::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->limit($limit)->with(['category', 'author'])->get();
        }
    }
}
