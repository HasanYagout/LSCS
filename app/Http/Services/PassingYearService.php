<?php

namespace App\Http\Services;

use App\Models\PassingYear;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class PassingYearService
{
    use ResponseTrait;

    public function getAllData()
    {
        $passingYears = PassingYear::where('tenant_id', getTenantId())->orderBy('id', 'desc');
        return datatables($passingYears)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                <li class="d-flex gap-2">
                    <button onclick="getEditModal(\'' . route('admin.setting.passing_years.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                        <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                    </button>
                    <button onclick="deleteItem(\'' . route('admin.setting.passing_years.delete', $data->id) . '\', \'passingYearDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
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
            $passingYear = new PassingYear();
            $passingYear->name = $request->passing_year;
            $passingYear->tenant_id = getTenantId();
            $passingYear->save();

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
            $passingYear = PassingYear::findOrfail($id);
            PassingYear::where('tenant_id', getTenantId())->where('id','=',$id)->update(['name'=>$request->passing_year]);
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
        return PassingYear::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $passingYear = PassingYear::findOrFail($id);
            if(isset($passingYear->alumni) && count($passingYear->alumni) != 0){
                return $this->error([], __('This passing year is already used'));
            }
            $passingYear->delete();
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
