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
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Site Facebook Url') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="url" name="facebook_url"
                                                               value="{{ getOption('facebook_url') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Site Linkedin Url') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="url" name="linkedin_url"
                                                               value="{{ getOption('linkedin_url') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Site Twitter Url') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="url" name="twitter_url"
                                                               value="{{ getOption('twitter_url') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Site Instagram Url') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="url" name="instagram_url"
                                                               value="{{ getOption('instagram_url') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Auth Page Title') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="text" name="sign_up_left_text_title"
                                                               value="{{ getOption('sign_up_left_text_title') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Join Our Community Title') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input type="text" name="join_our_community_title"
                                                               value="{{ getOption('join_our_community_title') }}"
                                                               class="primary-form-control">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Auth Page Subtitle') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <textarea name="sign_up_left_text_subtitle"
                                                                  class="primary-form-control">{{ getOption('sign_up_left_text_subtitle') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Join Our Community Text') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <textarea name="join_our_community_text"
                                                                  class="primary-form-control">{{ getOption('join_our_community_text') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label class="form-label">{{ __('Footer Left Text') }} <span
                                                            class="text-danger">*</span></label>
                                                    <div class="">
                                                        <textarea name="footer_left_text"
                                                                  class="primary-form-control">{{ getOption('footer_left_text') }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="container">
                                            <div class="row">
                                                <!-- First Column -->
                                                <div class="col">
                                                    <div class="pb-4  pb-17">
                                                        <div class="primary-form-group">
                                                            <div
                                                                class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                                                <div class="zImage-inside">
                                                                    <div class="d-flex pb-12"><img
                                                                            src="{{asset('assets/images/icon/upload-img-1.svg')}}"
                                                                            alt=""/></div>
                                                                    <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                                                </div>
                                                                <label for="zImageUpload"
                                                                       class="form-label">{{__('Page Breadcrumb Background')}}
                                                                    <span class="text-mime-type">(jpg,jpeg,png)</span> <span
                                                                        class="text-danger">*</span></label>
                                                                <div class="upload-img-box">
                                                                    @if(getOption('page_breadcrumb'))
                                                                        <img
                                                                            src="{{ getSettingImage('page_breadcrumb') }}"/>
                                                                    @else
                                                                        <img src=""/>
                                                                    @endif
                                                                    <input type="file" name="page_breadcrumb"
                                                                           accept="image/*" onchange="previewFile(this)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Second Column -->
                                                <div class="col">
                                                    <div class="pb-4  pb-17">
                                                        <div class="primary-form-group">
                                                            <div
                                                                class="max-wp-100 primary-form-group-wrap zImage-upload-details">
                                                                <div class="zImage-inside">
                                                                    <div class="d-flex pb-12"><img
                                                                            src="{{asset('assets/images/icon/upload-img-1.svg')}}"
                                                                            alt=""/></div>
                                                                    <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                                                </div>
                                                                <label for="zImageUpload"
                                                                       class="form-label">{{__('Our Upcoming Events Background')}}
                                                                    <span
                                                                        class="text-mime-type">{{__('(jpg,jpeg,png)')}}</span>
                                                                    <span
                                                                        class="text-danger">*</span></label>
                                                                <div class="upload-img-box">
                                                                    @if(getOption('upcoming_events_background'))
                                                                        <img
                                                                            src="{{ getSettingImage('upcoming_events_background') }}"/>
                                                                    @else
                                                                        <img src=""/>
                                                                    @endif
                                                                    <input type="file" name="upcoming_events_background"
                                                                           accept="image/*"
                                                                           onchange="previewFile(this)">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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

