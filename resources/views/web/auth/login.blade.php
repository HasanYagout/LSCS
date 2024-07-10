@extends('web.auth.layouts.app')

@push('title')
    {{ __('Login') }}
@endpush

@section('content')
    <div class="register-area"
         style="background-image: url('{{ asset('public/frontend/images/community-bg-1.png') }}')">
        <div class="">
{{--            <div class="register-left section-bg-img"--}}
{{--                style="background-image: url({{ getSettingImage('login_left_image') }})">--}}
{{--                <div class="register-left-wrap">--}}
{{--                    <a class="d-inline-block mb-26 max-w-150" href="{{ route('index') }}"><img--}}
{{--                            src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>--}}
{{--                    <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>--}}
{{--                    <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
    <div class="register-right bg-white container pd register-right rounded-5 s shadow-lg" style=" padding: 50px;)">
                <div class="primary-form">
                    <!-- Title -->
                    <div class="pb-40">
                        <h2 class="fs-32 fw-600 lh-38 text-secondary-color pb-3">{{ __('Log In') }}</h2>
                        @if (getOption('disable_registration') != 1)
{{--                            <h4 class="fs-16 fw-400 lh-25">{{ __('Don’t have an account?') }} <a--}}
{{--                                    href="{{ route('register') }}"--}}
{{--                                    class="text-decoration-underline fw-500 text-black hover-color-secondary">{{ __('Sign up') }}</a>--}}
{{--                            </h4>--}}
                        @endif

                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('alumni.auth.submit') }}">
                        @csrf
                        <div class="form-wrap pb-14">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">

                                    <label for="id" class="form-label text-secondary-color">{{ __('Student Id') }}</label>
                                    <input type="number" class="primary-form-control rounded-3" id="id" name="id"
                                    value="{{ old('id') }}" placeholder="{{ __(' Your ID') }}" required />
                                </div>
                                @error('id')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Password" class="form-label text-secondary-color">{{__('Password')}}</label>
                                    <div class="input-group position-relative">
                                        <input type="password" class="primary-form-control rounded-3" id="Password" name="password" placeholder="********" required />
                                        <button type="button" class="btn hover-color-secondary btn-outline-secondary bg-transparent border-0 btn btn-outline-secondary h-100 position-absolute toggle-password top-0 toggle-password end-0" aria-label="Show Password">
                                            <i class="fa fa-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                @error('password')
                                <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit"
                            class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Log In') }}</button>
                    </form>

                </div>

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
