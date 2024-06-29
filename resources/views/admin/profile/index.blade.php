@extends('layouts.app')
@push('title')
{{ __('Profile') }}
@endpush
@section('content')
<div class="p-30" >
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Profile') }}</h4>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <!-- Tab List -->
            <ul class="nav nav-tabs zTabHead" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                        data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                        aria-selected="true">{{ __('Profile') }}</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="editProfile-tab" data-bs-toggle="tab"
                        data-bs-target="#editProfile-tab-pane" type="button" role="tab"
                        aria-controls="editProfile-tab-pane" aria-selected="false">{{ __('Edit Profile') }}</button>
                </li>
            </ul>
            <!-- Tab Content -->
            <div class="tab-content zTabContent" id="myTabContent">
                <!-- Profile -->
                <div class="tab-pane fade show active" id="profile-tab-pane" role="tabpanel"
                    aria-labelledby="profile-tab" tabindex="0">
                    <!-- User Photo ~ Social link -->
                    <div class="pt-30 pb-40 d-flex justify-content-between align-items-center flex-wrap rg-30">
                        <!-- User Photo ~ name -->
                        <div class="d-flex align-items-center flex-wrap g-18">

                            <div class="flex-shrink-0 w-110 h-110 rounded-circle overflow-hidden bd-three bd-c-cdef84">
                                <img class="w-100" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                     src="{{ asset('public/storage/admin').'/'.'image'.'/'.auth('admin')->user()->image}}"
                                    alt="{{auth('admin')->user()->first_name.' '.auth('admin')->user()->last_name}}" />
                            </div>

                            <div class="">
                                <h4 class="fs-24 fs-sm-20 fw-500 lh-34 text-1b1c17">{{auth('admin')->user()->first_name.' '.auth('admin')->user()->last_name}}</h4>
                                <p class="fs-14 fw-400 lh-17 text-707070 pb-10">
                                    {{auth('admin')->user()?->company_designation }}
                                </p>
                            </div>
                        </div>
                        <!-- Social Link -->
                        <ul class="d-flex align-items-center cg-7">
                            @if (auth('admin')->user()?->facebook_url != null && auth('admin')->user()?->facebook_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('admin')->user()?->facebook_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/facebook.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('admin')->user()?->twitter_url != null && auth('admin')->user()?->twitter_url != '')
                            <li>
                                <a target="__blank" href="{{ $user->admin?->twitter_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/twitter.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('admin')->user()?->linkedin_url != null && auth('admin')->user()?->linkedin_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('admin')->user()?->linkedin_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/linkedin.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('admin')->user()?->instagram_url != null && auth('admin')->user()?->instagram_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('admin')->user()?->instagram_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/instagram.svg') }}" alt="" /></a>
                            </li>
                            @endif
                        </ul>
                    </div>
                    <!-- Bio ~ Info -->
                    <div class="row rg-30">
                        <!-- Bio -->
                        <div class="col-lg-8">
                            <div class="py-20 px-25 bd-ra-10 bg-f9f9f9">

                                <!-- Personal Info -->
                                <ul class="zList-one">
                                    <li>
                                        <p>{{ __('Full Name') }} :</p>
                                        <p>{{ auth('admin')->user()->first_name.' '.auth('admin')->user()->last_name }}</p>
                                    </li>


                                    <li>
                                        <p>{{ __('Phone') }} :</p>
                                        <p> {{ auth('admin')->user()?->mobile }}</p>
                                    </li>
                                    <li>
                                        <p>{{ __('Email') }} :</p>
                                        <p>{{ auth('admin')->user()?->email }}</p>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Info -->

                    </div>
                </div>
                <!-- Edit Profile -->
                <div class="tab-pane fade" id="editProfile-tab-pane" role="tabpanel" aria-labelledby="editProfile-tab"
                    tabindex="0">
                    <div class="max-w-840">
                        <form method="POST" class="ajax" data-handler="commonResponseRedirect" enctype="multipart/form-data"
                            data-redirect-url="{{ route('admin.profile.index') }}" action="{{ route('admin.profile.update') }}">
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
                                            <div class="icon"><img src="{{asset('public/assets/images/icon/edit-2.svg')}}" alt="" /></div>
                                            <img onerror="this.src='{{ asset('public/assets/images/no-image.jpg') }}'" src="{{ asset('public/storage/admin').'/'.'image'.'/'.auth('admin')->user()->image }}" />
                                            <input type="file" name="image" id="zImageUpload" accept="image/*,video/*"
                                                onchange="previewFile(this)" />
                                        </div>
                                    </div>
                                    <!-- Personal Info -->
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epFullName" class="form-label">{{ __('First Name') }}</label>
                                                <input type="text" class="primary-form-control" id="epFullName"
                                                    value="{{auth('admin')->user()->first_name}}" name="f_name"
                                                    placeholder="{{ __('Your First Name') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epFullName" class="form-label">{{ __('Last Name') }}</label>
                                                <input type="text" class="primary-form-control" id="epFullName"
                                                       value="{{auth('admin')->user()->last_name}}" name="l_name"
                                                       placeholder="{{ __('Your Last Name') }}" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <!-- Contact Info -->
                            <div class="pb-30">
                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Contact Info') }}</h4>
                                <div class="row rg-25">
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epPhoneNumber" class="form-label">{{ __('Phone Number')
                                                    }}</label>
                                                <input type="mobile" value="{{auth('admin')->user()->mobile}}" name="mobile"
                                                    class="primary-form-control" id="epPhoneNumber"
                                                    placeholder="eg: (+880) 1254 8593" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epEmail" class="form-label">{{ __('Personal Email Address')
                                                    }}</label>
                                                <input type="email" value="{{auth('admin')->user()->email}}" name="email"
                                                    class="primary-form-control" id="epEmail"
                                                    placeholder="{{ __('Your Email') }}" />
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>


                            <button type="submit"
                                class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{
                                __('Save Changes') }}</button>
                            <button type="button" onclick="resetPassword('{{ route('admin.reset-password', ['id' => auth('admin')->id()]) }}')" class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">Reset Password</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Add More Modal -->
<div class="modal fade zModalTwo" id="addMoreModal" tabindex="-1" aria-labelledby="addMoreModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content zModalTwo-content">
            <div class="modal-body zModalTwo-body">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center pb-30">
                    <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{ __('Add Info') }}</h4>
                    <div class="mClose">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                                src="{{ asset('public/assets/images/icon/delete.svg') }}" alt="" /></button>
                    </div>
                </div>
                <!-- Body -->
{{--                <form method="POST" class="ajax" data-handler="commonResponseForModal"--}}
{{--                    action="{{ route('admin.add_institution') }}">--}}
{{--                    @csrf--}}
{{--                    <div class="pb-25">--}}
{{--                        <div class="row rg-25">--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="primary-form-group">--}}
{{--                                    <div class="primary-form-group-wrap">--}}
{{--                                        <label for="epDegree1" class="form-label">{{ __('Degree') }}</label>--}}
{{--                                        <input type="text" class="primary-form-control" id="epDegree1" name="degree"--}}
{{--                                            placeholder="{{ __('Your Degree') }}" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="primary-form-group">--}}
{{--                                    <div class="primary-form-group-wrap">--}}
{{--                                        <label for="epInstitute" class="form-label">{{ __('Institution') }}</label>--}}
{{--                                        <input type="text" class="primary-form-control" id="epInstitute"--}}
{{--                                            name="institute" placeholder="{{ __('Your Institution') }}" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-12">--}}
{{--                                <div class="primary-form-group">--}}
{{--                                    <div class="primary-form-group-wrap">--}}
{{--                                        <label for="epPassingYear1" class="form-label">{{ __('Passing Year') }}</label>--}}
{{--                                        <input type="text" class="primary-form-control" id="epPassingYear1"--}}
{{--                                            name="passing_year" placeholder="{{ __('Your Passing Year') }}" />--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <button type="submit"--}}
{{--                        class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{--}}
{{--                        __('Save Now') }}</button>--}}
{{--                </form>--}}
            </div>
        </div>
    </div>
</div>

@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#add-education').click(function() {
                var newEducation = $('.education-block:first').clone();
                newEducation.find('input').val('');  // Clear the values.
                newEducation.appendTo('#education-parent');
            });

            $(document).on('click', '.remove-education', function() {
                if ($('.education-block').length > 1) { // Ensure at least one remains
                    $(this).closest('.education-block').remove();
                } else {
                    alert('You must keep at least one education entry.');
                }
            });
        });
    </script>
    <script>
        // Function to handle resetting password
        function resetPassword(url, id) {
            Swal.fire({
                title: 'Reset Password',
                text: 'Are you sure you want to reset this admin\'s password?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, Reset It!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (response) {
                            if (response.message) {
                                Swal.fire('Success', response.message, 'success');
                                window.location.href = '{{ route("admin.auth.login") }}'; // Redirect to admin login page

                            } else {
                                Swal.fire('Error', 'Failed to reset password.', 'error');
                            }
                        },
                        error: function (error) {
                            Swal.fire('Error', 'Failed to reset password: ' + error.responseJSON.error, 'error');
                        }
                    });
                }
            });
        }

    </script>
<script src="{{ asset('public/admin/js/profile.js') }}"></script>
<script src="{{ asset('public/admin/js/cvs.js') }}"></script>
@endpush
