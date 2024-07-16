@extends('layouts.app')
@push('title')
    {{ __('Profile') }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Profile') }}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <!-- Tab List -->
                <ul class="nav nav-tabs zTabHead" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ session('active_tab') == 'editProfile-tab' ? '' : 'active' }}" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#profile-tab-pane" type="button" role="tab" aria-controls="profile-tab-pane"
                                aria-selected="true">{{ __('Profile') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link {{ session('active_tab') == 'editProfile-tab' ? 'active' : '' }}" id="editProfile-tab" data-bs-toggle="tab"
                                data-bs-target="#editProfile-tab-pane" type="button" role="tab"
                                aria-controls="editProfile-tab-pane" aria-selected="false">{{ __('Edit Profile') }}</button>
                    </li>
                </ul>
                <!-- Tab Content -->
                <div class="tab-content zTabContent" id="myTabContent">
                    <!-- Profile -->
                    <div class="tab-pane fade show {{ session('active_tab') == 'editProfile-tab' ? '' : 'active' }}" id="profile-tab-pane" role="tabpanel"
                         aria-labelledby="profile-tab" tabindex="0">
                        <!-- User Photo ~ Social link -->
                        <div class="pt-30 pb-40 d-flex justify-content-between align-items-center flex-wrap rg-30">
                            <!-- User Photo ~ name -->
                            <div class="d-flex align-items-center flex-wrap g-18">
                                <div class="flex-shrink-0 w-110 h-110 rounded-circle overflow-hidden bd-three bd-c-primary-color">
                                    <img class="w-100 h-100" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                         src="{{ asset('public/storage/company/image').'/'.auth('company')->user()->image}}"
                                         alt="{{auth('company')->user()->name}}" />
                                </div>
                                <div class="">
                                    <h4 class="fs-24 fs-sm-20 fw-500 lh-34 text-1b1c17">{{auth('company')->user()->name}}</h4>
                                </div>
                            </div>
                            <!-- Social Link -->
                            <ul class="d-flex align-items-center cg-7">
                                @if (auth('company')->user()?->facebook_url)
                                    <li>
                                        <a target="__blank" href="{{ auth('company')->user()->facebook_url }}"
                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-one hover-border-one"><img
                                                src="{{ asset('public/assets/images/icon/facebook.svg') }}" alt="" /></a>
                                    </li>
                                @endif
                                @if (auth('company')->user()?->twitter_url)
                                    <li>
                                        <a target="__blank" href="{{ auth('company')->user()->twitter_url }}"
                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-one hover-border-one"><img
                                                src="{{ asset('public/assets/images/icon/twitter.svg') }}" alt="" /></a>
                                    </li>
                                @endif
                                @if (auth('company')->user()?->linkedin_url)
                                    <li>
                                        <a target="__blank" href="{{ auth('company')->user()->linkedin_url }}"
                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-one hover-border-one"><img
                                                src="{{ asset('public/assets/images/icon/linkedin.svg') }}" alt="" /></a>
                                    </li>
                                @endif
                                @if (auth('company')->user()?->instagram_url)
                                    <li>
                                        <a target="__blank" href="{{ auth('company')->user()->instagram_url }}"
                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-one hover-border-one"><img
                                                src="{{ asset('public/assets/images/icon/instagram.svg') }}" alt="" /></a>
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
                                            <p>{{ auth('company')->user()->name}}</p>
                                        </li>
                                            <li>
                                                <p>{{ __('Email') }} :</p>
                                                <p>{{auth('company')->user()->email}}</p>
                                            </li>

                                            <li>
                                                <p>{{ __('Phone') }} :</p>
                                                <p>{{auth('company')->user()->phone}}</p>
                                            </li>

                                    </ul>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- Edit Profile -->
                    <div class="tab-pane fade {{ session('active_tab') == 'editProfile-tab' ? 'show active' : '' }}" id="editProfile-tab-pane" role="tabpanel"
                         aria-labelledby="editProfile-tab" tabindex="0">
                        <div class="max-w-840">
                            <form method="POST" class="ajax" data-handler="commonResponseRedirect"
                                  data-redirect-url="{{ route('company.profile.index') }}" action="{{ route('company.profile.update') }}" enctype="multipart/form-data">
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
                                                <div class="icon"><img  src="{{asset('public/assets/images/icon/edit-2.svg')}}" alt="" /></div>
                                                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/company/image').'/'.auth('company')->user()->image }}" />
                                                <input type="file" name="image" id="zImageUpload" accept="image/*,video/*"
                                                       onchange="previewFile(this)" />
                                            </div>
                                        </div>
                                        <!-- Personal Info -->
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epFullName" class="form-label">{{ __('Full Name') }}</label>
                                                    <input type="text" class="primary-form-control" id="epFullName"
                                                           required
                                                           value="{{auth('company')->user()->name}}" name="name"
                                                           placeholder="{{ __('Your Name') }}" />
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
                                                    <label for="epPhoneNumber" class="form-label">{{ __('Phone Number') }}</label>
                                                    <input type="number" value="{{auth('company')->user()->phone}}" name="mobile"
                                                           class="primary-form-control" id="epPhoneNumber"
                                                           maxlength="9"
                                                           minlength="1"
                                                           placeholder="eg: (+880) 1254 8593" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epEmail" class="form-label">{{ __('Personal Email Address') }}</label>
                                                    <input type="email" value="{{auth('company')->user()->email}}" name="email"
                                                           class="primary-form-control" id="epEmail"
                                                           placeholder="{{ __('Your Email') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epLinkedin" class="form-label">{{ 'Linkedin Url' }}</label>
                                                    <input type="url" value="{{ auth('company')->user()?->linkedin_url }}"
                                                           name="linkedin_url" class="primary-form-control" id="epLinkedin"
                                                           placeholder="{{ __('Your Linkedin Profile Url') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epFacebook" class="form-label">{{ __('Facebook Url') }}</label>
                                                    <input type="url" value="{{ auth('company')->user()?->facebook_url }}"
                                                           name="facebook_url" class="primary-form-control" id="epFacebook"
                                                           placeholder="{{ __('Your Facebook Profile Url') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epTwitter" class="form-label">{{ __('Twitter Url') }}</label>
                                                    <input type="url" value="{{ auth('company')->user()?->twitter_url }}"
                                                           name="twitter_url" class="primary-form-control" id="epTwitter"
                                                           placeholder="{{ __('Your Twitter Profile Url') }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epInstagram" class="form-label">{{ __('Instagram Url') }}</label>
                                                    <input type="url" value="{{ auth('company')->user()?->instagram_url }}"
                                                           name="instagram_url" class="primary-form-control" id="epInstagram"
                                                           placeholder="{{ __('Your Instagram Profile Url') }}" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Address -->
                                <button type="submit"
                                        class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save Changes') }}</button>
                            </form>
                            <div class="pb-30 py-30">
                                <h4 class="fs-18 fw-500 lh-22 text-secondary-color pb-20">{{ __('Change Password') }}</h4>
                                <div class="container rg-25">
                                    <form id="changePasswordForm" action="{{ route('company.profile.change-password') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="primary-form-group">
                                                    <div class="primary-form-group-wrap">
                                                        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                                        <div class="input-group position-relative">
                                                            <input type="password" name="current_password" class="primary-form-control rounded-3" id="current_password" placeholder="Enter Old Password" required />
                                                            <button type="button" class="btn hover-color-secondary btn-outline-secondary bg-transparent border-0 btn btn-outline-secondary h-100 position-absolute  toggle-password top-0 toggle-password end-0" aria-label="Show Password">
                                                                <i class="fa fa-eye"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="primary-form-group">
                                                    <div class="primary-form-group-wrap">
                                                        <label for="new_password" class="form-label">{{ __('New Password') }}</label>
                                                        <input type="password" name="new_password" class="primary-form-control" id="new_password" placeholder="{{ __('Enter New Password') }}" required />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="primary-form-group">
                                                    <div class="primary-form-group-wrap">
                                                        <label for="new_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                                                        <input type="password" name="new_password_confirmation" class="primary-form-control" id="new_password_confirmation" placeholder="{{ __('Confirm Password') }}" required />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="submit" class="py-13 mt-17 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Reset') }}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function () {
            $('.skills-select').select2({
                tags: true,
                tokenSeparators: [',', ' '],
                placeholder: "Add your skills",
                allowClear: true
            });
            $('#addCompanyBtn').click(function () {
                if (experienceCount < maxExperiences) {
                    $('#addExperienceModal').modal('show');
                }
            });
            const maxExperiences = 3;
            let experienceCount = 1;
            let sectionCounter = 1;

            $('#addCompanyBtn').click(function () {
                if (experienceCount < maxExperiences) {
                    var container = $('#companySectionContainer');
                    var newSectionId = 'summernote' + sectionCounter; // Unique ID for each Summernote instance

                    var newHtml = `
            <div class="row" id="section${sectionCounter}">
                <!-- Company Name -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Company Name</label>
                            <input type="text" name="company[]" class="primary-form-control" placeholder="Your Current Company">
                        </div>
                    </div>
                </div>
                <!-- Designation -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Position</label>
                            <input type="text" name="position[]" class="primary-form-control" placeholder="Your Position">
                        </div>
                    </div>
                </div>
                <!-- Address -->
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">Address</label>
                            <input type="text" name="company_address[]" class="primary-form-control" placeholder="Your Company Address">
                        </div>
                    </div>
                </div>
                <!-- Start Date and End Date -->
                <div class="col-md-6 d-flex">
                    <div class="col-lg-6">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label>Start Date:</label>
                                <input type="date" class="form-control" name="startDate[]">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="endDate">End Date:</label>
                                <input type="date" class="form-control endDate" name="endDate[]">
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Description -->
                <div class="col-lg-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="${newSectionId}" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea name="details[]" class="primary-form-control summernote" id="${newSectionId}" placeholder="Details"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            `;

                    container.append(newHtml);  // Append the new section to the container using jQuery's append
                    initializeSummernote(newSectionId);  // Initialize Summernote for the new textarea
                    sectionCounter++;  // Increment the counter after adding the section
                    experienceCount++;  // Increment experience count
                }
            });
        });

        function initializeSummernote(elementId) {
            $('#' + elementId).summernote({
                placeholder: "Write description...",
                tabsize: 2,
                minHeight: 183,
                toolbar: [
                    ["font", ["bold", "italic", "underline"]],
                    ["para", ["ul", "ol", "paragraph"]],
                ],
            });
        }
    </script>
    <script src="{{ asset('public/company/js/profile.js') }}"></script>
@endpush
