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
                            <th scope="col"><div class="bg-f5b40a text-002a5c">{{ __('Instructor') }}</div></th>
                            <th scope="col"><div class="bg-f5b40a text-002a5c">{{ __('Status') }}</div></th>
                            <th class="w-110 text-center" scope="col"><div class="bg-f5b40a text-002a5c">{{ __('Action') }}</div></th>
                        </tr>
                        </thead>
                    </table>
                </div>

            </div>
            <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('public/alumni/js/recommendation.js') }}"></script>

@endpush
