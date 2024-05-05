@extends('super_admin.layouts.app')
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
                        @include('super_admin.setting.partials.general-sidebar')
                    </div>
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                            <div class="item-top mb-30">
                                <h4>{{ $title }}</h4>
                            </div>
                            <form class="ajax" action="{{ route('super_admin.setting.application-settings.update') }}"
                                method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                                @csrf
                                <div class="row">
                                    @if(isAddonInstalled('ALUSAAS'))
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('App Name') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="">
                                                    <input type="text" name="app_name"
                                                        value="{{ getOption('app_name') }}" class="primary-form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('App Email') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="app_email" value="{{ getOption('app_email') }}"
                                                    class="primary-form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('App Contact Number') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="app_contact_number"
                                                    value="{{ getOption('app_contact_number') }}"
                                                    class="primary-form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('App Location') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="app_location"
                                                    value="{{ getOption('app_location') }}" class="primary-form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('App Copyright') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="app_copyright"
                                                    value="{{ getOption('app_copyright') }}" class="primary-form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label class="form-label">{{ __('Developed By') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" name="app_developed"
                                                    value="{{ getOption('app_developed') }}" class="primary-form-control">
                                            </div>
                                        </div>
                                    </div>
                                    @if(isAddonInstalled('ALUSAAS'))
                                    <div class="col-xxl-4 col-lg-6">
                                        <div class="primary-form-group my-2 pt-3">
                                            <div class="primary-form-group-wrap">
                                                <label for="app_timezone" class="form-label">{{ __('Timezone') }} <span
                                                        class="text-danger">*</span></label>
                                                <select name="app_timezone" class="form-control sf-select">
                                                    @foreach ($timezones as $timezone)
                                                        <option value="{{ $timezone }}"
                                                            {{ $timezone == getOption('app_timezone') ? 'selected' : '' }}>
                                                            {{ $timezone }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input__group general-settings-btn text-end">
                                                <button type="submit"
                                                    class="bd-ra-12 bg-7f56d9 border-0 fw-500 lh-25 px-26 py-10">{{ __('Update') }}</button>
                                            </div>
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
