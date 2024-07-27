<?php

namespace App\Http\Services;



use App\Models\Admin;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminService
{
    use ResponseTrait;

    public function deleteById($id)
    {
        try {
            DB::beginTransaction();

            $admin = Admin::findOrFail($id);

            // If you want to keep track of the deleted image, you may skip the deletion or move the file to a deleted folder
            if ($admin->image) {
                Storage::delete('public/admin/image/' . $admin->image);
            }

            $admin->delete();  // This will perform a soft delete

            DB::commit();

            $message = getMessage(DELETED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (\Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }


    public function getById($id)
    {

        return Admin::where('user_id', $id)->firstOrFail();
    }

    public function list( $request)
    {
        $allAdmins = User::with('role','admin')
            ->where(function ($query){
                $query->where('role_id', 1)
                    ->orWhere('role_id', 4);
            })
            ->where(function ($query) {
                $query->where('status', 1)
                    ->orWhere('status', 0);
            });
        // Handle search
        if ($request->has('search') && $request->search['value'] != '') {
            $search = $request->search['value'];
            $allAdmins->where('first_name', 'like', "%{$search}%")
            ->where('last_name', 'like', "%{$search}%")
            ->orWhere('email', 'like', "%{$search}%");
        }

        // Handle ordering
        if ($request->has('order') && $request->has('columns')) {
            foreach ($request->order as $order) {
                $orderBy = $request->columns[$order['column']]['data'];
                $orderDirection = $order['dir'];
                if (in_array($orderBy, ['email', 'first_name', 'mobile', 'last_name', 'role.name'])) {
                    if ($orderBy == 'role.name') {
                        $allAdmins->join('roles', 'admins.role_id', '=', 'roles.id')
                            ->orderBy('roles.name', $orderDirection);
                    } else {
                        $allAdmins->orderBy($orderBy, $orderDirection);
                    }
                }
            }
        } else {
            $allAdmins->orderBy('admins.id', 'desc');
        }

        return datatables($allAdmins)
            ->addIndexColumn()
            ->addColumn('image', function ($data) {
                return '<img onerror="this.onerror=null; this.src=\'' . asset('public/assets/images/no-image.jpg') . '\';" src="' . asset('public/storage/admin/image' . $data->image) . '" alt="Admin Image" class="rounded avatar-xs max-h-35">';
            })
            ->addColumn('first_name', function ($data) {
                return $data->admin->first_name;
            })
            ->addColumn('last_name', function ($data) {
                return $data->admin->last_name;
            })
            ->addColumn('email', function ($data) {
                return $data->email;
            })
            ->addColumn('type', function ($data) {
                return '<p class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16' . ($data->role_id == '1' ? ' text-0fa958 bg-0fa958-10' : ' text-f5b40a bg-f5b40a-10') . '">' . $data->role->name . '</p>';
            })
            ->addColumn('reset_password', function ($data) {
                return '<button onclick="resetPassword(\''. route('admin.reset-password', ['id' => $data->id]) . '\', ' . $data->id . ')" class="bg-secondary-color btn h-28 btn-sm text-white">Reset</button>';
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
                            <button onclick="getEditModal(\'' . route('admin.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo" title="'.__('Edit').'">
                                <img src="' . asset('public/assets/images/icon/edit.svg') . '" alt="edit" />
                            </button>

                            <button onclick="deleteItem(\'' . route('admin.delete', $data->id) . '\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                <img src="' . asset('public/assets/images/icon/delete-1.svg') . '" alt="delete">
                            </button>
                        </li>
                    </ul>';
            })
            ->rawColumns(['action', 'reset_password', 'status', 'type', 'image'])
            ->make(true);
    }




}
