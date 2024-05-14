<?php

namespace App\Http\Controllers\Alumni;

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

    public function userTransaction(Request $request)
    {
        if ($request->ajax()) {
            return $this->transactionService->userTransactionList(getTenantId());
        }

        $data['title'] = __('Transaction History');
        $data['activeTransactionList'] = 'active';
        return view('alumni.transaction', $data);
    }

    public function userTransactionDownload($id)
    {
        $data['transaction'] = $this->transactionService->getTransaction($id);
        return view('alumni/transaction-download', $data);
    }

    public function userTransactionPrint($id)
    {
        $data['transaction'] = $this->transactionService->getTransaction($id);
        return view('alumni/transaction-print', $data);
    }

}
