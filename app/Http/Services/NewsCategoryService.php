<?php

namespace App\Http\Services;

use App\Models\NewsCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NewsCategoryService
{
    use ResponseTrait;

    public function list($request)
    {
        $newsCategory = NewsCategory::query();

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                if (in_array($orderBy, ['name', 'status'])) {
                    $newsCategory->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $newsCategory->orderBy('id', 'DESC');
        }

        return datatables($newsCategory)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Active</span>';
                } else {
                    return '<span class="zBadge-free">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                        <li class="d-flex gap-2">
                            <button onclick="getEditModal(\'' . route('admin.news.categories.info', $data->id) . '\', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                            </button>
                            <button onclick="deleteItem(\'' . route('admin.news.categories.delete', $data->id) . '\', \'newsCategoryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                            </button>
                        </li>
                    </ul>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }


    public function store($request)
    {
        $user = Auth::user();

        // Generate the slug
        $slug = getSlug($request->name);

        // Create and save the news category
        $newsCategory = new NewsCategory();
        $newsCategory->name = $request->name;
        $newsCategory->slug = $slug;
        $newsCategory->posted_by = $user->id;
        $newsCategory->status = $request->status;
        $newsCategory->save();
        return $newsCategory;

    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {
            if (NewsCategory::where('slug', getSlug($request->name))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $newsCategory = NewsCategory::findOrFail($id);
            $newsCategory->name = $request->name;
            $newsCategory->slug = $slug;
            $newsCategory->status = $request->status;
            $newsCategory->save();

            DB::commit();

            return $newsCategory;
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
    public function getById($id)
    {
        return NewsCategory::findOrFail($id);
    }

    public function activeCategory()
    {
        return NewsCategory::where('status', STATUS_ACTIVE)->get();
    }

    public function NewsCategory()
    {
        return NewsCategory::join('news', 'news.news_category_id', 'news_categories.id')
        ->where('news.status', STATUS_ACTIVE)
        ->where('news.tenant_id', getTenantId())
        ->groupBy('news_categories.id')
        ->groupBy('news_categories.name')
        ->select('news_categories.name', 'news_categories.id')->get();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $category = NewsCategory::where('id', $id)->firstOrFail();
            if(count($category->news) != 0){
                return $this->error([], __('This category is already used'));
            }
            $category->delete();
            DB::commit();
            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
