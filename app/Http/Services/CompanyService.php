<?php

namespace App\Http\Services;

use App\Models\Company;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public function updateStatus($request,$id)
    {
        $company = Company::with('jobs')->find($id);
        if (!$company) {
            return response()->json(['success' => false, 'message' => 'Company not found.']);
        }

        // Start transaction to ensure data integrity
        DB::beginTransaction();
        try {
            $company->status = $request->status;
            $company->save();

            // Check if the status is 0 and update all associated jobs
            if ($request->status == 0) {
                foreach ($company->jobs as $job) {
                    $job->status = 0;
                    $job->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true, 'message' => 'Status updated successfully, including all associated jobs.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Failed to update status: ' . $e->getMessage()]);
        }
    }
}
