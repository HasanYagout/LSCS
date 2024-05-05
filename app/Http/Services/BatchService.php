<?php

namespace App\Http\Services;

use App\Models\Batch;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class BatchService
{
    use ResponseTrait;

    public function getAllData()
    {
        $batches = Batch::where('tenant_id', getTenantId())->orderBy('id', 'DESC');
        return datatables($batches)
            ->addIndexColumn()
            ->addColumn('action', function ($data){
                return '<ul class="align-items-center cg-5 d-flex justify-content-end">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.setting.batches.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.setting.batches.delete', $data->id) . '\', \'batchDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
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
            $batch = new Batch();
            $batch->name = $request->name;
            $batch->tenant_id = getTenantId();
            $batch->save();

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
            $batch = Batch::where('tenant_id', getTenantId())->findOrfail($id);
            $batch->name = $request->name;
            $batch->save();

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
        return Batch::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $batch = Batch::findOrFail($id);
            if(count($batch->alumni) != 0){
                return $this->error([], __('This batch is already used'));
            }
            $batch->delete();
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
