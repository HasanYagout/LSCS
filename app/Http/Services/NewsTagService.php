<?php

namespace App\Http\Services;

use App\Models\NewsTag;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NewsTagService
{
    use ResponseTrait;

    public function list()
    {
        $newsTags = NewsTag::where('tenant_id', getTenantId())->orderBy('id','DESC');
        return datatables($newsTags)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.news.tags.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'"htmlspecialchars>
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.news.tags.delete', $data->id) . '\', \'newsTagDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (NewsTag::where('slug', getSlug($request->name))->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $newsTags = new NewsTag();
            $newsTags->name = $request->name;
            $newsTags->slug = $slug;
            $newsTags->tenant_id = getTenantId();
            $newsTags->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }

    }

    public function update($id, $request)
    {
        try {
            DB::beginTransaction();
            if (NewsTag::where('slug', getSlug($request->name))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }
            $newsTags = NewsTag::where('tenant_id', getTenantId())->findOrFail($id);
            $newsTags->name = $request->name;
            $newsTags->slug = $slug;
            $newsTags->save();
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
        return NewsTag::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function activeTag()
    {
        return NewsTag::where('tenant_id', getTenantId())->get();
    }

    public function deleteById($id)
    {
        try {
            $newsTag = NewsTag::where('id', $id)->firstOrFail();
            if(count($newsTag->news) != 0){
                return $this->error([], __('This tag is already used'));
            }
            $newsTag->delete();
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
}
