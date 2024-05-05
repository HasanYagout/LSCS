<?php

namespace App\Http\Services;

use App\Models\Currency;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Support\Facades\DB;

class CurrencyService
{
    use ResponseTrait;

    public function getAllData()
    {
        $currencies = Currency::orderBy('id', 'desc')->where('tenant_id', getTenantId())->select('id', 'currency_code', 'current_currency', 'symbol', 'currency_placement');
        return datatables($currencies)
            ->addIndexColumn()
            ->editColumn('currency_code', function ($data) {
                $currencyCode = $data->currency_code;
                if ($data->current_currency == STATUS_ACTIVE) {
                    $currencyCode = $currencyCode . ' <b>(Current Currency)';
                }
                return $currencyCode;
            })
            ->addColumn('action', function ($data){
                if (auth()->user()->role == USER_ROLE_SUPER_ADMIN) {
                    return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('super_admin.setting.currencies.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('super_admin.setting.currencies.delete', $data->id) . '\', \'commonDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                }else{
                return '<ul class="d-flex align-items-center cg-5 justify-content-center">
                            <li class="d-flex gap-2">
                                <button onclick="getEditModal(\'' . route('admin.setting.currencies.edit', $data->id) . '\'' . ', \'#edit-modal\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                                    <img src="' . asset('assets/images/icon/edit.svg') . '" alt="edit" />
                                </button>
                                <button onclick="deleteItem(\'' . route('admin.setting.currencies.delete', $data->id) . '\', \'commonDataTable\')" class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white" title="'.__('Delete').'">
                                    <img src="' . asset('assets/images/icon/delete-1.svg') . '" alt="delete">
                                </button>
                            </li>
                        </ul>';
                }
            })
            ->rawColumns(['action', 'currency_code'])
            ->make(true);
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $currency = new Currency();
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->tenant_id = getTenantId();
            $currency->save();

            if ($request->current_currency) {
                Currency::where('id', $currency->id)->where('tenant_id', getTenantId())->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('id', '!=', $currency->id)->where('tenant_id', getTenantId())->update(['current_currency' => STATUS_PENDING]);
            }

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
            $currency = Currency::where('tenant_id', getTenantId())->findOrFail($id);
            $currency->currency_code = $request->currency_code;
            $currency->symbol = $request->symbol;
            $currency->currency_placement = $request->currency_placement;
            $currency->save();
            if ($request->current_currency) {
                Currency::where('tenant_id', getTenantId())->where('id', $currency->id)->update(['current_currency' => STATUS_ACTIVE]);
                Currency::where('tenant_id', getTenantId())->where('id', '!=', $currency->id)->update(['current_currency' => STATUS_PENDING]);
            }

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
        return Currency::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function deleteById($id)
    {

        try {
            DB::beginTransaction();
            $currency = Currency::where('tenant_id', getTenantId())->findOrFail($id);
            $currency->delete();
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
