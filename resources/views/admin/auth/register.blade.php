@extends('auth.layouts.app')
@push('title')
    {{ __('Register') }}
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
                        <h2 class="fs-32 fw-600 lh-38 text-1b1c17 pb-3">{{ __('Create Account') }}</h2>
                        <h4 class="fs-16 fw-400 lh-25">{{ __('Already have an account?') }} <a href="{{ route('login') }}"
                                class="text-decoration-underline fw-500 text-black hover-color-one">{{__('Sign In')}}</a></h4>
                    </div>
                    <!-- Form -->
                    <form action="{{ route('register') }}" enctype="multipart/form-data" method="post">
                        @csrf
                        <div class="form-wrap pb-25">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="fullName" class="form-label">{{ __('Full Name') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="text" class="primary-form-control" id="fullName"
                                        value="{{ old('name') }}" name="name" placeholder="{{ __('Full Name') }}" />
                                </div>
                                @error('name')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if(!isCentralDomain() || !isAddonInstalled('ALUSAAS'))
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="BatchName" class="form-label">{{ __('Batch Name') }}<span
                                            class="text-danger"> *</span></label>
                                    <select class="primary-form-control sf-select-without-search" id="BatchName"
                                        name="batch_id">
                                        <option value="" selected>{{ __('Select Batch') }}</option>
                                        @foreach ($batches as $batch)
                                            <option {{ old('batch_id') == $batch->id ? 'selected' : '' }}
                                                value="{{ $batch->id }}">{{ __($batch->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('batch_id')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif
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
                            @if(!isCentralDomain() || !isAddonInstalled('ALUSAAS'))
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Department" class="form-label">{{ __('Department') }}<span
                                            class="text-danger"> *</span></label>
                                    <select class="primary-form-control sf-select-without-search" id="Department"
                                        name="department_id">
                                        <option value="" selected>{{ __('Select Department') }}</option>
                                        @foreach ($departments as $department)
                                            <option {{ old('department_id') == $department->id ? 'selected' : '' }}
                                                value="{{ $department->id }}">{{ __($department->short_name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('department_id')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="PassingYear" class="form-label">{{__('Passing Year')}}<span class="text-danger">
                                            *</span></label>
                                    <select class="primary-form-control sf-select-without-search" id="PassingYear"
                                        name="passing_year_id">
                                        <option value="" selected>{{ __('Select Passing Year') }}</option>
                                        @foreach ($passingYears as $passingYear)
                                            <option {{ old('passing_year_id') == $passingYear->id ? 'selected' : '' }}
                                                value="{{ $passingYear->id }}">{{ __($passingYear->name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('passing_year_id')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="rollNumber" class="form-label">{{ __('ID/Roll Number') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="text" class="primary-form-control" id="rollNumber"
                                        value="{{ old('id_number') }}" name="id_number"
                                        placeholder="{{ __('Your ID/Roll number') }}" />
                                </div>
                                @error('id_number')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @if (!empty(getOption('register_file_required')) && getOption('register_file_required') == STATUS_ACTIVE)
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="attachmentFile" class="form-label">{{ __('Attachment') }} (PDF)
                                        @if (getOption('register_file_required', 0))
                                            <span class="text-danger"> *</span>
                                        @endif
                                    </label>
                                    <input type="file" class="primary-form-control" id="attachmentFile"
                                        accept="application/pdf" name="file"
                                        @if (getOption('register_file_required', 0)) @endif />
                                </div>
                                @error('file')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            @endif
                            @endif
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="BirthDate" class="form-label">{{ __('Birth Date') }}<span
                                            class="text-danger"> *</span></label>
                                    <input type="date" class="primary-form-control" id="BirthDate"
                                        value="{{ old('date_of_birth') }}" name="date_of_birth" />
                                </div>
                                @error('date_of_birth')
                                    <span class="fs-12 text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="Gender" class="form-label">{{ __('Gender') }}<span
                                            class="text-danger"> *</span></label>
                                    <select class="primary-form-control sf-select-without-search" id="Gender"
                                        name="gender">
                                        <option {{ old('gender') == 'male' ? 'selected' : '' }} value="male">
                                            {{ __('Male') }}</option>
                                        <option {{ old('gender') == 'female' ? 'selected' : '' }} value="female">
                                            {{ __('Female') }}</option>
                                        <option {{ old('gender') == 'other' ? 'selected' : '' }} value="other">
                                            {{ __('Other') }}</option>
                                    </select>
                                </div>
                                @error('gender')
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
                            class="d-flex justify-content-center align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Sign
                                                                                                                                                                                                                            Up') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
