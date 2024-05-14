@extends('layouts.app')
@push('title')
    {{ __('Setting') }}
@endpush
@section('content')
    <!-- Content -->
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Settings') }}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Tab List -->
                <ul class="nav nav-tabs zTabHead" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="security-tab" data-bs-toggle="tab"
                                data-bs-target="#security-tab-pane" type="button" role="tab"
                                aria-controls="security-tab-pane" aria-selected="true">{{ __('Security') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="changePassword-tab" data-bs-toggle="tab"
                                data-bs-target="#changePassword-tab-pane" type="button" role="tab"
                                aria-controls="changePassword-tab-pane"
                                aria-selected="false">{{ __('Change Password') }}</button>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content zTabContent" id="myTabContent">
                    <div class="tab-pane fade show active" id="security-tab-pane" role="tabpanel"
                         aria-labelledby="security-tab" tabindex="0">
                        <div class="max-w-840">
                            <ul class="securityList">
                                @if (!empty(getOption('two_factor_googleauth_status')) && getOption('two_factor_googleauth_status') == STATUS_ACTIVE)
                                    <li class="d-flex justify-content-between align-items-center">
                                        <div class="">
                                            <h4 class="fs-18 fw-500 lh-28 text-1b1c17">
                                                {{ __('Google Authentication (Recommended)') }}</h4>
                                            <p class="fs-14 fw-400 lh-22 text-707070">
                                                {{ __('Protect your account and transactions.') }}</p>
                                        </div>

                                        @if (auth()->user()->google_auth_status == 1)
                                            <button class="zBtn-one" data-bs-toggle="modal"
                                                    data-bs-target="#googleAuthDisableModal">{{ __('Disable') }}</button>
                                        @else
                                            <button class="zBtn-one active" data-bs-toggle="modal"
                                                    data-bs-target="#googleAuthEnableModal">{{ __('Enable') }}</button>
                                        @endif
                                    </li>
                                @endif
                                <li class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <h4 class="fs-18 fw-500 lh-28 text-1b1c17">{{ __('Phone Number Verification') }}
                                        </h4>
                                        <p class="fs-14 fw-400 lh-22 text-707070">
                                            {{ auth()->user()->mobile }}
                                        </p>
                                    </div>
                                    @if (auth()->user()->phone_verification_status == 1)
                                        <button type="button" class="zBtn-one active">{{__('Verified')}}</button>
                                    @else
                                        <button href="" class="zBtn-one" data-bs-toggle="modal"
                                                data-bs-target="#phoneVerificationModal">{{ __('Verify') }}</button>
                                    @endif
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <h4 class="fs-18 fw-500 lh-28 text-1b1c17">{{ __('Email Address verification') }}
                                        </h4>
                                        <p class="fs-14 fw-400 lh-22 text-707070">
                                            @if (auth()->user()->email_verification_status == 1)
                                                {{ auth()->user()->email }}
                                            @else
                                                {{ __('Protect your account and transactions.') }}
                                            @endif
                                        </p>
                                    </div>
                                    @if (auth()->user()->email_verification_status == 1)
                                        <button type="button" class="zBtn-one active">{{ __('Verified') }}</button>
                                    @else
                                        <a href="{{ route('email.verify', auth()->user()->verify_token) }}"
                                           class="zBtn-one">{{ __('Verify') }}</a>
                                    @endif
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <h4 class="fs-18 fw-500 lh-28 text-1b1c17">
                                            {{ __('Show Email Address In Public Profile') }}</h4>
                                    </div>
                                    <div class="zCheck form-check form-switch">
                                        <input class="form-check-input"
                                               onchange="changeSettingStatus(this,'show_email_in_public')" value="1"
                                               {{ auth()->user()->show_email_in_public == STATUS_ACTIVE ? 'checked' : '' }}
                                               type="checkbox" role="switch" id="show-email-switch">
                                        <label class="form-check-label" for="show-email-switch"></label>
                                    </div>
                                </li>
                                <li class="d-flex justify-content-between align-items-center">
                                    <div class="">
                                        <h4 class="fs-18 fw-500 lh-28 text-1b1c17">
                                            {{ __('Show Phone Number In Public Profile') }}</h4>
                                    </div>
                                    <div class="zCheck form-check form-switch">
                                        <input class="form-check-input"
                                               onchange="changeSettingStatus(this,'show_phone_in_public')" value="1"
                                               {{ auth()->user()->show_phone_in_public == STATUS_ACTIVE ? 'checked' : '' }}
                                               type="checkbox" role="switch" id="show-mobile-switch">
                                        <label class="form-check-label" for="show-mobile-switch"></label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="changePassword-tab-pane" role="tabpanel"
                         aria-labelledby="changePassword-tab" tabindex="0">
                        <div class="max-w-840">
                            <div class="pb-35">
                                <h4 class="fs-18 fw-600 lh-24 text-1b1c17 pb-4">{{ __('Change Password') }}</h4>
                                <p class="fs-14 fw-400 lh-24 text-707070">{{ __('Change or reset your account password') }}
                                </p>
                            </div>
                            <form class="ajax reset" action="{{ route('change-password') }}" data-handler="commonResponseRedirect" data-redirect-url="{{route('settings')}}" method="POST">
                                @csrf
                                <div class="form-wrap">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="currentPassword"
                                                   class="form-label">{{ __('Current Password') }}</label>
                                            <input type="password" name="current_password" class="primary-form-control"
                                                   id="currentPassword"
                                                   placeholder="{{ __('Enter Current Password') }}"/>
                                        </div>
                                    </div>
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="newPassword" class="form-label">{{ __('New Password') }}</label>
                                            <input type="password" name="password" class="primary-form-control"
                                                   id="newPassword" placeholder="{{ __('Enter New Password') }}"/>
                                        </div>
                                    </div>
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="confirmPassword"
                                                   class="form-label">{{ __('Confirm Password') }}</label>
                                            <input type="password" name="password_confirmation"
                                                   class="primary-form-control" id="confirmPassword"
                                                   placeholder="{{ __('Confirm Password') }}"/>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                        class="mt-30 py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save Now') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" id="statusChangeRoute" value="{{ route('setting_update') }}">
    <!-- Enable Authentication Modal -->
    <div class="modal fade zModalOne" id="googleAuthEnableModal" tabindex="-1"
         aria-labelledby="googleAuthEnableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content zModalOne-content">
                <div class="modal-body zModalOne-body">
                    <!-- Left -->
                    <div class="left">
                        <div class="max-w-408">
                            <h4 class="fs-24 fw-500 lh-38 text-black pb-9">{{__('Enable 2FA Authentication')}}</h4>
                            <p class="fs-14 fw-400 lh-22 text-707070 pb-6"><span class="text-1b1c17 fw-700">{{__('Step 1')}}
                                    :</span> {{__('Install this app from')}}<a
                                    href="https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2"
                                    target="__blank" class="text-1b1c17 text-decoration-underline fw-700">{{__('google play store')}}</a> {{__('or')}} <a href="https://itunes.apple.com/us/app/google-authenticator/id388497605"
                                    target="__blank" class="text-1b1c17 text-decoration-underline fw-700">{{__('App store')}}</a></p>
                            <p class="fs-14 fw-400 lh-22 pb-10"><span class="text-1b1c17 fw-700">{{__('Step 2 ')}}:</span> {{__('Scan the below QR code by your google authenticator app, or you can add account manually.')}}</p>
                            <p class="fs-14 fw-700 lh-22 text-1b1c17 pb-10">{{__('Manually Add Account:')}}</p>
                            <p class="fs-14 fw-700 lh-22 text-1b1c17 pb-10">{{__('Account Name : ')}} {{ getOption('app_name') }}</p>
                            <p class="fs-14 fw-700 lh-22 text-1b1c17 pb-20">{{__('Key')}} : {{ auth()->user()->google2fa_secret }}
                            </p>
                            <!-- Form -->
                            <form class="ajax reset" action="{{ route('google2fa.authenticate.enable') }}"
                                  method="post" data-handler="commonResponseForModal">
                                @csrf
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="authenticationCode" class="form-label">{{__('Enter google authenticator code')}}</label>
                                        <input required type="text" name="one_time_password" class="primary-form-control"
                                               id="authenticationCode" placeholder="{{ __('Enter the code to verify') }}"/>
                                    </div>
                                </div>
                                <button
                                    class="mt-20 bd-ra-12 bg-cdef84 border-0 fs-15 fw-500 hover-bg-one lh-25 px-26 py-13 text-black">{{__('Confirm 2FA')}}</button>
                            </form>
                            <p class="fs-15 fw-500 lh-25 text-ea4335 pt-20">{{__('Note : If you lost your phone or uninstall the
                                google authenticator app, then you will lost access of your account.')}}</p>
                        </div>
                    </div>
                    <!-- Right -->
                    <div class="right">
                        <div class="mClose">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                                    src="assets/images/icon/delete.svg" alt=""/></button>
                        </div>
                        <div class="qr-code text-center pt-76">
                            <img src="{{ $qr_code }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Disable Authentication Modal -->
    <div class="modal fade zModalOne" id="googleAuthDisableModal" tabindex="-1"
         aria-labelledby="googleAuthDisableModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalOne-content">
                <div class="modal-body p-4">
                    <div class="max-w-408">
                        <h4 class="fs-24 fw-500 lh-38 text-black pb-9">{{__('Disable 2FA Authentication')}}</h4>
                        <div class="card-body">
                            <form class="ajax reset" action="{{ route('google2fa.authenticate.disable') }}"
                                  method="post" data-handler="commonResponseForModal">
                                @csrf
                                <div class="pb-20 pt-10 primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="authenticationCodeDisable"
                                               class="form-label">{{ __('Enter google authenticator
                                                                                                                                                                                                                                                                                                                                                                                                                                                    code') }}</label>
                                        <input type="text" class="primary-form-control" name="one_time_password"
                                               id="authenticationCodeDisable"
                                               placeholder="{{ __('Enter the code to verify') }}"/>
                                    </div>
                                </div>
                                <button type="submit"
                                        class="bd-ra-12 bg-cdef84 border-0 fs-15 fw-500 hover-bg-one lh-25 px-26 py-13 text-black">{{ __('Disable 2FA') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Phone Verification Modal -->
    <div class="modal fade zModalOne" id="phoneVerificationModal" tabindex="-1"
         aria-labelledby="phoneVerificationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalOne-content">
                <div class="modal-body p-4">
                    <div class="max-w-408">
                        <h4 class="fs-24 fw-500 lh-38 text-black pb-9">{{ __('Phone Verification') }}</h4>
                        <div class="card-body">
                            <!-- Phone Number Verification -->
                            <div class="card-body">
                                <span class="send-otp-section">
                                    <div class="card-text mt-4">
                                        <form class="ajax reset" action="{{ route('phone.verification.sms.send') }}"
                                              method="post" data-handler="responseForSendSMS">
                                            @csrf
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="mobileNumber" class="form-label">{{ __('Mobile Number') }} </label>
                                                    <input readonly class="primary-form-control" id="mobileNumber" type="text" name="phone_no"
                                                           value="{{ auth()->user()->mobile != null ? auth()->user()->mobile : '' }}">
                                                </div>
                                                <span class="fs-12 text-b0b0b0">{{ __('Be sure you number is valid and have the country code') }}</span>
                                            </div>

                                            <div class="d-block mt-3">
                                                <button class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one border-0"
                                                        type="submit">{{ __("Send SMS") }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </span>

                                <span class="verify-otp-section d-none">
                                    <p class="label-text-title color-heading font-medium mb-2 font-14">
                                        {{ __('Confirm OTP') }}
                                    </p>
                                    <p class="bg-0fa958-10 p-1 rounded-2 w-100">{{ __('Please do not close the modal') }}</p>
                                    <div class="card-text mt-4">
                                        <form class="ajax reset otp-form" action="{{ route('phone.verification.sms.verify') }}" method="post" data-handler="commonResponseForModal">
                                            @csrf
                                            <div class="otp-input-fields" id="otp-block">
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__1" />
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__2" />
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__3" />
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__4" />
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__4" />
                                                <input type="text" class="otp-field h-48 otp__digit" name="opt_field[]" maxlength="1" required class="otp__digit otp__field__4" />
                                            </div>

                                            <!-- Store OTP Value -->
                                            <input class="otp-value" type="hidden" name="opt-value">
                                            <div class="d-block mt-3">
                                                <button type="button"
                                                        class="bd-ra-12 border-0 fs-12 hover-bg-one p-2 text-black resend-otp">{{ __("Resend Code") }}</button>
                                                <input type="hidden" name=""
                                                       value="{{ route('phone.verification.sms.resend') }}"
                                                       id="resendRoute">
                                                <button class="zBtn-one active"
                                                        type="submit">{{ __('Confirm') }}</button>
                                            </div>
                                        </form>
                                    </div>
                                </span>

                            </div>
                            <!-- Phone Number Verification -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script src="{{ asset('admin/js/configuration.js') }}"></script>
    <script src="{{ asset('alumni/js/phone-verification.js') }}"></script>
@endpush
