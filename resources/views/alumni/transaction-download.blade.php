<!-- Header -->
<div
    class="bd-b-one bd-c-ededed mb-44 pb-25 d-flex justify-content-center justify-content-sm-between align-items-center flex-wrap cg-15 rg-10">
    <!-- Left -->
    <button type="button" data-bs-dismiss="modal" aria-label="Close"
        class="d-flex align-items-center cg-13 border-0 bg-white">
        <span class="text-1b1c17"><i class="fa-solid fa-arrow-left"></i></span>
        <p class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Back To Dashboard') }}</p>
    </button>
    <!-- Right -->
    <a href="{{ route('transaction.print', $transaction->id) }}" target="_blank"
        class="border-0 d-flex align-items-center cg-8 px-10 py-5 bg-cdef84 bd-ra-4">
        <p class="fs-14 fw-500 lh-20 text-1b1c17">{{ __('Print') }}</p>
        <span><img src="assets/images/icon/download.svg" alt="" /></span>
    </a>
</div>

<div id="printableArea">

    <!-- Invoice no & status -->
    <div class="d-flex justify-content-between align-items-center g-10 bd-b-one bd-c-ededed pb-33 mb-20">
        <!-- Left -->
        <div class="">
            <a href="#" class="max-w-146 d-block mb-6"><img class="max-h-35"
                    src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>
            <p class="fs-15 fw-500 lh-20 text-1b1c17">{{ $transaction->tnxId }}</p>
        </div>
        <!-- Right -->
        <p class="py-14 px-25 fs-14 fw-500 lh-20 text-0fa958 bg-0fa958-10 bd-ra-4">{{ __('Paid') }}</p>
    </div>
    <!-- Invoice for & paid to -->
    <div class="d-flex justify-content-between g-10 pb-22">
        <!-- Invoice for -->
        <div class="">
            <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-18">{{ __('Invoice To') }}</h4>
            <h4 class="fs-18 fw-500 lh-22 text-707070 pb-5">{{ $transaction->user->name }}</h4>
            <p class="fs-13 fw-400 lh-20 text-707070 pb-10">{{ $transaction->user->email }}</p>
            <p class="fs-13 fw-400 lh-20 text-707070">{{ $transaction->user->alumni->address }},
                {{ $transaction->user->alumni->city }} - {{ $transaction->user->alumni->zip }},
                {{ $transaction->user->alumni->state }}, {{ $transaction->user->alumni->country }}</p>
        </div>
        <div class="text-end">
            <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-18">{{ __('Pay To') }}</h4>
            <h4 class="fs-15 fw-500 lh-20 text-707070 pb-10">{{ getOption('app_name') }}</h4>
            <p class="fs-14 fw-500 lh-20 text-707070">{{ getOption('app_location') }}</p>
        </div>
        <!-- Paid to -->
    </div>
    <!-- Invoice Items -->
    <div class="pb-33">
        <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Invoice Items') }}</h4>
        <div class="table-responsive">
            <table class="table zTable zTable-2">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Type') }}</th>
                        <th scope="col">{{ __('Description') }}</th>
                        <th scope="col">{{ __('Date') }}</th>
                        <th scope="col">{{ __('Amount') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <p>{{ transactionType($transaction->type) }}</p>
                        </td>
                        <td>
                            <p class="max-w-408 min-w-408">{{ $transaction->purpose }}</p>
                        </td>
                        {{-- {{date('d-m-Y', strtotime($transaction->created_at))}}  --}}
                        <td>
                            <p class="min-w-50">{{ Carbon\Carbon::parse($transaction->created_at)->format('j M Y') }}
                            </p>
                        </td>
                        <td>
                            <p>{{ showPrice($transaction->amount) }}</p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Transaction Status -->
    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Transaction History') }}</h4>
    <div class="bg-fafafa bd-one bd-c-ededed bd-ra-4 table-responsive">
        <table class="table zTable zTable-2 zTable-3">
            <thead>
                <tr>
                    <th scope="col">{{ __('Transaction Date') }}</th>
                    <th scope="col">{{ __('Payment Type') }}</th>
                    <th scope="col">{{ __('Transaction ID') }}</th>
                    <th scope="col">{{ __('Amount') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <p class="min-w-110">{{ Carbon\Carbon::parse($transaction->created_at)->format('j M Y') }}</p>
                    </td>
                    <td>
                        <p class="min-w-110">{{ $transaction->payment_method }}</p>
                    </td>
                    <td>
                        <p>{{ $transaction->tnxId }}</p>
                    </td>
                    <td>
                        <p>{{ showPrice($transaction->amount) }}</p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
