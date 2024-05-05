<?php

namespace App\Http\Services;

use App\Traits\ResponseTrait;
use App\Models\ContactUs;
use Exception;
use Illuminate\Support\Facades\DB;

class ContactUsService
{
    use ResponseTrait;

    public function getAllData()
    {
        $contact = ContactUs::where('tenant_id', getTenantId());
        return datatables($contact)
            ->addIndexColumn()
            ->addColumn('issue', function ($data) {
                return $data->issue?? "N/A";
            })
            ->addColumn('phone', function ($data) {
                return $data->phone?? "N/A";
            })
            ->rawColumns(['issue', 'phone'])
            ->make(true);
    }


    public function store($request)
    {
        DB::beginTransaction();
        try {
            $contactUs = new ContactUs();
            $contactUs->name = $request->name;
            $contactUs->email = $request->email;
            $contactUs->message = $request->message;
            $contactUs->phone =  $request->phone;
            $contactUs->issue = $request->issue;
            $contactUs->tenant_id = getTenantId();
            $contactUs->save();
            DB::commit();
            return back()->with('success', __('Send Successfully'));
        } catch (Exception $e) {
            DB::rollBack();
            $message = getMessage(SOMETHING_WENT_WRONG);
            return back()->with('error', $message);
        }
    }
}
