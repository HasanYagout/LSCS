<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GatewayRequest;
use App\Http\Services\GatewayService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class GatewayController extends Controller
{
    use ResponseTrait;

    public $gatewayService;

    public function __construct()
    {
        $this->gatewayService = new GatewayService;
    }

    public function index(Request $request)
    {
        $data['title'] = __('Gateway');
        $data['showManageApplicationSetting'] = 'show';
        $data['activeGatewaySetting'] = 'active-color-one';
        $data['gateways'] = $this->gatewayService->getAll();
        return view('admin.setting.gateway', $data);
    }

    public function store(GatewayRequest $request)
    {
        return $this->gatewayService->store($request);
    }

    public function getInfo(Request $request)
    {
        return $this->gatewayService->getCurrenciesByGatewayId($request->id);
    }

    public function getCurrencyByGateway(Request $request)
    {
        $data = $this->gatewayService->getCurrencyByGatewayId($request->id);
        return $this->success($data);
    }
}
