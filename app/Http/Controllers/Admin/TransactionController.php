<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use App\Http\Controllers\Controller;
use App\Http\Services\TransactionService;

class TransactionController extends Controller
{
    use ResponseTrait;

    public $transactionService;

    public function __construct()
    {
        $this->transactionService = new TransactionService();
    }

    public function pendingTransaction(Request $request)
    {
        if ($request->ajax()) {
            return $this->transactionService->pendingTransactionList();
        }

        $data['title'] = __('Pending Transaction');
        $data['showTransactionNotice'] = 'show';
        $data['activePaymentNotice'] = 'active';
        return view('admin.transaction.pending-transaction-history', $data);
    }

    public function allTransaction(Request $request)
    {
        if ($request->ajax()) {
            return $this->transactionService->allTransactionList();
        }
        $data['title'] = __('All Transaction');
        $data['showTransactionNotice'] = 'show';
        $data['activeTransactionNotice'] = 'active';
        return view('admin.transaction.index', $data);
    }

    public function eventTransaction(Request $request)
    {
        if ($request->ajax()) {
            return $this->transactionService->eventTransactionList();
        }
        $data['title'] = __('Event Transaction');
        $data['showTransactionNotice'] = 'show';
        $data['activeEventNotice'] = 'active';
        return view('admin.transaction.event-transaction', $data);
    }

    public function membershipTransaction(Request $request)
    {
        if ($request->ajax()) {
            return $this->transactionService->membershipTransactionList();
        }
        $data['title'] = __('Membership Transaction');
        $data['showTransactionNotice'] = 'show';
        $data['activeMembershipNotice'] = 'active';
        return view('admin.transaction.membership-transaction', $data);
    }

    public function transactionChangeStatus(Request $request)
    {
        return $this->transactionService->changeTransactionStatus($request);

    }
}



