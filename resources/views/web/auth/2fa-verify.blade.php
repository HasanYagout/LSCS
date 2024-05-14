@extends('auth.layouts.app')

@push('title') {{ __('2fa Verify') }} @endpush

@section('content')
<div class="register-area">
    <div class="register-wrap">
        <div class="register-left section-bg-img"
            style="background-image: url({{ getSettingImage('login_left_image') }})">
            <div class="register-left-wrap">
                <a class="d-inline-block mb-26 max-w-150" href="{{route('login')}}"><img
                        src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>
                <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>
                <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>
            </div>
        </div>
        <div class="register-right">
            <div class="primary-form">
                <!-- Title -->
                <div class="pb-40">
                    <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('2FA Authentication') }}</h2>
                    <h4 class="fs-14 fw-400 lh-24">
                        {{ __('Hello') }} {{ auth()->user()->name }}, <br />
                        {{ __('Enter the verification code generated by your mobile application (Google Authenticator)')
                        }}
                    </h4>
                </div>
                <!-- Form -->
                <form action="{{ route('google2fa.authenticate.verify.action') }}" method="post">
                    @csrf
                    <div class="pb-25">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="one_time_password" class="form-label">{{ __('Enter your authentication
                                    code') }}</label>
                                <input type="text" required class="primary-form-control" name="one_time_password" id="one_time_password"
                                    placeholder="" />
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{
                        __('Next') }}</button>
                </form>
                <h4 class="fs-14 fw-400 lh-24 pt-25">{{ __('If you lost your phone or uninstall the google authenticator
                    app and enable to access your account please contact with us.') }}</h4>
            </div>
        </div>
    </div>
</div>
@endsection