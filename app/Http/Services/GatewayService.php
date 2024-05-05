<?php

namespace App\Http\Services;

use App\Models\Bank;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\DB;

class GatewayService
{
    use ResponseTrait;

    public function getAll()
    {
        return Gateway::where('tenant_id', getTenantId())->get();

    }

    public function getActiveAll()
    {
        return Gateway::where('tenant_id', getTenantId())->where('status', ACTIVE)->get();
    }

    public function getActiveBanks()
    {
        return Bank::where('tenant_id', getTenantId())->where('status', ACTIVE)->get();
    }

    public function getInfo($id)
    {
        return Gateway::where('tenant_id', getTenantId())->findOrFail($id);
    }

    public function getCurrenciesByGatewayId($id)
    {

        $data['gateway'] = $this->getInfo($id);
        if ($data['gateway']->slug == 'bank') {
            $data['banks'] = $this->banks();
        }
        $data['image'] = $data['gateway']->icon;
        $currencies = GatewayCurrency::where('gateway_id', $id)->get();
        foreach ($currencies as $currency) {
            $currency->symbol;
        }
        $data['currencies'] = $currencies;
        return $this->success($data);
    }

    public function banks()
    {
        return Bank::where('tenant_id', getTenantId())->get();
    }

    public function store($request)
    {
        DB::beginTransaction();
        try {
            $id = $request->get('id', '');
            if ($id != '') {
                $gateway = Gateway::where('tenant_id', getTenantId())->findOrFail($request->id);
            } else {
                $gateway = new Gateway();
            }
            if ($gateway->slug == 'bank') {
                $bankIds = [];
                for ($i = 0; $i < count($request->bank['name']); $i++) {
                    $bank = Bank::where('tenant_id', getTenantId())->updateOrCreate([
                        'id' => $request->bank['id'][$i],
                        'tenant_id' => getTenantId(),
                    ], [
                        'tenant_id' => getTenantId(),
                        'gateway_id' => $gateway->id,
                        'name' => $request->bank['name'][$i],
                        'details' => $request->bank['details'][$i],
                        'status' => $request->bank['status'][$i],
                    ]);
                    array_push($bankIds, $bank->id);
                }
                Bank::where('tenant_id', getTenantId())->whereNotIn('id', $bankIds)->delete();
            } else {
                $gateway->mode = $request->mode;
                $gateway->url = $request->url;
                $gateway->key = $request->key;
                $gateway->secret = $request->secret;
            }
            $gateway->status = $request->status;
            $gateway->save();

            $gatewayCurrencyIds = [];
            foreach ($request->currency as $key => $currency) {
                $gatewayCurrency =   GatewayCurrency::updateOrCreate([
                    'id' => $request->currency_id[$key]
                ], [
                    'gateway_id' => $gateway->id,
                    'currency' => $currency,
                    'conversion_rate' => $request->conversion_rate[$key],
                ]);
                array_push($gatewayCurrencyIds, $gatewayCurrency->id);
            }
            GatewayCurrency::whereNotIn('id', $gatewayCurrencyIds)->where('gateway_id', $gateway->id)->delete();

            DB::commit();
            $message = $request->id ? UPDATED_SUCCESSFULLY : CREATED_SUCCESSFULLY;
            return $this->success([], $message);
        } catch (Exception $e) {
            DB::rollBack();
            $message = getErrorMessage($e, $e->getMessage());
            return $this->error([],  $message);
        }
    }

    public function getCurrencyByGatewayId($id)
    {
        $currencies = GatewayCurrency::where('gateway_id', $id)->get();
        foreach ($currencies as $currency) {
            $currency->symbol;
        }
        return $currencies;
    }
}
