<?php

namespace App\Http\Services;

use App\Models\NoticeCategory;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NoticeCategoryService
{
    use ResponseTrait;

    public function list($request)
    {
        $query = NoticeCategory::query();

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                if (in_array($orderBy, ['name', 'status'])) {
                    $query->orderBy($orderBy, $orderDirection);
                }
            }
        } else {
            $query->orderBy('id', 'DESC');
        }
        return datatables($query)
            ->addIndexColumn()
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Active').'</p>';
                } else {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">'.__('InActive').'</p>';
                }
            })

            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.notices.categories.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.notices.categories.delete', $data->id) . '\', \'noticeCategoryDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
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
        try {
            DB::beginTransaction();
            if (NoticeCategory::where('slug', getSlug($request->name))->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }
            $noticeCategory = new NoticeCategory();
            $noticeCategory->name = $request->name;
            $noticeCategory->slug = $slug;
            $noticeCategory->status = $request->status;
            $noticeCategory->save();
            DB::commit();
            session()->flash('success', 'Notice Category Added Successfully');
            return redirect()->route('admin.notices.categories.index');
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function update($id, $request)
    {
        DB::beginTransaction();
        try {

            if (NoticeCategory::where('slug', getSlug($request->name))->where('id', '!=', $id)->count() > 0) {
                $slug = getSlug($request->name) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->name);
            }

            $noticeCategory = NoticeCategory::findOrFail($id);
            $noticeCategory->name = $request->name;
            $noticeCategory->slug = $slug;
            $noticeCategory->status = $request->status;
            $noticeCategory->save();
            DB::commit();
            session()->flash('success', 'Notice updated successfully.');
            return redirect()->route('admin.notices.categories.index');
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function getById($id)
    {
        return NoticeCategory::findOrFail($id);
    }

    public function activeCategory()
    {
        return NoticeCategory::where('status', STATUS_ACTIVE)->get();
    }

    public function NoticeCategory()
    {
        return NoticeCategory::join('notice', 'notice.notice_category_id', 'notice_categories.id')
        ->where('notice.tenant_id', getTenantId())
        ->where('notice.status', STATUS_ACTIVE)
        ->groupBy('notice_categories.id')
        ->groupBy('notice_categories.name')
        ->select('notice_categories.name', 'notice_categories.id')->get();
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $category = NoticeCategory::where('id', $id)->firstOrFail();
            if(count($category->notice) != 0){
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
