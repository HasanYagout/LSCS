@extends('admin.auth.layouts.app')

@push('title')
    {{ __('Login') }}
@endpush

@section('content')
    <div class="register-area" style="background-image: url('{{ asset('public/frontend/images/community-bg-1.png') }}')">

    <div class="register-right bg-white container pd register-right rounded-5 s shadow-lg" style="padding: 50px;">

    <div class="primary-form">
                    <!-- Title -->
                    <div class="pb-40">
                        <h2 class="fs-32 fw-600 lh-38 text-secondary-color pb-3">{{ __('Log In') }}</h2>

                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('admin.auth.login') }}">
                        @csrf
                        <div class="form-wrap pb-14">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="EmailAddress" class="form-label text-secondary-color">{{ __('Email Address') }}</label>
                                    <input type="text" class="primary-form-control rounded-3" id="EmailAddress" name="email"
                                        value="{{ old(' email') }}" placeholder="{{ __(' Your Email') }}" required />
                                </div>
                                @error('email')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Password" class="form-label text-secondary-color">{{__('Password')}}</label>
                                    <div class="input-group position-relative">
                                        <input type="password" class="primary-form-control rounded-3" id="Password" name="password" placeholder="********" required />
                                        <button type="button" class="btn hover-color-secondary btn-outline-secondary bg-transparent border-0 btn btn-outline-secondary h-100 position-absolute  toggle-password top-0 toggle-password end-0" aria-label="Show Password">
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
