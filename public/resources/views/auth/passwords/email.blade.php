@extends('auth.layouts.app')

@push('title')
    {{ __('Forget Password') }}
@endpush

@section('content')
    <div class="register-area">
        <div class="register-wrap">
            <div class="register-left section-bg-img"
                style="background-image: url({{ getSettingImage('login_left_image') }})">
                <div class="register-left-wrap">
                    <a class="d-inline-block mb-26 max-w-150" href="{{ route('index') }}"><img
                            src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>
                    <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>
                    <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>
                </div>
            </div>
            <div class="register-right">
                <div class="primary-form">
                    <!-- Title -->
                    <div class="pb-40">
                        <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Forgot Password') }}</h2>
                        @if (getOption('disable_registration') != 1)
                            <h4 class="fs-16 fw-400 lh-25">{{ __('Don’t have an account?') }} <a
                                    href="{{ route('register') }}"
                                    class="text-decoration-underline fw-500 text-black hover-color-one">{{ __('Sign up') }}</a>
                            </h4>
                        @endif
                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="pb-25">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="EmailAddress" class="form-label">{{ __('Email Address') }}</label>
                                    <input type="text" class="primary-form-control" id="EmailAddress" name="email"
                                        value="{{ old(' email') }}" placeholder="{{ __(' Your Email') }}" required />
                                </div>
                                @error('email')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit"
                            class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Continue') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
