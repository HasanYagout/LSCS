<?php


namespace App\Http\Services\Payment;

use App\Models\Gateway;
use App\Models\GatewayCurrency;

class BasePaymentService
{
    public $paymentMethod;
    public $callbackUrl;
    public $currency;
    public $gateway;
    public $gatewayCurrency;
    public $amount;
    public $type;

    public function __construct($method, $object)
    {
        if (isset($object['id'])) {
            $this->callbackUrl = $object['callback_url'] . '?id=' . $object['id'];
        }

        if (isset($object['currency'])) {
            $this->currency = $object['currency'];
        }
        if (isset($object['type'])) {
            $this->type = $object['type'];
        }

        $this->paymentMethod = $method;
        if (request()->route()->getName() == 'admin.subscription.pay' || request()->route()->getName() == 'subscription.payment.verify') {
            $tenantId = NULL;
        }else{
            $tenantId = getTenantId();
        }

        $this->gateway = Gateway::where(['slug' => $this->paymentMethod])->where('tenant_id',  $tenantId)->first();
        $this->gatewayCurrency = GatewayCurrency::where(['gateway_id' => $this->gateway->id, 'currency' => $this->currency])->firstOrFail();

    }

    public function calculateAmount($amount)
    {
        return $this->numberParser($this->gatewayCurrency->conversion_rate) * $this->numberParser($amount);
    }

    public function setAmount($amount)
    {
        $this->amount = $this->calculateAmount($amount);
    }

    function numberParser($value)
    {
        return (float) str_replace(',', '', number_format(($value), 2));
    }
}
