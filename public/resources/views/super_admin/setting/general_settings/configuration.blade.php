@extends('super_admin.layouts.app')
@push('super_admin-style')
    <link rel="stylesheet" href="{{ asset('super_admin/styles/main.css') }}">
@endpush
@push('title')
    {{ $title }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
            <div class="row">
                <div class="col-12">
                    <div class="email-inbox__area bg-style form-horizontal__item bg-style admin-general-settings-page">
                        <input type="hidden" id="statusChangeRoute"
                            value="{{ route('super_admin.setting.configuration-settings.update') }}">
                        <input type="hidden" id="configureUrl"
                            value="{{ route('super_admin.setting.configuration-settings.configure') }}">
                        <input type="hidden" id="helpUrl"
                            value="{{ route('super_admin.setting.configuration-settings.help') }}">
                        <form class="ajax" action="{{ route('super_admin.setting.configuration-settings.update') }}"
                            method="POST" enctype="multipart/form-data" data-handler="settingCommonHandler">
                            @csrf

                            <div class="row">
                                <div class="col-md-12 bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                                    <div class="table-responsive zTable-responsive">
                                        <table class="table zTable">
                                            <thead>
                                                <tr>
                                                    <th class="min-w-160">
                                                        <div>{{ __('Extension') }}</div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div>{{ __('Status') }}<div>
                                                    </th>
                                                    <th class="text-center">
                                                        <div>{{ __('Action') }}<div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('Email Verification') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable Email
                                                                                                                                                                                                                                            Verification, new user have to verify the email to access this
                                                                                                                                                                                                                                            system.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'email_verification_status')"
                                                                value="1"
                                                                {{ getOption('email_verification_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="email_verification_status" type="checkbox"
                                                                role="switch" id="email_verification_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button" class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('email_verification_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('email_verification_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('E-mail credentials status') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for sending email') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'app_mail_status')"
                                                                value="1"
                                                                {{ getOption('app_mail_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="app_mail_status" type="checkbox" role="switch"
                                                                id="app_mail_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2 hover-bg-three hover-color-white"
                                                                onclick="configureModal('app_mail_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('app_mail_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('SMS credentials status') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for sending sms') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'app_sms_status')"
                                                                value="1"
                                                                {{ getOption('app_sms_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="app_sms_status" type="checkbox" role="switch"
                                                                id="app_sms_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button" class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('app_sms_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('app_sms_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('Pusher credentials status') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for pusher') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'pusher_status')"
                                                                value="1"
                                                                {{ getOption('pusher_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="pusher_status" type="checkbox" role="switch"
                                                                id="pusher_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('pusher_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('pusher_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Social Login (Google)') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for Google. User can use our gmail account
                                                                                                                                                                                                                                            and sign in') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'google_login_status')"
                                                                value="1"
                                                                {{ getOption('google_login_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="google_login_status" type="checkbox" role="switch"
                                                                id="google_login_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('google_login_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('google_login_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Social Login (Facebook)') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for Facebook. User can use our facebook
                                                                                                                                                                                                                                            account and sign in') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'facebook_login_status')"
                                                                value="1"
                                                                {{ getOption('facebook_login_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="facebook_login_status" type="checkbox"
                                                                role="switch" id="facebook_login_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('facebook_login_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('facebook_login_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Google Recaptcha Credentials') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for google recaptcha credentials') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'google_recaptcha_status')"
                                                                value="1"
                                                                {{ getOption('google_recaptcha_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="google_recaptcha_status" type="checkbox"
                                                                role="switch" id="google_recaptcha_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2"
                                                                onclick="configureModal('google_recaptcha_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('google_recaptcha_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Google Analytics') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The system will enable for google analytics. ') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'google_analytics_status')"
                                                                value="1"
                                                                {{ getOption('google_analytics_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="google_analytics_status" type="checkbox"
                                                                role="switch" id="google_analytics_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2 hover-bg-three hover-color-white"
                                                                onclick="configureModal('google_analytics_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('google_analytics_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Cookie Consent') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for cookie consent settings. User Can manage
                                                                                                                                                                                                                                            cookie consent setting') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'cookie_status')"
                                                                value="1"
                                                                {{ getOption('cookie_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="cookie_status" type="checkbox" role="switch"
                                                                id="cookie_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-outline-success me-2 p-2 hover-bg-three hover-color-white"
                                                                onclick="configureModal('cookie_status')"
                                                                title="{{ __('Configure') }}">
                                                                {{ __('Configure') }}
                                                            </button>
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('cookie_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('Google 2fa') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for google 2fa. By wearing it you will know
                                                                                                                                                                                                                                            how this setting works') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'two_factor_googleauth_status')"
                                                                value="1"
                                                                {{ getOption('two_factor_googleauth_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="two_factor_googleauth_status" type="checkbox"
                                                                role="switch" id="two_factor_googleauth_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('two_factor_googleauth_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('Register File Required') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for register file required approval. By
                                                                                                                                                                                                                                            wearing it you will know how this setting works.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'register_file_required')"
                                                                value="1"
                                                                {{ getOption('registration_approval') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="register_file_required" type="checkbox"
                                                                role="switch" id="register_file_required">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('register_file_required')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Preloader') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable preloader,
                                                                                                                                                                                                                                            the preloader will be show before load the content.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'app_preloader_status')"
                                                                value="1"
                                                                {{ getOption('app_preloader_status') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="app_preloader_status" type="checkbox"
                                                                role="switch" id="app_preloader_status">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('app_preloader_status')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Disable Registration') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for disable registration. By wearing it you
                                                                                                                                                                                                                                            will know how this setting works') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'disable_registration')"
                                                                value="1"
                                                                {{ getOption('disable_registration') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="disable_registration" type="checkbox"
                                                                role="switch" id="disable_registration">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('disable_registration')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr class="d-none">
                                                    <td>
                                                        <h6>{{ __('Registration Approval') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for registration approval. By wearing it you
                                                                                                                                                                                                                                            will know how this setting works.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'registration_approval')"
                                                                value="1"
                                                                {{ getOption('registration_approval') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="registration_approval" type="checkbox"
                                                                role="switch" id="registration_approval">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('registration_approval')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('Show Language Switcher') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this. The
                                                                                                                                                                                                                                            system will enable for show language switcher. By wearing it you
                                                                                                                                                                                                                                            will know how this setting works.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'show_language_switcher')"
                                                                value="1"
                                                                {{ getOption('show_language_switcher') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="show_language_switcher" type="checkbox"
                                                                role="switch" id="show_language_switcher">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('show_language_switcher')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <h6>{{ __('App Debug') }}</h6>
                                                        <small
                                                            class="fst-italic fw-normal">({{ __('If you enable this.No
                                                                                                                                                                                                                                            warning message will be shown for any error. By wearing it you
                                                                                                                                                                                                                                            will know how this setting works.') }}
                                                            )</small>
                                                    </td>
                                                    <td class="text-center pt-17">
                                                        <div class="zCheck form-switch">
                                                            <input class="form-check-input mt-0"
                                                                onchange="changeSettingStatus(this,'app_debug')"
                                                                value="1"
                                                                {{ getOption('app_debug') == STATUS_ACTIVE ? 'checked' : '' }}
                                                                name="app_debug" type="checkbox" role="switch"
                                                                id="app_debug">
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="action__buttons d-flex justify-content-end">
                                                            <button type="button"
                                                                class="btn btn-action btn-outline-dark p-2"
                                                                onclick="helpModal('app_debug')"
                                                                title="{{ __('Help') }}">
                                                                {{ __('Help') }}
                                                            </button>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Configuration section start -->
    <div class="modal fade main-modal" id="configureModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content zModalTwo-content p-5">

            </div>
        </div>
    </div>

    <!-- Configuration section end -->
    <!-- Help section start -->
    <div class="modal fade main-modal" id="helpModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content zModalTwo-content p-5">

            </div>
        </div>
    </div>
    <!-- Help section end -->

    <!-- Test Email section start -->
    <div class="modal fade" id="sendTestMail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content p-5">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Test Mail') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form method="POST" action="{{ route('super_admin.setting.mail.test') }}">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{ __('Recipient') }}:</label>
                            <input type="email" name="to" class="form-control" id="to"
                                placeholder="{{ __('Recipient Mail') }}" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{ __('Subject') }}:</label>
                            <input type="text" name="subject" class="form-control" id="to"
                                placeholder="{{ __('Subject') }}" value="Test Mail" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="message" class="col-form-label">{{ __('Your Message') }}:</label>
                            <textarea name="message" class="form-control" id="message-text">{{ __('Hi, This is a test mail') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer button__list">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit"
                            class="border-0 fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one mx-2">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- TEST EMail section end -->

    <!-- TEST SMS section start -->
    <div class="modal fade" id="sendTestSMS" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content p-5">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ __('Test SMS') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="ajax reset" action="{{ route('super_admin.setting.sms.test') }}" method="post"
                    enctype="multipart/form-data" data-handler="commonResponseForModal">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3 text-black">
                            <label for="to" class="col-form-label">{{ __('Recipient Number') }}:</label>
                            <input type="text" name="to" class="form-control" id="to"
                                placeholder="{{ __('Recipient Number') }}" required>
                        </div>
                        <div class="mb-3 text-black">
                            <label for="message" class="col-form-label">{{ __('Your Message') }}:</label>
                            <textarea name="message" class="form-control" id="message-text">{{ __('Hi, This is a test sms') }}</textarea>
                        </div>
                    </div>
                    <div class="modal-footer button__list">
                        <button type="button" class="btn btn-light"
                            data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="submit"
                            class="border-0 fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one mx-2">{{ __('Send') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- TEST SMS section end -->
@endsection
@push('script')
    <script src="{{ asset('super_admin/custom-js/configuration.js') }}"></script>
@endpush
