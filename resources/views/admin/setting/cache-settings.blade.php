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
                    @include('admin.setting.partials.general-sidebar')
                </div>
            </div>
            <div class="col-xxl-10 col-lg-9 col-md-8">

                <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <div class="item-top mb-30">
                            <h4>{{ $title }}</h4>
                        </div>
                        <div class="item-top mb-30"><h2>{{ __(@$pageTitle) }}</h2></div>
                        <div class="custom-form-group mb-3 row align-items-center">
                            <label for="" class="col-lg-3 text-lg-right text-black">{{ __('Clear View Cache') }}</label>
                            <div class="col-lg-9">
                                <a href="{{ route('admin.setting.cache-update', 1) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{ __('Click Here') }}</a>
                            </div>
                        </div>
                        <div class="custom-form-group mb-3 row align-items-center">
                            <label for="" class="col-lg-3 text-lg-right text-black">{{ __('Clear Route Cache') }} </label>
                            <div class="col-lg-9">
                                <a href="{{ route('admin.setting.cache-update', 2) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{ __('Click Here') }}</a>
                            </div>
                        </div>
                        <div class="custom-form-group mb-3 row align-items-center">
                            <label for="" class="col-lg-3 text-lg-right text-black">{{ __('Clear Config Cache') }} </label>
                            <div class="col-lg-9">
                                <a href="{{ route('admin.setting.cache-update', 3) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{ __('Click Here') }}</a>
                            </div>
                        </div>
                        <div class="custom-form-group mb-3 row align-items-center">
                            <label for="" class="col-lg-3 text-lg-right text-black">{{ __('Application Clear Cache') }} </label>
                            <div class="col-lg-9">
                                <a href="{{ route('admin.setting.cache-update', 4) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{ __('Click Here') }}</a>
                            </div>
                        </div>
                        <div class="custom-form-group mb-3 row align-items-center">
                            <label for="" class="col-lg-3 text-lg-right text-black">{{ __('Storage Link') }} </label>
                            <div class="col-lg-9">
                                <a href="{{ route('admin.setting.cache-update', 5) }}" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{ __('Click Here') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


