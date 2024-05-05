<?php

namespace App\Http\Services;

use App\Models\NewsCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NewsCategoryService
{
    use ResponseTrait;

    public function list()
    {
        $newsCategory = NewsCategory::where('tenant_id', getTenantId())->orderBy('id','DESC');
        return datatables($newsCategory)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<span class="zBadge-free">Active</span>';
                } else {
                    return '<span class="zBadge-free">Deactivate</span>';
                }
            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.news.categories.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.news.categories.delete', $data->id) . '\', \'newsCategoryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action', 'status'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (NewsCategory::where('slug', getSlug($request->name))->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }
            $newsCategory = new NewsCategory();
            $newsCategory->name = $request->name;
            $newsCategory->slug = $slug;
            $newsCategory->status = $request->status;
            $newsCategory->tenant_id = getTenantId();
            $newsCategory->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
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

            $newsCategory = NewsCategory::where('tenant_id', getTenantId())->findOrFail($id);
            $newsCategory->name = $request->name;
            $newsCategory->slug = $slug;
            $newsCategory->status = $request->status;
            $newsCategory->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return NewsCategory::where('tenant_id', getTenantId())->findOrFail($id);
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
