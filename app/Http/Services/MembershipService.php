<?php

namespace App\Http\Services;

use Exception;
use App\Models\Membership;
use App\Models\FileManager;
use App\Traits\ResponseTrait;
use App\Models\UserMembershipPlan;
use Illuminate\Support\Facades\DB;

class MembershipService
{
    use ResponseTrait;

    public function list()
    {
        $membership = Membership::where('tenant_id', getTenantId())->orderBy('id','DESC');
        return datatables($membership)
            ->addIndexColumn()
            ->addColumn('badge', function ($data) {
                return '<img src="' . getFileUrl($data->badge) . '" alt="icon" class="max-h-35 rounded avatar-xs tbl-user-image">';
            })
            ->addColumn('duration', function ($data) {
                return '<span>'. $data->duration .'  '. htmlspecialchars(getDurationType($data->duration_type )).'</span>';
            })
            ->addColumn('price', function ($data) {
                return showPrice($data->price);
            })
            ->addColumn('status', function ($data) {
                if ($data->status == 1) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">Active</p>';
                } else {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">Deactivate</p>';
                }
            })
            ->addColumn('action', function ($data){
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.membership.edit', $data->slug) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.membership.delete', $data->id) . '\', \'membershipDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
            })
            ->rawColumns(['status', 'action', 'badge', 'duration', 'price'])
            ->make(true);
    }


    public function memberList()
    {
        $membership =UserMembershipPlan::where('tenant_id', getTenantId())->with('users')->with('membership')->orderBy('id','DESC');

        return datatables($membership)
            ->addIndexColumn()

            ->addColumn('name', function ($data) {
                return $data->users->name;
            })
            ->addColumn('planName', function ($data) {
                return $data->membership->title;
            })
            ->addColumn('created_at', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('j F Y');
            })
            ->addColumn('expired_date', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->expired_date)->format('j F Y');
            })
            ->addColumn('status', function ($data) {
                if ($data->expired_date >= now() && $data->status == STATUS_ACTIVE) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">'.__('Active').'</p>';
                }else if ($data->status == STATUS_REJECT) {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">'.__('Canceled').'</p>';
                } else {
                    return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">'.__('Expired').'</p>';
                }
            })
            ->rawColumns(['status',])
            ->make(true);
    }


    public function store($request)
    {
        try {
            DB::beginTransaction();
            if (Membership::where('slug', getSlug($request->title))->withTrashed()->count() > 0) {
                $slug = getSlug($request->title) . '-' . rand(100000, 999999);
            } else {
                $slug = getSlug($request->title);
            }
            $membership = new Membership();
            $membership->title = $request->title;
            $membership->slug = $slug;
            $membership->duration_type = $request->duration_type;
            $membership->duration = $request->duration;
            $membership->status = $request->status;
            $membership->price = $request->price;
            $membership->tenant_id = getTenantId();
            if ($request->hasFile('badge')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('membership', $request->badge);
                $membership->badge = $uploaded->id;
            }
            $membership->save();
            DB::commit();
            return $this->success([], getMessage(CREATED_SUCCESSFULLY));
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error([], getMessage(SOMETHING_WENT_WRONG));
        }
    }


    public function update($currenSlug, $request)
    {
        DB::beginTransaction();
        if (Membership::where('slug', getSlug($request->title))->where('slug', '!=', $currenSlug)->withTrashed()->count() > 0) {
            $slug = getSlug($request->title) . '-' . rand(100000, 999999);
        } else {
            $slug = getSlug($request->title);
        }

        try {
            $membership = Membership::where('slug', $currenSlug)->where('tenant_id', getTenantId())->first();

            if(is_null($membership)){
                return $this->error([], __('No Data Found'));
            }

            $membership->title = $request->title;
            $membership->slug = $slug;
            $membership->duration_type = $request->duration_type;
            $membership->duration = $request->duration;
            $membership->status = $request->status;
            $membership->price = $request->price;

            if ($request->hasFile('badge')) {
                $new_file = new FileManager();
                $uploaded = $new_file->upload('badge', $request->badge);
                $membership->badge = $uploaded->id;
            }

            $membership->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();
            $member = Membership::where('id', $id)->where('tenant_id', getTenantId())->first();

            if(count($member->userMembershipPlans) != 0){
                return $this->error([], __('This Membership is already used'));
            }

            $member->delete();
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
