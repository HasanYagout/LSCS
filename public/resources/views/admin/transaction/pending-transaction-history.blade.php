@extends('layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')
    <div class="p-30">
        <div>
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
                <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
            </div>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <input type="hidden" id="transaction-update-route"
                       value="{{ route('admin.transactions.change-status') }}">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="pendingTransactionDataTable">
                        <thead>
                        <tr>
                            <th scope="col"><div>{{ __('User') }}</div></th>
                            <th scope="col"><div>{{ __('Type') }}</div></th>
                            <th scope="col"><div>{{ __('Amount') }}</div></th>
                            <th scope="col"><div>{{ __('Created At') }}</div></th>
                            <th scope="col"><div>{{ __('Status') }}</div></th>
                            <th scope="col"><div>{{ __('Transaction Info') }}</div></th>
                             <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Page content area End -->

    <input type="hidden" id="pending-event-transaction-route" value="{{ route('admin.transactions.pending.list') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/js/transactions-pending.js') }}"></script>
@endpush
