<?php

namespace App\Http\Services;

use App\Models\Notice;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class NoticeService
{
    use ResponseTrait;

    public function list()
    {
        $features = Notice::where('tenant_id', getTenantId())->with(['category'])->orderBy('id','DESC');
        return datatables($features)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img src="' . getFileUrl($data->image) . '" alt="icon" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('user', function ($data) {
                return htmlspecialchars($data->user->name);
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

            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.notices.info', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                            <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                        <button onclick="deleteItem(\'' . route('admin.notices.delete', $data->id) . '\', \'noticeDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                            <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                        </button>
                    </li>
                </ul>';
            })


            ->rawColumns(['status', 'image', 'action', 'name', 'notice_category_id'])
            ->make(true);
    }

    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (Notice::where('slug', getSlug($request->title))->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $notice = new Notice();
            $notice->title = $request->title;
            $notice->slug = $slug;
            $notice->notice_category_id = $request->category_id;
            $notice->details = $request->details;
            $notice->status = $request->status;
            $notice->tenant_id = getTenantId();
            $notice->created_by = auth()->id();

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('notice', $request->image);
                $notice->image = $uploaded->id;
            }

            $notice->save();

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
            if (Notice::where('slug', getSlug($request->title))->where('id', '!=', $id)->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $notice = Notice::where('tenant_id', getTenantId())->where('id', $id)->firstOrFail();
            $notice->title = $request->title;
            $notice->slug = $slug;
            $notice->notice_category_id = $request->category_id;
            $notice->details = $request->details;
            $notice->status = $request->status;

            if ($request->hasFile('image')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('notice', $request->image);
                $notice->image = $uploaded->id;
            }

            $notice->save();

            DB::commit();
            return $this->success([], getMessage(UPDATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }

    public function getById($id)
    {
        return Notice::where('tenant_id', getTenantId())->with(['category'])->where('id', $id)->firstOrFail();
    }

    public function getNoticeBySlug($slug)
    {
        return Notice::where('tenant_id', getTenantId())->where('slug', $slug)->with(['category'])->firstOrFail();
    }

    public function getFirst()
    {
        return Notice::where('tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->with(['category'])->first();
    }

    public function deleteById($id)
    {
        try {
            $notice = Notice::where('id', $id)->firstOrFail();
            $notice->delete();
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
            return Notice::where('tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->where('id', '!=', $first)->with(['category'])->paginate(6);
        }else{
            return Notice::where('tenant_id', getTenantId())->where('status', STATUS_ACTIVE)->limit($limit)->with(['category'])->get();
        }
    }
}
