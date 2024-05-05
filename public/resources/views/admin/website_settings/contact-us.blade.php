@extends('layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 pr-0">
                    <div class="bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
                        @include('admin.website_settings.partials.sidebar')
                    </div>
                </div>
                <input type="hidden" id="contact-us-route" value="{{ route('admin.setting.website-settings.contact-us') }}">
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="bd-c-ebedf0 bd-half bd-ra-25 bg-white p-30">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="customers__area bg-style mb-30">
                                    <div class="customers__table">
                                        <div class="table-responsive zTable-responsive">
                                            <table class="table zTable" id="contactUsDataTable">
                                                <thead>
                                                <tr>
                                                    <th scope="col">
                                                        <div>{{ __('Name') }}</div>
                                                    </th>
                                                    <th scope="col">
                                                        <div>{{ __('Email') }}</div>
                                                    </th>
                                                    <th scope="col">
                                                        <div>{{ __('Message') }}</div>
                                                    </th>
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
        </div>
    </div>
@endsection
@push('script')
    <script src="{{asset('admin/js/contact-us.js')}}"></script>
@endpush

