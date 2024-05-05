@extends('frontend.layouts.app')
@push('title')
    {{ __($pageTitle) }}
@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100" data-background="{{ getSettingImage('page_breadcrumb') }}">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{ __($pageTitle) }}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                <li><a>{{ __($pageTitle) }}</a></li>
            </ul>
        </div>
    </section>
    <!-- End Breadcrumb -->
    <!-- Start-->
    <section class="pb-110 pt-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <form action="{{ route('contact_us.store') }}" method="post" data-handler="settingCommonHandler">
                        @csrf
                        <div class="pb-21">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="csName" class="form-label">{{ __('Email Address') }}</label>
                                    <input type="text" class="primary-form-control" id="csName" name="name"
                                        value="" placeholder="{{ __(' Your Name') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="pb-21">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="csEmail" class="form-label">{{ __('Email Address') }}</label>
                                    <input type="email" class="primary-form-control" id="csEmail" name="email"
                                        value="" placeholder="{{ __(' Your Email') }}" />
                                </div>
                            </div>
                        </div>
                        <div class="pb-21">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="csMessage" class="form-label">{{ __('Email Address') }}</label>
                                    <textarea name="message" id="csMessage" class="primary-form-control min-h-215" placeholder="{{ __('Message') }}"></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit"
                            class="w-100 d-inline-flex justify-content-center align-items-center border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-primary-color">
                            {{ __('Submit') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- End -->
@endsection
