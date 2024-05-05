<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{__('transaction-print')}}</title>
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/scss/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}" />
</head>
<body>

    <div class="row d-flex justify-content-center">
        <div class="col-md-8">
            <div id="printableArea" class="p-3 bg-white rounded">
                <!-- Invoice no & status -->
                <div class="d-flex justify-content-between align-items-center g-10 bd-b-one bd-c-ededed pb-33 mb-20">
                    <!-- Left -->
                    <div class="">
                        <a href="#" class="max-w-146 d-block mb-6"><img class="max-h-35" src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>
                        <p class="fs-15 fw-500 lh-20 text-1b1c17">{{$transaction->tnxId}}</p>
                    </div>
                    <!-- Right -->
                    <p class="py-14 px-25 fs-14 fw-500 lh-20 text-0fa958 bg-0fa958-10 bd-ra-4">{{__('Paid')}}</p>
                </div>
                <!-- Invoice for & paid to -->
                <div class="d-flex justify-content-between g-10 pb-22">
                <!-- Invoice for -->
                <div class="">
                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-18">{{__('Invoice To')}}</h4>
                    <h4 class="fs-18 fw-500 lh-22 text-707070 pb-5">{{$transaction->user->name}}</h4>
                    <p class="fs-13 fw-400 lh-20 text-707070 pb-10">{{$transaction->user->email}}</p>
                    <p class="fs-13 fw-400 lh-20 text-707070">{{$transaction->user->alumni->address}}, {{$transaction->user->alumni->city}} - {{$transaction->user->alumni->zip}}, {{$transaction->user->alumni->state}}, {{$transaction->user->alumni->country}}</p>
                </div>
                <div class="text-end">
                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-18">{{__('Pay To')}}</h4>
                    <h4 class="fs-15 fw-500 lh-20 text-707070 pb-10">{{ getOption('app_name') }}</h4>
                    <p class="fs-14 fw-500 lh-20 text-707070">{{ getOption('app_location') }}</p>
                </div>
                <!-- Paid to -->
                </div>
                <!-- Invoice Items -->
                <div class="pb-33">
                <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{__('Invoice Items')}}</h4>
                <div class="table-responsive">
                    <table class="table zTable zTable-2">
                    <thead>
                        <tr>
                        <th scope="col">{{__('Type')}}</th>
                        <th scope="col">{{__('Description')}}</th>
                        <th scope="col">{{__('Date')}}</th>
                        <th scope="col">{{__('Amount')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td><p>{{transactionType($transaction->type)}}</p></td>
                        <td><p>{{$transaction->purpose}}</p></td>
                        {{-- {{date('d-m-Y', strtotime($transaction->created_at))}}  --}}
                        <td><p class="min-w-50">{{Carbon\Carbon::parse($transaction->created_at)->format('j M Y')}}</p></td>
                        <td><p>{{showPrice($transaction->amount)}}</p></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
                </div>
                <!-- Transaction Status -->
                <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{__('Transaction History')}}</h4>
                <div class="bg-fafafa bd-one bd-c-ededed bd-ra-4 table-responsive">
                <table class="table zTable zTable-2 zTable-3">
                    <thead>
                    <tr>
                        <th scope="col">{{__('Transaction Date')}}</th>
                        <th scope="col">{{__('Payment Type')}}</th>
                        <th scope="col">{{__('Transaction ID')}}</th>
                        <th scope="col">{{__('Amount')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><p class="min-w-110">{{Carbon\Carbon::parse($transaction->created_at)->format('j M Y')}}</p></td>
                        <td><p class="min-w-110">{{$transaction->payment_method}}</p></td>
                        <td><p>{{$transaction->tnxId}}</p></td>
                        <td><p>{{showPrice($transaction->amount)}}</p></td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery-3.7.0.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('alumni/js/print-invoice.js')}}"></script>
</body>
</html>
