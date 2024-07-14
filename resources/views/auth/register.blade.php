@extends('web.layouts.app')
@push('title')
    {{ __('Register') }}
@endpush
@section('content')
    <div class="register-area register-wrap" style="background-image: url('{{ asset('public/frontend/images/community-bg-1.png') }}');">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6 py-5">
                    <div class="register-right bg-white pd register-right rounded-5 s shadow-lg p-4">
                        <div class="primary-form">
                            <!-- Title -->
                            <div class="pb-40">
                                <h2 class="fs-32 fw-600 lh-38 text-secondary-color pb-3">{{ __('Create Account') }}</h2>
                            </div>
                            <!-- Form -->
                            <form action="{{ route('auth.store') }}" enctype="multipart/form-data" method="post">
                                @csrf
                                <div class="form-wrap pb-25">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="fullName" class="form-label">{{ __('Full Name') }}<span class="text-danger"> *</span></label>
                                                    <input type="text" class="primary-form-control" id="fullName" value="{{ old('name') }}" name="name" placeholder="{{ __('Name') }}" required />
                                                </div>
                                                @error('name')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="PhoneNumber" class="form-label">{{ __('Phone Number') }}<span class="text-danger"> *</span></label>
                                                    <input type="text" class="primary-form-control" id="PhoneNumber" value="{{ old('mobile') }}" name="mobile" placeholder="{{ __('eg: (+880) 1754936599') }}" required />
                                                </div>
                                                @error('mobile')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="EmailAddress" class="form-label">{{ __('Email Address') }}<span class="text-danger"> *</span></label>
                                                    <input type="email" class="primary-form-control" id="EmailAddress" value="{{ old('email') }}" name="email" placeholder="{{ __('example@example.com') }}" required />
                                                </div>
                                                @error('email')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="attachmentFile" class="form-label">{{ __('Attachment') }} (PDF 2MB)<span class="text-danger">*</span></label>
                                                    <input type="file" class="primary-form-control" id="attachmentFile" accept="application/pdf" name="proposal" required />
                                                </div>
                                                @error('proposal')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="Password" class="form-label">{{ __('Password') }}<span class="text-danger"> *</span></label>
                                                    <div class="input-group position-relative">
                                                        <input type="password" class="primary-form-control" id="Password" name="password" placeholder="Enter Password" required />
                                                        <button type="button" style="right: 0" class="btn hover-color-secondary btn-outline-secondary bg-transparent border-0 btn btn-outline-secondary h-100 position-absolute toggle-password top-0 end-0" aria-label="Show Password">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('password')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="ConfirmPassword" class="form-label">{{ __('Confirm Password') }}<span class="text-danger"> *</span></label>
                                                    <div class="input-group position-relative">
                                                        <input type="password" class="primary-form-control" id="ConfirmPassword" name="password_confirmation" placeholder="Confirm Password" required />
                                                        <button type="button" style="right: 0" class="btn hover-color-secondary btn-outline-secondary bg-transparent border-0 btn btn-outline-secondary h-100 position-absolute toggle-password top-0 end-0" aria-label="Show Password">
                                                            <i class="fa fa-eye"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                @error('password_confirmation')
                                                <span class="fs-12 text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <button type="submit" class="d-flex justify-content-center hover-color-white align-items-center w-100 border-0 fs-15 fw-500 lh-25 text-1b1c17 p-13 bd-ra-12 bg-cdef84 hover-bg-secondary">{{ __('Sign Up') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');

        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function () {
                const passwordInput = this.previousElementSibling;

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.innerHTML = '<i class="fa fa-eye-slash"></i>';
                } else {
                    passwordInput.type = 'password';
                    this.innerHTML = '<i class="fa fa-eye"></i>';
                }
            });
        });
    });
</script>
