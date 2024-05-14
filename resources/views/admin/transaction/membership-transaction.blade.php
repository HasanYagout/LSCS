@extends('layouts.app')

@section('content')
    <!-- Page content area start -->
    <div class="p-30">
        <div>
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
                <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
            </div>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="membershipDataTable">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div>{{ __('User') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Purpose') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Transaction ID') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Payment Method') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Date and Time') }}</div>
                            </th>
                            <th scope="col">
                                <div>{{ __('Amount') }}</div>
                            </th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
    <!-- Page content area End -->

    <input type="hidden" id="membership-transaction-route" value="{{ route('admin.transactions.membership.list') }}">
@endsection

@push('script')
    <script src="{{ asset('admin/js/membership-transaction.js') }}"></script>
@endpush
