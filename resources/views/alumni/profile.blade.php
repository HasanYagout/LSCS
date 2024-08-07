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
                        <button class="nav-link active" id="profile-tab" data-bs-toggle="tab"
                                data-bs-target="#profile-tab-pane" type="button" role="tab"
                                aria-controls="profile-tab-pane"
                                aria-selected="true">{{ __('Profile') }}</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="editProfile-tab" data-bs-toggle="tab"
                                data-bs-target="#editProfile-tab-pane" type="button" role="tab"
                                aria-controls="editProfile-tab-pane"
                                aria-selected="false">{{ __('Edit Profile') }}</button>
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

                                <div
                                    class="flex-shrink-0 w-110 h-110 rounded-circle overflow-hidden bd-three bd-c-cdef84">
                                    <img class="w-100 h-100"
                                         onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                         src="{{ asset('public/storage/alumni/image').'/'.auth('alumni')->user()->image }}"
                                         alt="{{auth('alumni')->user()->first_name.' '.auth('alumni')->user()->last_name}}"/>
                                </div>

                                <div class="">
                                    <h4 class="fs-24 fs-sm-20 fw-500 lh-34 text-f1a527">{{auth('alumni')->user()->first_name.' '.auth('alumni')->user()->last_name}}</h4>
                                    <p class="fs-14 fw-400 lh-17 text-707070 pb-10">
                                        {{--                                    {{dd(json_decode(auth('alumni')->user()?->experience)[0])}}--}}
                                    </p>
                                </div>
                            </div>
                            <!-- Social Link -->
                            <ul class="d-flex align-items-center cg-7">
{{--                                @if (auth('alumni')->user()?->facebook_url != null && auth('alumni')->user()?->facebook_url != '')--}}
{{--                                    <li>--}}
{{--                                        <a target="__blank" href="{{ auth('alumni')->user()?->facebook_url }}"--}}
{{--                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img--}}
{{--                                                src="{{ asset('assets/images/icon/facebook.svg') }}" alt=""/></a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
{{--                                @if (auth('alumni')->user()?->twitter_url != null && auth('alumni')->user()?->twitter_url != '')--}}
{{--                                    <li>--}}
{{--                                        <a target="__blank" href="{{ $user->alumni?->twitter_url }}"--}}
{{--                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img--}}
{{--                                                src="{{ asset('assets/images/icon/twitter.svg') }}" alt=""/></a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
                                @if (auth('alumni')->user()?->linkedin_url != null && auth('alumni')->user()?->linkedin_url != '')
                                    <li>
                                        <a target="__blank" href="{{ auth('alumni')->user()?->linkedin_url }}"
                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-one hover-border-one"><img
                                                src="{{ asset('public/assets/images/icon/linkedin.svg') }}" alt=""/></a>
                                    </li>
                                @endif
{{--                                @if (auth('alumni')->user()?->instagram_url != null && auth('alumni')->user()?->instagram_url != '')--}}
{{--                                    <li>--}}
{{--                                        <a target="__blank" href="{{ auth('alumni')->user()?->instagram_url }}"--}}
{{--                                           class="d-flex justify-content-center align-items-center w-48 h-48 rounded-circle bd-one bd-c-ededed bg-fafafa hover-bg-two hover-border-one"><img--}}
{{--                                                src="{{ asset('assets/images/icon/instagram.svg') }}" alt=""/></a>--}}
{{--                                    </li>--}}
{{--                                @endif--}}
                            </ul>
                        </div>
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- Content for the left section -->
                                    <div class="row gap-3">
                                        <div class="col-md-12">
                                            <div class="py-20 px-25 bd-ra-10 bg-f9f9f9">
                                                <!-- Bio text -->
                                                <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('Profile Bio') }}</h4>
                                                    <p class="fs-14 fw-400 lh-24 text-707070 pb-12">{!! auth('alumni')->user()?->about_me !!}</p>
                                                </div>
                                                <!-- Personal Info -->
                                                <ul class="zList-one">
                                                    <li>
                                                        <p>{{ __('First Name') }} :</p>
                                                        <p>{{ auth('alumni')->user()->first_name}}</p>
                                                    </li>
                                                    <li>
                                                        <p>{{ __('Last Name') }} :</p>
                                                        <p>{{ auth('alumni')->user()->last_name}}</p>
                                                    </li>

                                                    <li>
                                                        <p>{{ __('Email') }} :</p>
                                                        <p>{{auth('alumni')->user()->email}}</p>
                                                    </li>

                                                    <li>
                                                        <p>{{ __('Phone') }} :</p>
                                                        <p>{{auth('alumni')->user()->phone}}</p>
                                                    </li>

                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="py-20 px-30 bd-ra-10 bg-f9f9f9  m-auto">
                                                <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('Experience Info') }}</h4>
                                                </div>
                                            @foreach(auth('alumni')->user()?->experience as $experience)

                                                <div class="py-20 bd-ra-10 bg-f9f9f9">
                                                    <ul class="zList-one">
                                                        <li class="p-0 lh-1 d-block">
                                                            <h6 class="fs-4 lh-1">{{ $experience->position}}</h6>
                                                        </li>
                                                        <li class="p-0 lh-1 d-block">
                                                            <h1 class="fw-medium lh-1">{{ $experience->name}}</h1>
                                                        </li>
                                                        <li class="d-block p-0">
                                                            @php
                                                                $startDate = new DateTime($experience->start_date);
                                                                $endDate = new DateTime($experience->end_date);
                                                            @endphp
                                                            <span
                                                                class="text-f1a527-50">{{ $startDate->format('M Y') .' - '.$endDate->format('M Y')}}</span>
                                                        </li>
                                                        <li>
                                                            <p>{{$experience->company_address}}</p>
                                                        </li>
                                                        <ul>
                                                            {!! $experience->details !!}
                                                        </ul>

                                                    </ul>


                                                </div>


                                            @endforeach
                                        </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Content for the right section -->
                                   <div class="row">
                                       <div class="col-md-12">
                                           <div class="py-20 px-30 bd-ra-10 bg-f9f9f9 max-w-503 m-auto">
                                               <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                                   <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('Educational Info') }}</h4>
                                               </div>

                                               @foreach( auth('alumni')->user()?->education as $education)
                                                   <ul class="zList-one">
                                                       <li class="d-block">
                                                           <p class=" fs-4">{{ $education->type }}</p>
                                                       </li>

                                                       <li class="d-block">
                                                           <p class=" fs-6 fw-light">{{ $education->name }}</p>
                                                       </li>

                                                       <li class="d-block">
                                                           <p class="text-1b1c17-50">{{ $education->start_date .' - '.$education->end_date}}</p>
                                                       </li>
                                                   </ul>

                                               @endforeach

                                           </div>

                                       </div>
                                       <div class="col-md-12">
                                           <div class="py-20 mt-3 px-30 bd-ra-10 bg-f9f9f9 max-w-503 m-auto">
                                               <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                                   <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('Skills') }}</h4>

                                               </div>
                                               <ul class="zList-one d-flex">
                                                   @php
                                                       $skills = json_decode(auth('alumni')->user()?->skills);
                                                   @endphp

                                                   @if ($skills)
                                                       @foreach ($skills as $skill)
                                                           <li class="p-1 d-flex bg-f1a527 rounded m-1">
                                                               <p>{{ $skill }}</p>
                                                           </li>
                                                       @endforeach
                                                   @endif
                                               </ul>
                                           </div>

                                       </div>
                                       <div class="col-md-12">
                                           <div class="py-20 mt-3 px-30 bd-ra-10 bg-f9f9f9 max-w-503 m-auto">
                                               <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                                                   <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-10">{{ __('CVs') }}</h4>

                                               </div>
                                                   <div class="container">
                                                   <div class="row g-3">
                                               @foreach(auth('alumni')->user()->cvs as $cv)
                                                       <div class="col-md-6">
                                                           <div class="card">
                                                               <div class="card-body">
                                                                   <embed
                                                                       src="{{asset('public/storage/alumni/cv').'/'.$cv->name}}"
                                                                       type="application/pdf" width="100%" height="500px">

                                                               </div>
                                                           </div>
                                                       </div>

                                               @endforeach
                                                   </div>
                                                   </div>

                                           </div>

                                       </div>

                                   </div>
                                </div>
                            </div>
                        <button class="bd-c-afd449  bg-f1a527 btn btn-lg hover-border-one mt-3 text-002a5c " onclick="window.location='{{ route('alumni.profile.generate-cv') }}'">
                            Generate CV
                        </button>
                        </div>

                    </div>
                    <!-- Edit Profile -->
                    <div class="tab-pane fade" id="editProfile-tab-pane" role="tabpanel"
                         aria-labelledby="editProfile-tab"
                         tabindex="0">
                        <div class="max-w-840">
                            <form method="POST" class="ajax" data-handler="commonResponseRedirect"
                                  data-redirect-url="{{ route('alumni.profile.index') }}"
                                  action="{{ route('alumni.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                <!-- Photo -->
                                <div class="pb-40"></div>
                                <!-- Personal Info -->
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Personal Info') }}</h4>
                                    <div class="row rg-25">
                                        <!-- Photo -->
                                        <div class="pb-40">
                                            <div class="upload-img-box profileImage-upload">
                                                <div class="icon"><img src="{{asset('public/assets/images/icon/edit-2.svg')}}" alt=""/>
                                                </div>
                                                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                                    src="{{ asset('public/storage/alumni/image').'/'.auth('alumni')->user()->image }}"/>
                                                <input type="file" name="image" id="zImageUpload"
                                                       accept="image/*,video/*"
                                                       onchange="previewFile(this)"/>
                                            </div>
                                        </div>
                                        <!-- Personal Info -->


                                        <div class="col-md-12">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epAbout" class="form-label">{{ __('About Me') }}</label>
                                                    <textarea class="primary-form-control min-h-180" id="epAbout"
                                                              name="about_me"
                                                              placeholder="{{ __('Type about yourself') }}">{!! auth('alumni')->user()?->about_me !!}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Contact Info -->
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Contact Info') }}</h4>
                                    <div class="row rg-25">
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epPhoneNumber" class="form-label">{{ __('Phone Number')
                                                    }}</label>
                                                    <input type="mobile" value="{{auth('alumni')->user()->phone}}"
                                                           name="mobile"
                                                           class="primary-form-control" id="epPhoneNumber"
                                                           placeholder="eg: (+880) 1254 8593"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epEmail" class="form-label">{{ __('Personal Email Address')
                                                    }}</label>
                                                    <input type="email" value="{{auth('alumni')->user()->email}}"
                                                           name="email"
                                                           class="primary-form-control" id="epEmail"
                                                           placeholder="{{ __('Your Email') }}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="primary-form-group">
                                                <div class="primary-form-group-wrap">
                                                    <label for="epLinkedin"
                                                           class="form-label">{{ 'Linkedin Url' }}</label>
                                                    <input type="url"
                                                           value="{{ auth('alumni')->user()?->linkedin_url }}"
                                                           name="linkedin_url" class="primary-form-control"
                                                           id="epLinkedin"
                                                           placeholder="{{ __('Your Linkedin Profile Url') }}"/>
                                                </div>
                                            </div>
                                        </div>
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="primary-form-group">--}}
{{--                                                <div class="primary-form-group-wrap">--}}
{{--                                                    <label for="epFacebook" class="form-label">{{ __('Facebook Url')--}}
{{--                                                    }}</label>--}}
{{--                                                    <input type="url"--}}
{{--                                                           value="{{ auth('alumni')->user()?->facebook_url }}"--}}
{{--                                                           name="facebook_url" class="primary-form-control"--}}
{{--                                                           id="epFacebook"--}}
{{--                                                           placeholder="{{ __('Your Facebook Profile Url') }}"/>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="primary-form-group">--}}
{{--                                                <div class="primary-form-group-wrap">--}}
{{--                                                    <label for="epTwitter" class="form-label">{{ __('Twitter Url')--}}
{{--                                                    }}</label>--}}
{{--                                                    <input type="url" value="{{ auth('alumni')->user()?->twitter_url }}"--}}
{{--                                                           name="twitter_url" class="primary-form-control"--}}
{{--                                                           id="epTwitter"--}}
{{--                                                           placeholder="{{ __('Your Twitter Profile Url') }}"/>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col-md-6">--}}
{{--                                            <div class="primary-form-group">--}}
{{--                                                <div class="primary-form-group-wrap">--}}
{{--                                                    <label for="epInstagram" class="form-label">{{ __('Instagram Url')--}}
{{--                                                    }}</label>--}}
{{--                                                    <input type="url"--}}
{{--                                                           value="{{ auth('alumni')->user()?->instagram_url }}"--}}
{{--                                                           name="instagram_url" class="primary-form-control"--}}
{{--                                                           id="epInstagram"--}}
{{--                                                           placeholder="{{ __('Your Instagram Profile Url') }}"/>--}}
{{--                                                </div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Education Info') }}</h4>
                                    <div class="row rg-25">

                                        @forelse (auth('alumni')->user()->education as $education)

                                            <div class="education-item">
                                                <input type="hidden" name="education[id][]"
                                                       value="{{ $education->id }}">
                                                @if ($loop->first)
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">
                                                            {{ __('Educational Info') }}</h4>
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addMoreModal">{{ __('+Add
                                                    More') }}</button>
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-education">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="d-flex justify-content-end align-items-center flex-wrap g-10 pb-20">
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-education">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row rg-25">
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epDegree" class="form-label">{{ __('Education Type')
                                                            }}</label>
                                                                <select class="form-control" id="educationType"
                                                                        name="education[type][]">
                                                                    <option
                                                                        {{$education->type=="university"?'selected':''}} value="university">
                                                                        University
                                                                    </option>
                                                                    --}}
                                                                    <option
                                                                        {{$education->type=="high_school"?'selected':''}} value="high_school">
                                                                        High School
                                                                    </option>
                                                                    --}}
                                                                    <option
                                                                        {{$education->type=="other"?'selected':''}} value="other">
                                                                        Other
                                                                    </option>
                                                                    --}}
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epPassingYear"
                                                                       class="form-label">{{ __('Name') }}</label>
                                                                <input type="text" value="{{ $education->name }}"
                                                                       name="education[name][]"
                                                                       class="institution-passing_year primary-form-control"
                                                                       id="epPassingYear"
                                                                       placeholder="{{ __('Name') }}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epInstitute" class="form-label">{{ __('Start Date')
                                                            }}</label>
                                                                <input type="date" value="{{ $education->start_date }}"
                                                                       name="education[start_date][]"
                                                                       class="institution-institute primary-form-control"
                                                                       id="epInstitute"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epInstitute" class="form-label">{{ __('End Date')
                                                            }}</label>
                                                                <input type="date" value="{{ $education->end_date }}"
                                                                       name="education[end_date][]"
                                                                       class="institution-institute primary-form-control"
                                                                       id="epInstitute"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">

                                                                <label for="epInstitute"
                                                                       class="form-label">{{ __('Title')}}</label>
                                                                <input type="text" value="{{ $education->title }}"
                                                                       name="education[title][]"
                                                                       class="institution-institute primary-form-control"
                                                                       id="epInstitute">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Educational Info') }}
                                                </h4>
                                                <div class="d-flex align-items-center cg-16">
                                                    <button type="button"
                                                            class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                            data-bs-toggle="modal" data-bs-target="#addMoreModal">{{ __('+Add New')
                                                }}</button>
                                                </div>
                                            </div>
                                            <div class="">
                                                <span>{{ __('No Educational Info Found') }}</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Experience Info') }}</h4>
                                    <div class="row rg-25">
                                        @forelse (auth('alumni')->user()->experience as $experience)

                                            <div class="experience-item">
                                                <input type="hidden" name="experience[id][]"
                                                       value="{{ $experience->id }}">
                                                @if ($loop->first)
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">
                                                            {{ __('Experience Info') }}</h4>
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addExperienceModal">{{ __('+Add
                                                    More') }}</button>
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-experience">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="d-flex justify-content-end align-items-center flex-wrap g-10 pb-20">
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-experience">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row rg-25">
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epDegree" class="form-label">{{ __('Position')
                                                            }}</label>
                                                                <input type="text" value="{{ $experience->position }}"
                                                                       name="experience[position][]"
                                                                       class="institution-passing_year primary-form-control"
                                                                       id="epPassingYear"
                                                                       placeholder="{{ __('Position') }}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epPassingYear"
                                                                       class="form-label">{{ __('Name') }}</label>
                                                                <input type="text" value="{{ $experience->name }}"
                                                                       name="experience[name][]"
                                                                       class="institution-passing_year primary-form-control"
                                                                       id="epPassingYear"
                                                                       placeholder="{{ __('Name') }}"/>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epInstitute" class="form-label">{{ __('Start Date')
                                                            }}</label>
                                                                <input type="date" value="{{ $experience->start_date }}"
                                                                       name="experience[start_date][]"
                                                                       class="institution-institute primary-form-control"
                                                                       id="epInstitute"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epInstitute" class="form-label">{{ __('End Date')
                                                            }}</label>
                                                                <input type="date" value="{{ $experience->end_date }}"
                                                                       name="experience[end_date][]"
                                                                       class="institution-institute primary-form-control"
                                                                       id="epInstitute"
                                                                />
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="primary-form-group">
                                                            <div class="primary-form-group-wrap">
                                                                <label for="epInstitute"
                                                                       class="form-label">{{ __('Details')}}</label>
                                                                <textarea name="experience[details][]"
                                                                          class="primary-form-control summernoteOne min-h-180"
                                                                          id="eventDescription" placeholder="Details"
                                                                          spellcheck="false">{{$experience->details}}</textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div
                                                class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Experience Info') }}
                                                </h4>
                                                <div class="d-flex align-items-center cg-16">
                                                    <button type="button"
                                                            class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                            data-bs-toggle="modal" data-bs-target="#addExperienceModal">{{ __('+Add New')
                                                }}</button>
                                                </div>
                                            </div>
                                            <div class="">
                                                <span>{{ __('No Experience Info Found') }}</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Skills') }}</h4>
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="skills" class="form-label">Skills</label>
                                            <select class="form-control skills-select" name="skills[]" multiple="multiple">
                                            @if(json_decode(auth('alumni')->user()->skills))
                                                    @foreach (json_decode(auth('alumni')->user()->skills) as $skill)
                                                        <option value="{{ $skill }}" selected="selected">{{ $skill }}</option>
                                                    @endforeach
                                            @endif

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!-- Address -->
                                <div class="pb-30">
                                    <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('CVs Info') }}</h4>
                                    <div class="row rg-25 ">
                                        @forelse (auth('alumni')->user()->cvs as $cv)

                                            <div class="cv-item col-md-4">
                                                <input type="hidden" name="cv[id][]"
                                                       value="{{ $cv->id }}">
                                                @if ($loop->first)
                                                    <div
                                                        class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">
                                                            {{ __('CV Info') }}</h4>
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#addCVModal">{{ __('+Add
                                                    More') }}</button>
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-cv">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div
                                                        class="d-flex justify-content-end align-items-center flex-wrap g-10 pb-20">
                                                        <div class="d-flex align-items-center cg-16">
                                                            <button type="button"
                                                                    class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-ed0006 text-decoration-underline hover-color-one delete-cv">{{
                                                    __('Delete') }}</button>
                                                        </div>
                                                    </div>
                                                @endif


                                                <div class="container">
                                                    <div class="card">

                                                        <div class="card-body">
                                                            <embed
                                                                src="{{asset('public/storage/alumni/cv').'/'.$cv->name}}"
                                                                type="application/pdf" width="100%" height="500px">

                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        @empty
                                            <div
                                                class="d-flex justify-content-between align-items-center flex-wrap g-10 pb-20">
                                                <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Experience Info') }}
                                                </h4>
                                                <div class="d-flex align-items-center cg-16">
                                                    <button type="button"
                                                            class="border-0 p-0 bg-transparent fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one"
                                                            data-bs-toggle="modal" data-bs-target="#addCVModal">{{ __('+Add New')
                                                }}</button>
                                                </div>
                                            </div>
                                            <div class="">
                                                <span>{{ __('No Experience Info Found') }}</span>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <button type="submit"
                                        class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{
                                __('Save Changes') }}</button>
                            </form>
                            <div class="pb-30 py-30">
                                <h4 class="fs-18 fw-500 lh-22 text-f1a527 pb-20">{{ __('Change Password') }}</h4>
                                <div class=" container rg-25">
                                    <form id="changePasswordForm" action="{{ route('alumni.change-password') }}" method="POST">
                                        @csrf
                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <div class="primary-form-group">
                                                    <div class="primary-form-group-wrap">
                                                        <label for="current_password" class="form-label">{{ __('Current Password') }}</label>
                                                        <input type="password" name="current_password" class="primary-form-control" placeholder="Enter Old Password" required />
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


                                        <button type="submit" class="py-13 mt-17 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">Reset</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="modal fade zModalTwo" id="addMoreModal" tabindex="-1" aria-labelledby="addMoreModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content zModalTwo-content">
                    <div class="modal-body zModalTwo-body">
                        <!-- Header -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{ __('Add Info') }}</h4>
                            <div class="mClose">
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                                        src="{{ asset('assets/images/icon/delete.svg') }}" alt=""/></button>
                            </div>
                        </div>
                        <!-- Body -->
                        <form method="POST" class="ajax" data-handler="commonResponseForModal"
                              action="{{ route('alumni.profile.add-education') }}">
                            @csrf
                            <div class="pb-25">
                                <div class="row rg-25">
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="educationType"
                                                       class="form-label">{{ __('Education Type')}}</label>
                                                <select class="form-control" id="educationType" name="education_type">
                                                    <option value="university">University</option>
                                                    <option value="high_school">High School</option>
                                                    <option value="other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epEmail" class="form-label">{{ __('Education Name')
                                                                                  }}</label>
                                                <input type="text" class="form-control" id="educationName"
                                                       name="education_name"
                                                       placeholder="Enter the name of the institution" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="startDate">Start Date</label>
                                                <input type="date" class="form-control" id="startDate"
                                                       name="education_start_date" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="endDate">End Date</label>

                                                <input type="date" class="form-control" id="endDate"
                                                       name="education_end_date" required>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="epTwitter" class="form-label">{{ __('Title')}}</label>
                                                <input type="text" class="form-control" id="title"
                                                       name="education_title" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button type="submit"
                                    class="py-13 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{
                        __('Save Now') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="addCVModal" tabindex="-1" aria-labelledby="addCVModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExperienceModalLabel">Add Experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="experienceForm" action="{{ route('alumni.profile.add-cv') }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            <div class="row">

                                <div class="col-lg-12">
                                    <label for="pdf" class="form-label">CV (PDF only)</label>

                                    <input type="file" class="form-control" id="pdf" multiple name="cv[]"
                                           accept="application/pdf" required>

                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="saveExperienceBtn">Save Experience
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="addExperienceModal" tabindex="-1" aria-labelledby="addExperienceModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addExperienceModalLabel">Add Experience</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="experienceForm" action="{{ route('alumni.profile.add-experience') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="companyName" class="form-label">Company Name</label>
                                        <input type="text" class="form-control" id="companyName" name="name"
                                               placeholder="Your Current Company">
                                    </div>
                                </div>

                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="position" class="form-label">Position</label>
                                        <input type="text" class="form-control" id="position" name="position"
                                               placeholder="Your Position">
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="mb-3">
                                        <label for="companyAddress" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="companyAddress"
                                               name="experience_address" placeholder="Your Company Address">
                                    </div>
                                </div>
                                <div class="col-lg-4">

                                    <label for="startDate" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="start_date">

                                </div>
                                <div class="col-lg-4">

                                    <label for="endDate" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="end_date">

                                </div>
                                <div class="col-lg-12">
                                    <label for="experienceDescription" class="form-label">Description <span
                                            class="text-danger">*</span></label>
                                    <textarea name="description"
                                              class="primary-form-control summernoteOne min-h-180"
                                              id="eventDescription" placeholder="Details"
                                              spellcheck="false"></textarea>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary" id="saveExperienceBtn">Save Experience
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="companySectionContainer"></div>
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
        <script>
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

    <script src="{{ asset('public/alumni/js/profile.js') }}"></script>
    <script src="{{ asset('public/alumni/js/cvs.js') }}"></script>
@endpush
