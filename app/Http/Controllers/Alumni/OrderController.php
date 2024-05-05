<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrderRequest;
use App\Http\Services\GatewayService;
use App\Http\Services\Payment\Payment;
use App\Models\Bank;
use App\Models\Currency;
use App\Models\Event;
use App\Models\EventTicket;
use App\Models\FileManager;
use App\Models\Gateway;
use App\Models\GatewayCurrency;
use App\Models\Membership;
use App\Models\Payment as ModelsPayment;
use App\Models\UserMembershipPlan;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ResponseTrait;

    public function checkout(Request $request)
    {
        if($request->type == 'membership' && !is_null($request->slug)){
            $membership = Membership::where('slug', $request->slug)->where('tenant_id', getTenantId())->first();
            if(is_null($membership)){
                return redirect(route('membership-package'))->with(['error' => __('Membership Not Found')]);
            }
            $data['membership'] = $membership;
            $data['product_name'] = $membership->title;
            $data['product_slug'] = $membership->slug;
            $data['price'] = $membership->price;
            $data['type'] = $request->type;
            $data['slug'] = $membership->slug;
            $data['id'] = $membership->id;
            $data['gateways'] = Gateway::where('status', ACTIVE)->where('tenant_id', getTenantId())->get();
            $data['banks'] = Bank::where('status', ACTIVE)->where('tenant_id', getTenantId())->get();
        }elseif($request->type == 'event' && !is_null($request->slug)){
            $event = Event::where('slug', $request->slug)->where('tenant_id', getTenantId())->first();
            if(is_null($event)){
                return redirect(route('event.all'))->with(['error' => __('Event Not Found')]);
            }
            if($event->type == EVENT_TYPE_FREE){
                if(EventTicket::where('user_id', auth()->id())->where('event_id', $event->id)->count()){
                    return redirect()->route('event.my-ticket')->with(['error' => __('You have already this reservation')]);
                }
                $ticket_number = getTicketNumber($event->id, $event->eventTicket()->count());
                $event->eventTicket()->create([
                    'tenant_id' => auth()->user()->tenant_id,
                    'user_id' => auth()->id(),
                    'ticket_number' => $ticket_number,
                ]);

                $event->decrement('number_of_ticket_left');

                $purpose = __('Free event reservation done for ').  $event->title;

                setCommonNotification( __('Reservation'), $purpose, Null, auth()->id());
                $customData = [
                    'ticket_number'=> $ticket_number,
                ];
                $link = route('transaction.list');
                genericEmailNotify('',auth()->user(), $customData,'ticket-confirmation',$link);
                return redirect()->route('event.my-ticket')->with(['success' => __('Free ticket has been reserved successfully')]);
            }else{
                $data['event'] = $event;
                $data['product_name'] = $event->title;
                $data['product_slug'] = $event->slug;
                $data['price'] = $event->price;
                $data['type'] = $request->type;
                $data['slug'] = $event->slug;
                $data['id'] = $event->id;
                $data['gateways'] = Gateway::where('status', ACTIVE)->where('tenant_id', getTenantId())->get();
                $data['banks'] = Bank::where('status', ACTIVE)->where('tenant_id', getTenantId())->get();
            }
        }else{
            return redirect(route('home'))->with(['error' => __('Data Not Found')]);
        }

        return view('alumni.checkout', $data);
    }

    public function pay(OrderRequest $request)
    {
        $gateway = Gateway::where(['slug' => $request->gateway, 'status' => ACTIVE])->where('tenant_id', getTenantId())->first();
        if(is_null($gateway)){
            return back()->with(['error' => __('Gateway Not Found')]);
        }
        $gatewayCurrency = GatewayCurrency::where(['gateway_id' => $gateway->id, 'currency' => $request->currency])->first();
        if(is_null($gatewayCurrency)){
            return back()->with(['error' => __('Gateway Currency Not Found')]);
        }

        if($request->type == 'event'){
            $object = Event::where('id', $request->id)->where('tenant_id', getTenantId())->first();
            $price = $object->price;
            $purpose = __('Event reservation order place successfully');
        }elseif($request->type =='membership'){
            $object = Membership::where('id', $request->id)->where('tenant_id', getTenantId())->first();
            $userMembership = auth()->user()->activeMembership;
            $price = $object->price;

            $purpose = __('Membership order place successfully');

            if(!is_null($object) && !is_null($userMembership) && $userMembership->membership_id == $object->membership_id){
                return back()->with(['error' => __('You are already in this membership plan')]);
            }
        }

        if(!isset($object) || is_null($object)){
            return back()->with(['error' => __('Desire payment data not found')]);
        }

        if(is_null($gatewayCurrency)){
            return back()->with(['error' => __('Gateway Currency Not Found')]);
        }

        if ($gateway->slug == 'bank') {
            DB::beginTransaction();
            try {
                $bank = Bank::where(['gateway_id' => $gateway->id, 'id' => $request->bank_id])->where('tenant_id', getTenantId())->firstOrFail();
                $bank_id = $bank->id;
                $deposit_slip_id = null;
                if ($request->hasFile('bank_slip')) {
                    $new_file = new FileManager();
                    $uploaded = $new_file->upload('payments', $request->bank_slip);
                    $deposit_slip_id = $uploaded->id;
                }

                $order = $this->placeOrder($object, $price, $gateway, $gatewayCurrency, $bank_id, $deposit_slip_id); // new order create

                if($request->type =='event'){
                    $order->paymentable->decrement('number_of_ticket_left');
                }

                setCommonNotification( __('Order Place'), $purpose, Null, $order->user_id);
                if($request->type == 'membership'){
                    $link = route('membership-package');
                    genericEmailNotify('', $order->user ,NULL,'membership-apply-application',$link);
                } elseif($request->type =='event'){
                    $customData = [
                        'transaction_no'=> $order->tnxId,
                    ];
                    $link = route('transaction.list');
                    genericEmailNotify('', $order->user ,$customData,'event-purchase',$link);
                }


                //Membership/Event purchase Apply Application

                DB::commit();
                return redirect()->route('checkout.success', ['success' => true, 'message' =>  __('Bank Details Sent Successfully! Wait for approval')]);
            } catch (\Exception $e) {
                DB::rollBack();
                return redirect()->route('checkout.success', ['success' => false, 'message' => __('Your payment has been failed!')]);
            }
        } else {
            $order = $this->placeOrder($object, $price, $gateway, $gatewayCurrency); // new order create

            setCommonNotification( __('Order Place'), $purpose, Null, $order->user_id);

            if($request->type == 'membership'){
                $link = route('membership-package');
                genericEmailNotify('', $order->user ,NULL,'membership-apply-application',$link);
            } elseif($request->type =='event'){
                $customData = [
                    'transaction_no'=> $order->tnxId,
                ];
                $link = route('transaction.list');
                genericEmailNotify('', $order->user ,$customData,'event-purchase',$link);
            }
            //Membership/Event purchase Apply Application
        }


        $object = [
            'id' => $order->id,
            'callback_url' => route('payment.verify'),
            'currency' => $gatewayCurrency->currency
        ];

        $payment = new Payment($gateway->slug, $object);
        $responseData = $payment->makePayment($order->grand_total);
        if ($responseData['success']) {
            $order->paymentId = $responseData['payment_id'];
            $order->save();
            return redirect($responseData['redirect_url']);
        } else {
            return redirect()->back()->with('error', $responseData['message']);
        }
    }

    public function placeOrder($object, $price, $gateway, $gatewayCurrency, $bank_id = null, $deposit_slip_id = null)
    {
        return $object->payments()->create([
            'user_id' => auth()->id(),
            'tnxId' => uniqid(),
            'tenant_id' => getTenantId(),
            'amount' => $price,
            'system_currency' => Currency::where('current_currency', 'on')->first()->currency_code,
            'gateway_id' => $gateway->id,
            'payment_currency' => $gatewayCurrency->currency,
            'conversion_rate' => $gatewayCurrency->conversion_rate,
            'sub_total' => $price,
            'grand_total' => $price,
            'grand_total_with_conversation_rate' => $price * $gatewayCurrency->conversion_rate,
            'bank_id' => $bank_id,
            'deposit_slip' => $deposit_slip_id,
            'payment_details' => json_encode($object),
            'payment_status' => PAYMENT_STATUS_PENDING
        ]);
    }

    public function verify(Request $request)
    {
        $order_id = $request->get('id', '');
        $payerId = $request->get('PayerID', NULL);
        $payment_id = $request->get('payment_id', NULL);

        $order = ModelsPayment::find($order_id);
        if(is_null($order)){
            return redirect()->route('checkout.success', ['success' => false, 'message' => __('Your order is not exist!')]);
        }

        if ($order->payment_status == PAYMENT_STATUS_PAID) {
            return redirect()->route('checkout.success', ['success' => false, 'message' => __('Your order is not exist!')]);
        }

        $gateway = Gateway::find($order->gateway_id);
        DB::beginTransaction();
        try {
            if ($order->gateway_id == $gateway->id && $gateway->slug == MERCADOPAGO) {
                $order->paymentId = $payment_id;
                $order->save();
            }

            $payment_id = $order->paymentId;

            $gatewayBasePayment = new Payment($gateway->slug, ['currency' => $order->payment_currency]);
            $payment_data = $gatewayBasePayment->paymentConfirmation($payment_id, $payerId);

            if ($payment_data['success']) {
                if ($payment_data['data']['payment_status'] == 'success') {
                    $order->payment_status = PAYMENT_STATUS_PAID;
                    $order->payment_time = now();
                    $order->gateway_callback_details = json_encode($request->all());
                    $order->save();

                    $className = class_basename(get_class($order->paymentable));

                    if($className == 'Event'){
                        $ticket_number = getTicketNumber($order->paymentable->id, $order->paymentable->eventTicket()->count());
                        $reference = $order->paymentable->eventTicket()->create([
                            'user_id' => $order->user_id,
                            'tenant_id' => $order->user->tenant_id,
                            'ticket_number' => $ticket_number,
                        ]);

                        $order->paymentable->decrement('number_of_ticket_left');

                        $purpose = __('Event reservation payment for ').  $order->paymentable->title;
                        $type = TRANSACTION_EVENT;
                        $customData = [
                            'ticket_number'=> $ticket_number,
                        ];
                        $link = route('event.my-event');
                        genericEmailNotify('',$order->user, $customData,'ticket-confirmation',$link);
                        //Email ticket confirm
                    }elseif($className == 'Membership'){
                        $type = TRANSACTION_MEMBERSHIP;

                        $expiredDate = now();

                        if($order->paymentable->duration_type == DURATION_TYPE_DAY){
                            $expiredDate = now()->addDays($order->paymentable->duration);
                        }else if($order->paymentable->duration_type == DURATION_TYPE_MONTH){
                            $expiredDate = now()->addMonths($order->paymentable->duration);
                        }else if($order->paymentable->duration_type == DURATION_TYPE_YEAR){
                            $expiredDate = now()->addYears($order->paymentable->duration);
                        }

                        UserMembershipPlan::where('user_id', $order->user_id)->where('expired_date', '>=', now())->update(['status' => STATUS_REJECT]);

                        $reference = $order->paymentable->userMembershipPlans()->create([
                            'user_id' => $order->user_id,
                            'tenant_id' => $order->user->tenant_id,
                            'expired_date' => $expiredDate,
                            'status' => STATUS_ACTIVE,
                        ]);

                        $purpose = __('Membership payment for ').  $order->paymentable->title;
                        $type = TRANSACTION_MEMBERSHIP;

                        $link = route('membership-package');
                        genericEmailNotify('',$order->user,NULL,'membership-approval',$link);

                        //Email Membership approval
                    }

                    //Create Transaction
                    $order->transaction()->create([
                        'user_id' => $order->user_id,
                        'tenant_id' => getTenantId(),
                        'reference_id' => $reference->id,
                        'type' => $type,
                        'tnxId' => $order->tnxId,
                        'amount' => $order->grand_total,
                        'purpose' => $purpose,
                        'payment_time' => $order->payment_time,
                        'payment_method' => $gateway->title
                    ]);

                    setCommonNotification( __('Payment'), $purpose, route('transaction.list'), $order->user_id);
                    $customData = [
                        'transaction_no'=> $order->tnxId,
                    ];
                    $link = route('transaction.list');
                    genericEmailNotify('',$order->user,$customData,'payment-success',$link);
                    //Email Payment Successful

                    DB::commit();
                    return redirect()->route('checkout.success', ['success' => true, 'message' =>  __('Your payment has been successful!')]);
                }
            } else {
                return redirect()->route('checkout.success', ['success' => false, 'message' => __('Your payment has been failed')]);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            dd($e->getMessage());
            return redirect()->route('checkout.success', ['success' => false, 'message' => __('Your payment has been failed')]);
        }
    }

    public function getCurrencyByGateway(Request $request)
    {
        $gateWayService = new GatewayService;
        $data = $gateWayService->getCurrencyByGatewayId($request->id);
        return $this->success($data);
    }

    public function checkoutSuccess(Request $request){
        $data['success'] = $request->success;
        $data['message'] = $request->message;
        return view('alumni.checkout-success', $data);
    }

}
