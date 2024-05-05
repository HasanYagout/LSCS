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
                            <div class="bg-scroll-thumb p-4 border-1">
                                <h5>{{ __('Instructions') }}: </h5>
                                <p>{{ __('You need to follow some instruction after maintenance mode changes. Instruction list given below-') }}
                                </p>
                                <div class="text-black">
                                    <li>{{ __('If you select maintenance mode') }} <b>{{ __('Maintenance O') }}n</b>,
                                        {{ __("you need to input secret key for maintenance work. Otherwise you can't work this website. And your created secret key helps you to work under
                                                                                                                                                            maintenance.") }}
                                    </li>
                                    <li>{{ __('After created maintenance key, you can use this website secretly through this ur') }}
                                        l <span class="iconify" data-icon="arcticons:url-forwarder"></span> <span
                                            class="text-primary">{{ url('/') }}/(Your created secret key)</span></li>
                                    <li>{{ __("Only one time url is browsing with secret key, and you can browse your site in maintenance mode. When maintenance mode on, any user can see
                                                                                                                                                maintenance mode error message.") }}
                                    </li>
                                    <li>{{ __('Unfortunately you forget your secret key and try to connect with your website.') }}
                                        <br> {{ __('Then you go to your project folder location') }}
                                        <b>{{ __('Main Files') }}</b>{{ __('(where your file in cpanel or your hosting)') }}
                                        <span class="iconify"
                                            data-icon="arcticons:url-forwarder"></span><b>{{ __('storage') }}</b>
                                        <span class="iconify"
                                            data-icon="arcticons:url-forwarder"></span><b>{{ __('framework') }}</b>.
                                        {{ __('You can see 2 files and need to delete 2 files. Files are:') }}
                                        <br>
                                        {{ __('1. down') }} <br>
                                        {{ __('2. maintenance.php') }}
                                    </li>
                                </div>
                            </div>
                            <br>
                            <form class="ajax" action="{{ route('super_admin.setting.maintenance.change') }}" method="POST"
                                enctype="multipart/form-data" data-handler="settingCommonHandler">
                                @csrf
                                <div class="form-group text-black row mb-3">
                                    <label class="col-lg-3">{{ __('Maintenance Mode') }} <span
                                            class="text-danger">*</span></label>
                                    <div class="col-lg-9">
                                        <select name="maintenance_mode" id=""
                                            class="form-control maintenance_mode sf-select-without-search">
                                            <option value="">--{{ __('Select Option') }}--</option>
                                            <option value="1" @if (getOption('maintenance_mode') == 1) selected @endif>
                                                {{ __('Maintenance On') }}</option>
                                            <option value="2" @if (getOption('maintenance_mode') != 1) selected @endif>
                                                {{ __('Live') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group text-black row mb-3">
                                    <label class="col-lg-3">{{ __('Maintenance Mode Secret Key') }}</label>
                                    <div class="col-lg-9">
                                        <input type="text" name="maintenance_secret_key"
                                            value="{{ getOption('maintenance_secret_key') }}" minlength="6"
                                            class="form-control maintenance_secret_key py-16">
                                    </div>
                                </div>

                                <div class="form-group text-black row mb-3">
                                    <label class="col-lg-3">{{ __('Maintenance Mode Url') }} </label>
                                    <div class="col-lg-9">
                                        <input type="text" name="" value=""
                                            class="form-control maintenance_mode_url" disabled>
                                    </div>
                                </div>

                                <div class="justify-content-end row text-end">
                                    <div class="col-md-12">
                                        <button type="submit"
                                            class="fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12 float-right border-0">{{ __('Update') }}</button>
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
@push('script')
    <script>
        'use strict'
        let getUrl = "{{ url('') }}";
        const maintenanceSecretKey = "{{ getOption('maintenance_secret_key') }}";
        const maintenanceModeConst = "{{ getOption('maintenance_mode') }}";
    </script>
    <script src="{{ asset('super_admin/custom-js/maintenance-mode.js') }}"></script>
@endpush
