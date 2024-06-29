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
                                     src="{{ asset('public/storage/company').'/'.auth('company')->user()->image}}"
                                    alt="{{auth('company')->user()->first_name.' '.auth('company')->user()->last_name}}" />
                            </div>

                            <div class="">
                                <h4 class="fs-24 fs-sm-20 fw-500 lh-34 text-1b1c17">{{auth('company')->user()->first_name.' '.auth('company')->user()->last_name}}</h4>
                                <p class="fs-14 fw-400 lh-17 text-707070 pb-10">
                                    {{auth('company')->user()?->company_designation }}
                                </p>
                            </div>
                        </div>
                        <!-- Social Link -->
                        <ul class="d-flex align-items-center cg-7">
                            @if (auth('company')->user()?->facebook_url != null && auth('company')->user()?->facebook_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('comany')->user()?->facebook_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/facebook.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('company')->user()?->twitter_url != null && auth('company')->user()?->twitter_url != '')
                            <li>
                                <a target="__blank" href="{{ $user->company?->twitter_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/twitter.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('company')->user()?->linkedin_url != null && auth('company')->user()?->linkedin_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('company')->user()?->linkedin_url }}"
                                    class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img
                                        src="{{ asset('assets/images/icon/linkedin.svg') }}" alt="" /></a>
                            </li>
                            @endif
                            @if (auth('company')->user()?->instagram_url != null && auth('company')->user()?->instagram_url != '')
                            <li>
                                <a target="__blank" href="{{ auth('company')->user()?->instagram_url }}"
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
                                <!-- Bio text -->
                                <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-10">{{ __('Profile Bio') }}</h4>
                                    <p class="fs-14 fw-400 lh-24 text-707070 pb-12">{!! auth('company')->user()?->about_me !!}</p>
                                </div>
                                <!-- Personal Info -->
                                <ul class="zList-one">
                                    <li>
                                        <p>{{ __('Full Name') }} :</p>
                                        <p>{{ auth('company')->user()->first_name.' '.auth('company')->user()->last_name }}</p>
                                    </li>

                                    @if (auth('company')->user()->show_email_in_public == STATUS_SUCCESS)
                                    <li>
                                        <p>{{ __('Email') }} :</p>
                                        <p>{{auth('company')->user()->email}}</p>
                                    </li>
                                    @endif
                                    @if (auth('company')->user()->show_phone_in_public == STATUS_SUCCESS)
                                    <li>
                                        <p>{{ __('Phone') }} :</p>
                                        <p>{{auth('company')->user()->phone}}</p>
                                    </li>
                                    @endif

                                    <li>
                                        <p>{{ __('City') }} :</p>
                                        <p> {{ auth('company')->user()?->city }}</p>
                                    </li>
                                    <li>
                                        <p>{{ __('Country') }} :</p>
                                        <p>{{ auth('company')->user()?->country }}</p>
                                    </li>

                                </ul>
                            </div>
                        </div>
                        <!-- Info -->
                        <div class="col-lg-4">
                            <div class="py-20 px-30 bd-ra-10 bg-f9f9f9 max-w-503 m-auto">
                                <div class="">
                                    <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-10">{{ __('Professional Info') }}</h4>
                                    <ul class="zList-one">
                                        <li>
                                            <p>{{ __('Company Name') }} :</p>
                                            <p>{{ auth('company')->user()?->company }}</p>
                                        </li>
                                        <li>
                                            <p>{{ __('Designation') }} :</p>
                                            <p>{{ auth('company')->user()?->company_designation }}</p>
                                        </li>
                                        <li>
                                            <p>{{ __('Office Address') }} :</p>
                                            <p>{{ auth('company')->user()?->company_address }}</p>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Edit Profile -->
                <div class="tab-pane fade" id="editProfile-tab-pane" role="tabpanel" aria-labelledby="editProfile-tab"
                    tabindex="0">
                    <div class="max-w-840">
                        <form method="POST" class="ajax" data-handler="commonResponseRedirect"
                            data-redirect-url="{{ route('company.profile.index') }}" action="{{ route('company.profile.update') }}">
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
                                            <div class="icon"><img src="assets/images/icon/edit-2.svg" alt="" /></div>
                                            <img src="{{ asset('public/storage/company').'/'.auth('company')->user()->image }}" />
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
                                                    value="{{auth('company')->user()->first_name}}" name="name"
                                                    placeholder="{{ __('Your Name') }}" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epAbout" class="form-label">{{ __('About Me') }}</label>
                                                <textarea class="primary-form-control min-h-180" id="epAbout"
                                                    name="about_me"
                                                    placeholder="{{ __('Type about yourself') }}">{!! auth('company')->user()?->about_me !!}</textarea>
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
                                                <input type="mobile" value="{{auth('company')->user()->mobile}}" name="mobile"
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
                                                <input type="email" value="{{auth('company')->user()->email}}" name="email" disabled
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
                                                <label for="epFacebook" class="form-label">{{ __('Facebook Url')
                                                    }}</label>
                                                <input type="url" value="{{ auth('company')->user()?->facebook_url }}"
                                                    name="facebook_url" class="primary-form-control" id="epFacebook"
                                                    placeholder="{{ __('Your Facebook Profile Url') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epTwitter" class="form-label">{{ __('Twitter Url')
                                                    }}</label>
                                                <input type="url" value="{{ auth('company')->user()?->twitter_url }}"
                                                    name="twitter_url" class="primary-form-control" id="epTwitter"
                                                    placeholder="{{ __('Your Twitter Profile Url') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epInstagram" class="form-label">{{ __('Instagram Url')
                                                    }}</label>
                                                <input type="url" value="{{ auth('company')->user()?->instagram_url }}"
                                                    name="instagram_url" class="primary-form-control" id="epInstagram"
                                                    placeholder="{{ __('Your Instagram Profile Url') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-30">
                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Professional Info') }}</h4>
                                <div class="row rg-25">
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epCompanyName" class="form-label">{{ __('Company Name')
                                                    }}</label>
                                                <input type="text" value="{{ auth('company')->user()?->company }}" name="company"
                                                    class="primary-form-control" id="epCompanyName"
                                                    placeholder="{{ __('Your Current Company') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epDesignation" class="form-label">{{ __('Designation')
                                                    }}</label>
                                                <input type="text" value="{{ auth('company')->user()?->company_designation }}"
                                                    name="company_designation" class="primary-form-control"
                                                    id="epDesignation"
                                                    placeholder="{{ __('Your Current Designation') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epCompanyAddress" class="form-label">{{ __('Address')
                                                    }}</label>
                                                <input type="text" value="{{ auth('company')->user()?->company_address }}"
                                                    name="company_address" class="primary-form-control"
                                                    id="epCompanyAddress"
                                                    placeholder="{{ __('Your Company Address') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="pb-30">
                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-20">{{ __('Address') }}</h4>
                                <div class="row rg-25">
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epCity" class="form-label">{{ __('City') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="primary-form-control"
                                                    value="{{ auth('company')->user()?->city }}" name="city" id="epCity"
                                                    placeholder="{{ __('Current Company City') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epCity" class="form-label">{{ __('State') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" class="primary-form-control"
                                                    value="{{ auth('company')->user()?->state }}" name="state" id="epCity"
                                                    placeholder="{{ __('Current Company State') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epCountry" class="form-label">{{ __('Country') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" value="{{ auth('company')->user()?->country }}" name="country"
                                                    class="primary-form-control" id="epCountry"
                                                    placeholder="{{ __('Current Company Country') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epZipCode" class="form-label">{{ __('Zip Code') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" value="{{ auth('company')->user()?->zip }}" name="zip"
                                                    class="primary-form-control" id="epZipCode"
                                                    placeholder="{{ __('Current Company Zip Code') }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epAddress" class="form-label">{{ __('Address') }} <span
                                                        class="text-danger">*</span></label>
                                                <input type="text" value="{{ auth('company')->user()?->address }}" name="address"
                                                    class="primary-form-control" id="epAddress"
                                                    placeholder="{{ __('Current Company Address') }}" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{
                                __('Save Changes') }}</button>
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
{{--                    action="{{ route('company.add_institution') }}">--}}
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

{{--<input type="hidden" id="job-post-list-route" value="{{ route('company.cvs.all') }}">--}}

<table class="table zTable" id="cvsTable">
    <thead>
    <tr>
        <th scope="col"><div>{{ __('Name') }}</div></th>
        <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
    </tr>
    </thead>
</table>
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
<script src="{{ asset('public/company/js/profile.js') }}"></script>
<script src="{{ asset('public/company/js/cvs.js') }}"></script>
@endpush
