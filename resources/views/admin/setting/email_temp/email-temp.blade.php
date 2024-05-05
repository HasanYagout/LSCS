@extends('layouts.app')
@push('title')
{{ $title }}
@endpush
@section('content')
<div class="p-30">
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
        <div class="bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
            <div class="row">
                <input type="hidden" value="{{route('admin.setting.email-template')}}" id="email-temp-route">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="customers__table">
                            <div class="table-responsive zTable-responsive">
                                <table class="table zTable" id="emailTempDataTable">
                                <thead>
                                <tr>
                                    <th><div>{{ __("Category") }}</div></th>
                                    <th><div>{{ __("Subject") }}</div></th>
                                    <th><div>{{ __("Body") }}</div></th>
                                    <th><div>{{ __("Action") }}</div></th>
                                </tr>
                                </thead>
                            </table>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content area end -->
    <!-- Edit Modal section start -->
    <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">

            </div>
        </div>
    </div>
    <!-- Edit Modal section end -->
@endsection
@push('script')
    <script src="{{ asset('admin/js/email-temp.js') }}"></script>
@endpush
