<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\BlogTag;
use App\Models\BusinessHours;
use App\Models\EmailTemplate;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PragmaRX\Google2FALaravel\Support\Response;

class EmailTemplateController extends Controller
{
    use ResponseTrait;

    public function emailTemplate(Request $request)
    {
        if ($request->ajax()) {
            $temp = EmailTemplate::all();
            return datatables($temp)
                ->addIndexColumn()
                ->addColumn('body', function ($data) {
                    return $data->body;
                })
                ->addColumn('action', function ($data) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                    <li class="d-flex gap-2">
                        <button onclick="getEditModal(\'' . route('admin.setting.email-edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                            <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                        </button>
                    </li>
                </ul>';
                })
                ->rawColumns(['action','body'])
                ->make(true);
        }
        $data['title'] = __('Email Template');
        $data['showManageApplicationSetting'] = 'show';
        $data['activeEmailSetting'] = 'active-color-one';
        return view('admin.setting.email_temp.email-temp', $data);
    }

    public function emailTempEdit($id)
    {

        $data['template'] = EmailTemplate::findOrFail($id);
        return view('admin.setting.email_temp.edit-form', $data);
    }

    public function emailTempUpdate(Request $request, $id){
        try {
            DB::beginTransaction();
            $tempObj = EmailTemplate::findOrFail($id);
            $tempObj->subject = $request->subject;
            $tempObj->body = $request->body;
            $tempObj->save();
            DB::commit();
            $message = getMessage(UPDATED_SUCCESSFULLY);
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([], $message);
        }
    }
}
