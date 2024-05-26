@extends('web.auth.layouts.app')

@push('title')
    {{ __('Login') }}
@endpush

@section('content')
    <div class="register-area">
        <div class="register-wrap">
{{--            <div class="register-left section-bg-img"--}}
{{--                style="background-image: url({{ getSettingImage('login_left_image') }})">--}}
{{--                <div class="register-left-wrap">--}}
{{--                    <a class="d-inline-block mb-26 max-w-150" href="{{ route('index') }}"><img--}}
{{--                            src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>--}}
{{--                    <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>--}}
{{--                    <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="register-right">
                <div class="primary-form">
                    <!-- Title -->
                    <div class="pb-40">
                        <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Log In') }}</h2>
                        @if (getOption('disable_registration') != 1)
{{--                            <h4 class="fs-16 fw-400 lh-25">{{ __('Don’t have an account?') }} <a--}}
{{--                                    href="{{ route('register') }}"--}}
{{--                                    class="text-decoration-underline fw-500 text-black hover-color-one">{{ __('Sign up') }}</a>--}}
{{--                            </h4>--}}
                        @endif

                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('auth.submit') }}">
                        @csrf
                        <div class="form-wrap pb-14">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">

                                    <label for="student_id" class="form-label">{{ __('Student Id') }}></label>
                                    <input type="number" class="primary-form-control" id="student_id" name="student_id"
                                                                           value="{{ old('student_id') }}" placeholder="{{ __(' Your ID') }}" required />
                                </div>
                                @error('student_id')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Password" class="form-label">{{__('Password')}}</label>
                                    <input type="password" class="primary-form-control" id="Password" name="password"
                                        placeholder="********" required />
                                </div>
                                @error('password')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if (!empty(getOption('google_recaptcha_status')) && getOption('google_recaptcha_status') == 1)
                                <div class="form-group{{ $errors->has('g-recaptcha-response') ? ' has-error' : '' }}">
                                    <div class="col-md-6">
                                        {!! RecaptchaV3::field('register') !!}
                                        @if ($errors->has('g-recaptcha-response'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
{{--                        <a href="{{ route('password.request') }}"--}}
{{--                            class="d-inline-block fs-12 fw-400 lh-22 text-707070 mb-25 hover-color-one">{{ __('Forgot your Password?') }}</a>--}}
                        <button type="submit"
                            class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Log In') }}</button>
                    </form>

                    @if (getOption('google_login_status') == 1 || getOption('facebook_login_status') == 1)
                        <!-- Another Sign In options -->
                        <h4 class="position-relative fs-12 fw-400 lh-22 text-707070 text-center mt-20 under-border-one">
                            <span class="bg-white position-relative px-5">{{ __('Or continue with') }}</span>
                        </h4>
                        <ul class="continue-btn-list">
                            @if (getOption('facebook_login_status') == 1)
                                <li>
                                    <a href="{{ route('facebook-login') }}" class="continue-btn">
                                        <img src="{{ asset('assets/images/facebook.svg') }}" alt="facebook" />
                                    </a>
                                </li>
                            @endif
                            @if (getOption('google_login_status') == 1)
                                <li>
                                    <a href="{{ route('google-login') }}" class="continue-btn">
                                        <img src="{{ asset('public/assets/images/google.svg') }}" alt="google" />
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>
                @if (env('LOGIN_HELP') == 'active')
                    <div class="row">
                        <div class="col-md-12 mb-25">
                            <div class="table-responsive login-info-table mt-3">
                                <table class="table table-bordered">
                                    <tbody>
                                        @if(isCentralDomain())
                                        <tr>
                                            <td colspan="2" id="superAdminCredentialShow" class="login-info">
                                                <b>Super Admin :</b> superadmin@gmail.com | 123456
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" id="adminCredentialShow" class="login-info">
                                                <b>Admin :</b> admin@gmail.com | 123456
                                            </td>
                                        </tr>
                                        @else
                                        <tr>
                                            <td colspan="2" id="adminCredentialShow" class="login-info">
                                                <b>Admin :</b> admin@gmail.com | 123456
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2" id="userCredentialShow" class="login-info">
                                                <b>Alumni :</b> alumni@gmail.com | 123456
                                            </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        "use strict"
        $('#adminCredentialShow').on('click', function() {
            $('#EmailAddress').val('admin@gmail.com');
            $('#Password').val('123456');
        });
        $('#superAdminCredentialShow').on('click', function() {
            $('#EmailAddress').val('superadmin@gmail.com');
            $('#Password').val('123456');
        });
        $('#userCredentialShow').on('click', function() {
            $('#EmailAddress').val('alumni@gmail.com');
            $('#Password').val('123456');
        });
    </script>
@endpush
