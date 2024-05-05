<?php

namespace App\Http\Services;

use App\Models\Department;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class DepartmentService
{
    use ResponseTrait;

    public function getAllData()
    {
        $departments = Department::where('tenant_id', getTenantId())->orderBy('id', 'desc');
        return datatables($departments)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <button onclick="getEditModal(\'' . route('admin.setting.departments.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                        <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.departments.delete', $data->id) . '\', \'departmentDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
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
        DB::beginTransaction();
        try {
            $department = new Department();
            $department->name = $request->name;
            $department->short_name = $request->short_name;
            $department->tenant_id = getTenantId();
            $department->save();

            DB::commit();

            $message = getMessage(CREATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }

    public function update($request, $id)
    {
        DB::beginTransaction();
        try {
            $department = Department::where('tenant_id', getTenantId())->findOrfail($id);
            $department->name = $request->name;
            $department->short_name = $request->short_name;
            $department->save();

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
        return Department::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $department = Department::findOrFail($id);
            if(count($department->alumni) != 0){
                return $this->error([], __('This department is already used'));
            }
            $department->delete();
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
