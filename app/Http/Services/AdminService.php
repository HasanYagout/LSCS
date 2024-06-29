<?php

namespace App\Http\Services;


use App\Models\Admin;
use App\Models\Alumni;
use App\Models\AppliedJobs;
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
            $admin = Admin::where('id', $id)->firstOrFail();
            Storage::delete('public/admin/image/' . $admin->image);
            $admin->delete();
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

    public function getById($id)
    {
        return Admin::where('id', $id)->firstOrFail();
    }
}
