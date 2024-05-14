@extends('auth.layouts.app')
@push('title')
    {{ __('Reset Password') }}
@endpush
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
                    <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Set your new password') }}</h2>
                </div>
                <!-- Form -->
                 <!-- Form -->
                 <form method="POST" action="{{ route('password.update', $token) }}">
                    @csrf
                    <div class="pb-25">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="EmailAddress" class="form-label">{{ __('Email Address') }}</label>
                                <input type="text" class="primary-form-control" id="EmailAddress" name="email"
                                    value="{{ old(" email") }}" placeholder="{{ __(" Your Email") }}" required />
                            </div>
                            @error('email')
                            <span class="fs-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="pb-25">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="password" class="form-label">{{ __('New Password') }}</label>
                                <input type="password" class="primary-form-control" id="password" name="password"
                                    value="{{ old("password") }}" placeholder="{{ __(" Your New Password") }}" required />
                            </div>
                            @error('password')
                            <span class="fs-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="pb-25">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                <input type="password" class="primary-form-control" id="password_confirmation" name="password_confirmation"
                                    value="{{ old("password_confirmation") }}" placeholder="{{ __(" Your Confirm Password") }}" required />
                            </div>
                            @error('password_confirmation')
                            <span class="fs-12 text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{
                        __('Update') }}</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
