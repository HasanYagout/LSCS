@extends('layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <div class="p-30" >
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
                                    <div class="row">
                                        <div class="col">
                                            <div class="col-mg-4">
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Left Title') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_left_title"
                                                              class="primary-form-control">{{ getOption('join_us_left_title') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Left Description') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_left_description"
                                                              class="primary-form-control summernoteOne">{{ getOption('join_us_left_description') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-17 row">

                                                <div class="pb-4  pb-17">
                                                    <div class="primary-form-group">
                                                        <div class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                                            <div class="zImage-inside">
                                                                <div class="d-flex pb-12"><img
                                                                        src="{{asset('public/assets/images/icon/upload-img-1.svg')}}"
                                                                        alt=""/></div>
                                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                                            </div>
                                                            <label for="zImageUpload"
                                                                   class="form-label">{{__('Join Us Left Icon')}}
                                                                <span class="text-mime-type">{{__('(jpg,jpeg,png)')}}</span> <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="upload-img-box">
                                                                @if(getOption('join_us_left_icon'))
                                                                    <img
                                                                        src="{{ getSettingImage('join_us_left_icon') }}"/>
                                                                @else
                                                                    <img src=""/>
                                                                @endif
                                                                <input type="file" name="join_us_left_icon"
                                                                       accept="image/*" onchange="previewFile(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col order-12">
                                            <div class="col-mg-4">
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Middle Title') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_middle_title"
                                                              class="primary-form-control">{{ getOption('join_us_middle_title') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Middle Description') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_middle_description"
                                                              class="primary-form-control summernoteOne">{{ getOption('join_us_middle_description') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-17 row">

                                                <div class="pb-4  pb-17">
                                                    <div class="primary-form-group">
                                                        <div class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                                            <div class="zImage-inside">
                                                                <div class="d-flex pb-12"><img
                                                                        src="{{asset('public/assets/images/icon/upload-img-1.svg')}}"
                                                                        alt=""/></div>
                                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                                            </div>
                                                            <label for="zImageUpload"
                                                                   class="form-label">{{__('Join Us Middle Icon')}}
                                                                <span class="text-mime-type">{{__('(jpg,jpeg,png)')}}</span> <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="upload-img-box">
                                                                @if(getOption('join_us_middle_icon'))
                                                                    <img
                                                                        src="{{ getSettingImage('join_us_middle_icon') }}"/>
                                                                @else
                                                                    <img src=""/>
                                                                @endif
                                                                <input type="file" name="join_us_middle_icon"
                                                                       accept="image/*" onchange="previewFile(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                        <div class="col order-1">
                                            <div class="col-mg-4">
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Right Title') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_right_title"
                                                              class="primary-form-control ">{{ getOption('join_us_right_title') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <div class="primary-form-group my-2 pt-3">
                                                        <div class="primary-form-group-wrap">
                                                            <label class="form-label">{{ __('Join Us Right Description') }} <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="">
                                                    <textarea name="join_us_right_description"
                                                              class="primary-form-control summernoteOne">{{ getOption('join_us_right_description') }}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="mt-17 row">

                                                <div class="pb-4  pb-17">
                                                    <div class="primary-form-group">
                                                        <div class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                                            <div class="zImage-inside">
                                                                <div class="d-flex pb-12"><img
                                                                        src="{{asset('public/assets/images/icon/upload-img-1.svg')}}"
                                                                        alt=""/></div>
                                                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                                            </div>
                                                            <label for="zImageUpload"
                                                                   class="form-label">{{__('Join Us Right Icon')}}
                                                                <span class="text-mime-type">{{__('(jpg,jpeg,png)')}}</span> <span
                                                                    class="text-danger">*</span></label>
                                                            <div class="upload-img-box">
                                                                @if(getOption('join_us_right_icon'))
                                                                    <img
                                                                        src="{{ getSettingImage('join_us_right_icon') }}"/>
                                                                @else
                                                                    <img src=""/>
                                                                @endif
                                                                <input type="file" name="join_us_right_icon"
                                                                       accept="image/*" onchange="previewFile(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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
