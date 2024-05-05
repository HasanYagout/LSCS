<?php

namespace App\Http\Services;

use App\Models\Gateway;
use App\Models\Notice;
use App\Models\Payment;
use App\Models\Transaction;
use App\Models\UserMembershipPlan;
use App\Traits\ResponseTrait;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    use ResponseTrait;

    public function allTransactionList()
    {
        $transaction = Transaction::with('user')->where('tenant_id', getTenantId())->orderBy('id','DESC');
        return datatables($transaction)
            ->addColumn('created_at', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->addColumn('user',function ($data){
                return $data->user->name;
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->rawColumns(['created_at'])
            ->make(true);
    }

    public function userTransactionList($tenantId=NULL)
    {
        $userId = Auth::id();
        $transaction = Transaction::where('user_id', $userId)->with('user')->orderBy('id','DESC');
        return datatables($transaction)
            ->addColumn('user',function ($data){
                return $data->user->name;
            })
            ->addColumn('created_at', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->addColumn('memo', function ($data) {
                return '<a onclick="getEditModal(\'' . route('transaction.download', $data->id) . '\'' . ', \'#invoiceModal\')" href="#" class="d-block min-w-130 text-decoration-underline fw-600 text-1b1c17" data-bs-toggle="modal" data-bs-target="#alumniPhoneNo">
                Download Receipt </a>';
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->rawColumns(['created_at', 'memo'])
            ->make(true);
    }

    public function eventTransactionList()
    {
        $transaction = Transaction::where('type', TRANSACTION_EVENT)->where('tenant_id', getTenantId())->with('user')->orderBy('id','DESC');
        return datatables($transaction)
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('user',function ($data){
                return $data->user->name;
            })
            ->addColumn('created_at',function ($data){
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->make(true);
    }

    public function membershipTransactionList()
    {
        $transaction = Transaction::where('type', TRANSACTION_MEMBERSHIP)->where('tenant_id', getTenantId())->with('user')->orderBy('id','DESC');
        return datatables($transaction)
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('user',function ($data){
                return $data->user->name;
            })
            ->addColumn('created_at',function ($data){
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->make(true);
    }

    public function pendingTransactionList()
    {

        $data = Payment::join('gateways', 'gateways.id', '=', 'payments.gateway_id')
            ->where('gateways.slug', 'bank')
            ->orderBy('payments.created_at', 'DESC')
            ->where('payment_status', PAYMENT_STATUS_PENDING)
            ->where('gateways.tenant_id', getTenantId())
            ->with('paymentable')
            ->with('gateway')
            ->with('bank')
            ->with('user')
            ->select('payments.*');

        return datatables($data)
            ->addColumn('user', function ($data) {
                return $data->user->name;
            })
            ->addColumn('type', function ($data) {
                return 'Type - ' . getPaymentType($data->paymentable) .
                    ' <br> ' .
                    'Title - ' . $data->paymentable->title;
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->grand_total);
            })
            ->addColumn('created_at', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->addColumn('status', function ($data) {
                $status = $data->status ?? '';
                if ($status == STATUS_PENDING) {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-0fa958 bg-0fa958-10">' . __('Accepted') . '</span>';
                } else {
                    return '<span class="d-inline-block py-6 px-10 bd-ra-6 fs-14 fw-500 lh-16 text-f5b40a bg-f5b40a-10">' . __('Pending') . '</span>';
                }
            })
            ->addColumn('payment_info', function ($data) {
                return __('Payment Type').' : ' . $data->gateway->title . '<br>' .
                    __('Bank Name').' : ' . $data->bank->name . '<br>' .
                    __('Deposit Slip').' : ' . $data->deposit_slip . '<a href="'.getFileUrl($data->deposit_slip).'' . '" target="_blank">' . __('View slip') . '</a>';;
            })
            ->addColumn('action', function ($data) {
                $html = '<select class="form-control form-select change_status-ss w-110" name="change_status" data-id=' . $data->id . '>';
                foreach (getPaymentStatus() as $key => $value) {
                    $html .= '<option ';
                    if ($data->status == $key) {
                        $html .= ' selected ';
                    }
                    $html .= 'value="' . $key . '">' . $value . '</option>';
                }
                $html .= '</select>';
                return $html;
            })
            ->rawColumns(['status', 'type', 'payment_info', 'action'])
            ->make(true);
    }

    public function getTransaction($id)
    {
        return Transaction::where('id', $id)->with('user.alumni')->first();
    }

    public function changeTransactionStatus($request)
    {
        try {
            DB::beginTransaction();
            if($request->status == STATUS_SUCCESS){
                $payment = Payment::where('id', $request->id)->where('tenant_id', getTenantId())->first();
                if(is_null($payment)){
                    return $this->error([], __('Payment not found'));
                }
                $gateway = Gateway::find($payment->gateway_id);
                $payment->payment_status = PAYMENT_STATUS_PAID;
                $payment->payment_time = now();
                $payment->gateway_callback_details = json_encode($payment->bank);
                $payment->save();

                $className = class_basename(get_class($payment->paymentable));

                if ($className == 'Event') {
                    $reference = $payment->paymentable->eventTicket()->create([
                        'user_id' => $payment->user_id,
                        'tenant_id' => $payment->user->tenant_id,
                        'ticket_number' => getTicketNumber($payment->paymentable->id, $payment->paymentable->eventTicket()->count()),
                    ]);

                    $purpose = __('Event reservation payment for ') . $payment->paymentable->title;
                    $type = TRANSACTION_EVENT;
                    $customData = [
                        'ticket_number'=> $reference->ticket_number,
                    ];
                    $link = route('event.my-event');
                    genericEmailNotify('',$payment->user, $customData,'ticket-confirmation',$link);
                    //Email Ticket confirmation
                } elseif ($className == 'Membership') {

                    $type = TRANSACTION_MEMBERSHIP;

                    $expiredDate = now();

                    if ($payment->paymentable->duration_type == DURATION_TYPE_DAY) {
                        $expiredDate = now()->addDays($payment->paymentable->duration);
                    } else if ($payment->paymentable->duration_type == DURATION_TYPE_MONTH) {
                        $expiredDate = now()->addMonths($payment->paymentable->duration);
                    } else if ($payment->paymentable->duration_type == DURATION_TYPE_YEAR) {
                        $expiredDate = now()->addYears($payment->paymentable->duration);
                    }

                    UserMembershipPlan::where('user_id', $payment->user_id)->where('expired_date', '>=', now())->update(['status' => STATUS_REJECT]);

                    $reference = $payment->paymentable->userMembershipPlans()->create([
                        'user_id' => $payment->user_id,
                        'tenant_id' => $payment->user->tenant_id,
                        'expired_date' => $expiredDate,
                        'status' => 1,
                    ]);

                    $purpose = __('Membership payment for ') . $payment->paymentable->title;
                    $type = TRANSACTION_MEMBERSHIP;
                    $link = route('membership-package');
                    genericEmailNotify('',$payment->user, NULL,'membership-approval',$link);
                    //Email Membership approval
                }

                //Create Transaction
                $payment->transaction()->create([
                    'user_id' => $payment->user_id,
                    'tenant_id' => $payment->user->tenant_id,
                    'reference_id' => $reference->id,
                    'type' => $type,
                    'tnxId' => $payment->tnxId,
                    'amount' => $payment->grand_total,
                    'purpose' => $purpose,
                    'payment_time' => $payment->payment_time,
                    'payment_method' => $gateway->title
                ]);

                setCommonNotification(__('Payment'), $purpose, route('transaction.list'), $payment->user_id);
                $customData = [
                    'transaction_no'=> $payment->tnxId,
                ];
                $link = route('transaction.list');
                genericEmailNotify('',$payment->user, $customData,'payment-success',$link);
                //Email Payment Successful

            }elseif($request->status == PAYMENT_STATUS_CANCELLED){
                $payment = Payment::where('id', $request->id)->where('tenant_id', getTenantId())->first();
                $payment->payment_status = PAYMENT_STATUS_CANCELLED;
                $payment->save();

                $className = class_basename(get_class($payment->paymentable));

                if ($className == 'Event') {
                    $payment->paymentable->increment('number_of_ticket_left');
                    $purpose = __('Event payment cancel for ') . $payment->paymentable->title;
                }elseif($className == 'Membership'){
                    $purpose = __('Membership payment cancel for ') . $payment->paymentable->title;
                }

                setCommonNotification(__('Payment'), $purpose, route('transaction.list'), $payment->user_id);
                $customData = [
                    'transaction_no'=> $payment->tnxId,
                ];
                $link = route('transaction.list');
                genericEmailNotify('',$payment->user, $customData,'payment-cancel',$link);
                //Email Payment Cancel (New)
            }else{
                return $this->error([], __('Status not found'));
            }

            DB::commit();
            return $this->success([], __('Status change successfully'));

        } catch (\Exception $e) {
            DB::rollBack();
            return $this->error([], __('Status change failed'));
        }
    }


    public function getById($id)
    {
        return Notice::with(['category'])->where('id', $id)->where('tenant_id', getTenantId())->firstOrFail();
    }

    public function getNoticeBySlug($slug)
    {
        return Notice::where('slug', $slug)->where('tenant_id', getTenantId())->with(['category'])->firstOrFail();
    }

    public function getFirst()
    {
        return Notice::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->with(['category'])->first();
    }

    public function deleteById($id)
    {
        try {
            $notice = Notice::where('id', $id)->where('tenant_id', getTenantId())->firstOrFail();
            $notice->delete();
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

    public function getAllActive($limit = NULL)
    {
        $first = $this->getFirst()?->id;
        if (is_null($limit)) {
            return Notice::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->where('id', '!=', $first)->with(['category'])->paginate(6);
        } else {
            return Notice::where('status', STATUS_ACTIVE)->where('tenant_id', getTenantId())->limit($limit)->with(['category'])->get();
        }
    }
}
