@extends('company.auth.layouts.app')
@push('title')
    {{ __('Register') }}
@endpush

@section('content')
    <div class="register-area" style="background-image: url('{{ asset('public/frontend/images/community-bg-1.png') }}');

        <div class="register-wrap>
{{--            <div class="register-left section-bg-img"--}}
{{--                style="background-image: url({{ getSettingImage('login_left_image') }})">--}}
{{--                <div class="register-left-wrap">--}}
{{--                    <a class="d-inline-block mb-26 max-w-150" href="{{ route('index') }}"><img--}}
{{--                            src="{{ getSettingImage('app_logo') }}" alt="{{ getOption('app_name') }}" /></a>--}}
{{--                    <h2 class="fs-36 fw-600 lh-34 text-white pb-8">{{ getOption('sign_up_left_text_title') }}</h2>--}}
{{--                    <p class="fs-16 fw-400 lh-24 text-white">{{ getOption('sign_up_left_text_subtitle') }}</p>--}}
{{--                </div>--}}
{{--            </div>--}}
            <div class="register-right"style="border: 5px solid darkblue; border-radius: 10px; padding: 50px;background-color: white;>
                <div class="primary-form>
                    <!-- Title -->
                    <div class="pb-40">
                        <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Create Account') }}</h2>
{{--                        <h4 class="fs-16 fw-400 lh-25">{{ __('Already have an account?') }} <a href="{{ route('login') }}"--}}
{{--                                class="text-decoration-underline fw-500 text-black hover-color-one">{{__('Sign In')}}</a></h4>--}}
                    </div>
                    <!-- Form -->
                    <form action="{{ route('company.auth.store') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-wrap pb-25">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="fullName" class="form-label">{{ __('Full Name') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="text" class="primary-form-control" id="fullName"
                                        value="{{ old('name') }}" name="name" placeholder="{{ __('Name') }}" />
                                </div>
                                @error('name')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="PhoneNumber" class="form-label">{{ __('Phone Number') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="text" class="primary-form-control" id="PhoneNumber"
                                        value="{{ old('mobile') }}" name="mobile"
                                        placeholder="{{ __('eg: (+880) 1754936599') }}" />
                                </div>
                                @error('mobile')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="EmailAddress" class="form-label">{{ __('Email Address') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="email" class="primary-form-control" id="EmailAddress"
                                        value="{{ old('email') }}" name="email" placeholder="{{ __('example@example.com') }}" />
                                </div>
                                @error('email')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="attachmentFile" class="form-label">{{ __('Attachment') }} (PDF)
                                        @if (getOption('register_file_required', 0))
                                            <span class="text-danger"> *</span>
                                        @endif
                                    </label>
                                    <input type="file" class="primary-form-control" id="attachmentFile"
                                        accept="application/pdf" name="proposal"
                                        @if (getOption('register_file_required', 0)) @endif />
                                </div>
                                @error('proposal')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>



                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Password" class="form-label">{{ __('Password') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="password" class="primary-form-control" id="Password" name="password"
                                        placeholder="********" />
                                </div>
                                @error('password')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="ConfirmPassword" class="form-label">{{ __('Confirm Password') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="password" class="primary-form-control" id="ConfirmPassword"
                                        name="password_confirmation" placeholder="********" />
                                </div>
                                @error('password_confirmation')
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
                        <button type="submit"
                            class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Sign Up') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
