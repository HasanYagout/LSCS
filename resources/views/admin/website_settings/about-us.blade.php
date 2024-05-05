@extends('layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Website Setting') }}</h4>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 pr-0">
                    <div class="bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
                        @include('admin.website_settings.partials.sidebar')
                    </div>
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <div
                            class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                            <div class="item-top mb-30">
                                <h4>{{ $title }}</h4>
                            </div>
                            <form class="ajax" action="{{ route('admin.setting.application-settings.update') }}"
                                  method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                                @csrf
                                <div class="col-lg-6">
                                    <div class="primary-form-group my-2 pt-3">
                                        <div class="primary-form-group-wrap">
                                            <label class="form-label">{{ __('Title') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="">
                                                    <textarea name="about_us_title"
                                                              class="primary-form-control">{{ getOption('about_us_title') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="primary-form-group my-2 pt-3">
                                        <div class="primary-form-group-wrap">
                                            <label class="form-label">{{ __('Description') }} <span
                                                    class="text-danger">*</span></label>
                                            <div class="">
                                                    <textarea name="about_us_description"
                                                              class="primary-form-control summernoteOne">{{ getOption('about_us_description') }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-4 col-md-6 pb-17 my-2 pt-3">
                                    <div class="primary-form-group">
                                        <div class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                            <div class="zImage-inside">
                                                <div class="d-flex pb-12"><img
                                                        src="{{asset('assets/images/icon/upload-img-1.svg')}}"
                                                        alt=""/></div>
                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                            </div>
                                            <label for="zImageUpload"
                                                   class="form-label">{{__('About Us Breadcrumb Background')}}
                                                <span class="text-mime-type">{{__('(jpg,jpeg,png)')}}</span>
                                                <span
                                                    class="text-danger">*</span></label>
                                            <div class="upload-img-box">
                                                @if(getOption('about_us_background_breadcrumb'))
                                                    <img
                                                        src="{{ getSettingImage('about_us_background_breadcrumb') }}"/>
                                                @else
                                                    <img src=""/>
                                                @endif
                                                <input type="file" name="about_us_background_breadcrumb"
                                                       accept="image/*" onchange="previewFile(this)">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-17 row">
                                    <div class="col-12">
                                        <div class="input__group general-settings-btn text-end">
                                            <button type="submit"
                                                    class="bd-ra-12 bg-cdef84 border-0 fw-500 hover-bg-one lh-25 px-26 py-10">{{ __('Update') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
