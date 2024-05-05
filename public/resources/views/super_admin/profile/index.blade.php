@extends('super_admin.layouts.app')
@push('title')
    {{ __('Profile') }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Profile') }}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Tab List -->

                <!-- Tab Content -->
                <div class="tab-content zTabContent" id="myTabContent">
                    <!-- Profile -->
                    <!-- Edit Profile -->
                    <div class="tab-pane fade show active" id="editProfile-tab-pane" role="tabpanel"
                        aria-labelledby="editProfile-tab" tabindex="0">
                        <div class="max-w-840">
                            <form method="POST" enctype="multipart/form-data"
                                action="{{ route('super_admin.profile.change-password.update') }}">
                                @csrf
                                <!-- Photo -->
                                <div class="pb-40"></div>
                                <!-- Personal Info -->
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Personal Info') }}</h4>
                                    <div class="row rg-25">
                                        <!-- Photo -->
                                        <div class="pb-40">
                                            <div class="upload-img-box profileImage-upload">
                                                <div class="icon"><img src="{{ asset('assets/images/icon/edit-2.svg') }}"
                                                        alt="" /></div>
                                                <img src="{{ getFileUrl($user->image) }}" />
                                                <input type="file" name="image" id="zImageUpload" accept="image/*"
                                                    onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                        <!-- Personal Info -->
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epFullName" class="form-label">{{ __('Full Name') }}</label>
                                                    <input type="text" class="primary-form-control" id="epFullName"
                                                        value="{{ $user->name }}" name="name"
                                                        placeholder="{{ __('Your Name') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epFullName" class="form-label">{{ __('Email') }}</label>
                                                    <input type="email" class="primary-form-control" id="epFullName"
                                                        value="{{ $user->email }}" name="email"
                                                        placeholder="{{ __('Email') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Contact Info -->
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Change Password') }}</h4>
                                    <div class="row rg-25">
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epEmail" class="form-label">{{ __('Password') }}</label>
                                                    <input type="password" name="pass1"
                                                        class="primary-form-control" id="epEmail"
                                                        placeholder="{{ __('Password') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epEmail"
                                                        class="form-label">{{ __('Re Password') }}</label>
                                                    <input type="password" name="pass2"
                                                        class="primary-form-control" id="epEmail"
                                                        placeholder="{{ __('Re Enter Password') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="submit"
                                    class="py-13 px-26 bg-7f56d9 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save Changes') }}</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

