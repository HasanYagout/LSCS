@extends('alumni.layouts.app')

@section('content')
    <div class="p-30">
        <div>
            <input type="hidden" id="recommendation-route" value="{{ route('alumni.recommendation.list') }}">
            <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            </div>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Table -->
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable" id="recommendationTable">
                        <thead>
                        <tr>
                            <th scope="col"><div>{{ __('Instructor') }}</div></th>
                            <th scope="col"><div>{{ __('Status') }}</div></th>
                            <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('public/alumni/js/recommendation.js') }}"></script>

@endpush
