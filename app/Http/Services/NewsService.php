<?php

namespace App\Http\Services;

use App\Models\News;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsService
{
    use ResponseTrait;

    public function list($request)
    {
        // Base query to get news with author and category
        $query = News::select('news.*', 'news_categories.name as category_name')
            ->with('author')
            ->join('news_categories', 'news.news_category_id', '=', 'news_categories.id')
            ->join('admins', 'news.posted_by', '=', 'admins.id') // Assuming the foreign key in the news table is posted_by
            ->whereIn('news.status', [STATUS_ACTIVE, STATUS_PENDING]);

        // Handle search input
        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $query->where(function($q) use ($search) {
                $q->where('news.title', 'like', "%{$search}%")
                    ->orWhere('news_categories.name', 'like', "%{$search}%")
                    ->orWhere('admins.first_name', 'like', "%{$search}%");
            });
        }

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];

                if ($orderBy == 'category') {
                    $query->orderBy('news_categories.name', $orderDirection);
                }
                else if ($orderBy == 'author') {
                    $query->orderBy('admins.first_name', $orderDirection);
                }
                else {
                    $query->orderBy('news.' . $orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('news.id', 'DESC');
        }

        return datatables($query)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';"  src="' . asset('/public/storage/admin/news') . '/' . $data->image . '" alt="icon" class="max-h-35 rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('title', function ($data) {
                return $data->title;
            })
            ->addColumn('author',function($data){
                return $data->author->first_name . ' ' . $data->author->last_name;
            })
            ->addColumn('category', function ($data) {
                return htmlspecialchars($data->category_name);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == STATUS_ACTIVE) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">' . __('Published') . '</span>';
                } else {
                    return '<span class="zBadge-free">' . __('Deactivate') . '</span>';
                }
            })
            ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <a href="' . route('admin.news.details', $data->slug) . '" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="View">
                        <img src="' . asset('public/assets/images/icon/eye.svg') . '" alt="view">
                    </a>
                    <button onclick="getEditModal(\'' . route('admin.news.info', $data->id) . '\', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="' . __('Edit') . '">
                        <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.news.delete', $data->id) . '\', \'newsDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="' . __('Delete') . '">
                        <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                    </button>
                </li>
            </ul>';
            })
            ->rawColumns(['image', 'status', 'action'])
            ->make(true);
    }






    public function store($request)
    {
        $user = Auth::user();
        $slug = getSlug($request->title);
        $news = new News();
        $news->title = $request->title;
        $news->slug = $slug;
        $news->news_category_id = $request->category_id;
        $news->details = $request->details;
        $news->status = $request->status;
        $news->posted_by = $user->user_id;

        if ($request->hasFile('image')) {
            // Get the original file extension
            $extension = $request->image->getClientOriginalExtension();

            // Generate the new file name
            $date = Carbon::now()->format('Ymd');
            $slug = Str::slug($request->title);
            $randomNumber = rand(1000, 9999);
            $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";
            // Save the file to the specified directory
            $request->image->storeAs('public/admin/news', $newFileName);


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

            if (News::where('slug', getSlug($request->title))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }

            $news = News::where('id', $id)->firstOrFail();
            $previousImage = $news->image; // Store the previous image path

            $news->title = $request->title;
            $news->slug = $slug;
            $news->news_category_id = $request->category_id;
            $news->details = $request->details;
            $news->status = $request->status;

            if ($request->hasFile('image')) {
                // Delete the previous image if it exists
                if ($previousImage) {
                    Storage::delete('public/admin/news/' . $previousImage);
                }

                // Get the original file extension
                $extension = $request->image->getClientOriginalExtension();

                // Generate the new file name
                $date = Carbon::now()->format('Ymd');
                $slug = Str::slug($request->title);
                $randomNumber = rand(1000, 9999);
                $newFileName = "{$date}_{$slug}_{$randomNumber}.{$extension}";

                // Save the file to the specified directory
                $request->image->storeAs('public/admin/news', $newFileName);

                // Get the file URL or ID depending on your file manager
                $news->image = $newFileName; // Assuming you want to save the file path
            }
            $news->save();
            DB::commit();

            session()->flash('success', 'News updated successfully.');

            // Redirect to a specific route or action
            return Redirect::route('admin.news.index');
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
            Storage::delete('public/admin/news/' . $news->image);
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
