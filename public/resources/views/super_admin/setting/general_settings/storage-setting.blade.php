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
                            <div class="col-xxl-10 col-lg-9 col-md-8">
                                <div class="email-inbox__area bg-style">
                                    <div class="bg-dark-primary-soft-varient p-4 border-1">
                                        <h5>{{ __('Instructions') }}: </h5>
                                        <p>{{ __('You need to click on') }}
                                            <strong>{{ __(' "Storage Link"') }}</strong> {{ __(' button, after change ') }}
                                            <strong>{{ __('"Storage Driver"') }}</strong>
                                        </p>
                                        <div class="text-black mt-3">
                                            <a href="{{ route('super_admin.setting.storage.link') }}"
                                                class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-7f56d9 bd-ra-12">
                                                {{__('Storage Link')}}</a>
                                        </div>
                                    </div>
                                    <br>
                                    <form class="ajax" action="{{ route('super_admin.setting.storage.update') }}" method="POST"
                                        enctype="multipart/form-data" data-handler="settingCommonHandler">
                                        @csrf
                                        <div class="form-group text-black row mb-3">
                                            <div class="primary-form-group my-2 pt-3">
                                                <div class="primary-form-group-wrap">
                                                    <label for="STORAGE_DRIVER"
                                                        class="form-label">{{ __('Storage Driver') }}</label>
                                                    <select name="STORAGE_DRIVER" id="storage_driver"
                                                        class="form-control sf-select-without-search" required>
                                                        <option value="{{ STORAGE_DRIVER_PUBLIC }}"
                                                            {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_PUBLIC ? 'selected' : '' }}>
                                                            {{ __('Public') }}</option>
                                                        <option value="{{ STORAGE_DRIVER_AWS }}"
                                                            {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_AWS ? 'selected' : '' }}>
                                                            {{ __('AWS') }}</option>
                                                        <option value="{{ STORAGE_DRIVER_WASABI }}"
                                                            {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_WASABI ? 'selected' : '' }}>
                                                            {{ __('Wasabi') }}</option>
                                                        <option value="{{ STORAGE_DRIVER_VULTR }}"
                                                            {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_VULTR ? 'selected' : '' }}>
                                                            {{ __('Vultr') }}</option>
                                                        <option value="{{ STORAGE_DRIVER_DO }}"
                                                            {{ env('STORAGE_DRIVER') == STORAGE_DRIVER_DO ? 'selected' : '' }}>
                                                            {{ __('Digital Ocean (DO)') }}</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none storage-driver" id="aws">
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('AWS Access Key ID') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="AWS_ACCESS_KEY_ID"
                                                                value="{{ env('AWS_ACCESS_KEY_ID') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('AWS Secret Access Key') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="AWS_SECRET_ACCESS_KEY"
                                                                value="{{ env('AWS_SECRET_ACCESS_KEY') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('AWS Default Region') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="AWS_DEFAULT_REGION"
                                                                value="{{ env('AWS_DEFAULT_REGION') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('AWS Bucket') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="AWS_BUCKET"
                                                                value="{{ env('AWS_BUCKET') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none storage-driver" id="wasabi">
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('WAS Access Key ID') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="WASABI_ACCESS_KEY_ID"
                                                                value="{{ env('WASABI_ACCESS_KEY_ID') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('WAS Secret Access Key') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="WASABI_SECRET_ACCESS_KEY"
                                                                value="{{ env('WASABI_SECRET_ACCESS_KEY') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('WAS Default Region') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="WASABI_DEFAULT_REGION"
                                                                value="{{ env('WASABI_DEFAULT_REGION') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('WAS Bucket') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="WASABI_BUCKET"
                                                                value="{{ env('WASABI_BUCKET') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="d-none storage-driver" id="vultr">
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('VULTR Access Key') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="VULTR_ACCESS_KEY_ID"
                                                                value="{{ env('VULTR_ACCESS_KEY') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('VULTR Secret Key') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="VULTR_SECRET_ACCESS_KEY"
                                                                value="{{ env('VULTR_SECRET_KEY') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('VULTR Region') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="VULTR_DEFAULT_REGION"
                                                                value="{{ env('VULTR_REGION') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('VULTR Bucket') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="VULTR_BUCKET"
                                                                value="{{ env('VULTR_BUCKET') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="d-none storage-driver" id="do">
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO Access Key ID') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_ACCESS_KEY_ID"
                                                                value="{{ env('DO_ACCESS_KEY_ID') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO Secret Access Key') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_SECRET_ACCESS_KEY"
                                                                value="{{ env('DO_SECRET_ACCESS_KEY') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO Default Region') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_DEFAULT_REGION"
                                                                value="{{ env('DO_DEFAULT_REGION') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO Bucket') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_BUCKET"
                                                                value="{{ env('DO_BUCKET') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO Folder') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_FOLDER"
                                                                value="{{ env('DO_FOLDER') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row input__group mb-25">
                                                <label class="col-lg-3 p-25">{{ __('DO CDN ID') }} <span
                                                        class="text-danger">*</span></label>
                                                <div class="col-lg-9">
                                                    <div class="primary-form-group mt-2">
                                                        <div class="primary-form-group-wrap">
                                                            <input type="text" name="DO_CDN_ID"
                                                                value="{{ env('DO_CDN_ID') }}"
                                                                class="primary-form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="justify-content-end row text-end">
                                            <div class="col-12">
                                                <div class="input__group general-settings-btn">
                                                    <button type="submit"
                                                        class="bd-ra-12 bg-7f56d9 border-0 fw-500 lh-25 px-26 py-10">{{ __('Update') }}</button>
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
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('super_admin/custom-js/storage-settings.js') }}"></script>
@endpush
