@extends('layouts.app')
@push('title')
{{ __('Profile View') }}
@endpush
@section('content')
<div class="p-30">
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Alumni Profile View') }}</h4>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <div class="bd-b-one bd-c-ededed mb-35">
                <div class="row justify-content-between">
                    <div class="col-md-5">
                        <!-- User Photo ~ name ~ Social Link -->
                        <div class="d-flex align-items-center flex-wrap g-18 pb-30 border-item-one">
                            <div class="zUser-one">
                                <div
                                    class="flex-shrink-0 w-110 h-110 rounded-circle overflow-hidden bd-three bd-c-cdef84">
                                    <img class="w-100" src="{{ asset(getFileUrl($user->image)) }}" alt="{{ $user->name }}" />
                                </div>
                                @if (!$user->currentMembership == null)
                                    <div class="zBadge"><img src="{{ getFileUrl($user->currentMembership->badge)}}" alt="" /></div>
                                @endif
                            </div>
                            <div class="">
                                <h4 class="fs-24 fs-sm-20 fw-500 lh-34 text-1b1c17">{{ $user->name }}</h4>
                                <p class="fs-14 fw-400 lh-17 text-707070 pb-10">{{ $user->alumni?->company_designation }}</p>
                                <!-- social link -->
                                <ul class="d-flex align-items-center cg-7">
                                    @if($user->alumni?->facebook_url != NULL && $user->alumni?->facebook_url != '')
                                    <li>
                                        <a target="__blank" href="{{ $user->alumni?->facebook_url }}"
                                            class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white bg-fafafa hover-bg-two hover-border-one"><img
                                                src="{{ asset('assets/images/icon/facebook-2.svg')}}" alt="" /></a>
                                    </li>
                                    @endif
                                    @if($user->alumni?->twitter_url != NULL && $user->alumni?->twitter_url != '')
                                    <li>
                                        <a target="__blank" href="{{ $user->alumni?->twitter_url }}"
                                            class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white bg-fafafa hover-bg-two hover-border-one"><img
                                                src="{{ asset('assets/images/icon/twitter-2.svg')}}" alt="" /></a>
                                    </li>
                                    @endif
                                    @if($user->alumni?->linkedin_url != NULL && $user->alumni?->linkedin_url != '')
                                    <li>
                                        <a target="__blank" href="{{ $user->alumni?->linkedin_url }}"
                                            class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white bg-fafafa hover-bg-two hover-border-one"><img
                                                src="{{ asset('assets/images/icon/linkedin-2.svg')}}" alt="" /></a>
                                    </li>
                                    @endif
                                    @if($user->alumni?->instagram_url != NULL && $user->alumni?->instagram_url != '')
                                    <li>
                                        <a target="__blank" href="{{ $user->alumni?->instagram_url }}"
                                            class="d-flex justify-content-center align-items-center w-30 h-30 rounded-circle bd-one bd-c-ededed bg-white bg-fafafa hover-bg-two hover-border-one"><img
                                                src="{{ asset('assets/images/icon/instagram-2.svg')}}" alt="" /></a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-7">
                        <!-- Phone ~ Email -->
                        <ul class="zList-two pb-30">
                            @if($user->show_phone_in_public == STATUS_SUCCESS)
                            <li>
                                <div class="icon"><img src="{{ asset('assets/images/icon/phone.svg')}}" alt="" /></div>
                                <p>{{ $user->mobile }}</p>
                            </li>
                            @endif
                            @if($user->show_email_in_public == STATUS_SUCCESS)
                            <li>
                                <div class="icon"><img src="{{ asset('assets/images/icon/envelope-1.svg')}}" alt="" /></div>
                                <p>{{ $user->email }}</p>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Bio ~ Info -->
            <div class="row rg-30">
                <!-- Bio -->
                <div class="col-lg-8">
                    <div class="py-20 px-25 bd-ra-10 bg-f9f9f9">
                        <!-- Bio text -->
                        <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                            <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-10">{{ __('Profile Bio') }}</h4>
                            <p class="fs-14 fw-400 lh-24 text-707070 pb-12">{!! $user->alumni?->about_me !!}</p>
                        </div>
                        <!-- Personal Info -->
                        <ul class="zList-one">
                            <li>
                                <p>{{ __('Full Name') }} :</p>
                                <p>{{ $user->name }}</p>
                            </li>
                            <li>
                                <p>{{ __('Nick Name') }} :</p>
                                <p>{{ $user->nick_name }}</p>
                            </li>
                            @if($user->show_email_in_public == STATUS_SUCCESS)
                            <li>
                                <p>{{ __('Email') }} :</p>
                                <p>{{ $user->email }}</p>
                            </li>
                            @endif
                            @if($user->show_phone_in_public == STATUS_SUCCESS)
                            <li>
                                <p>{{ __('Phone') }} :</p>
                                <p>{{ $user->mobile }}</p>
                            </li>
                            @endif
                            <li>
                                <p>{{ __('Blood Group') }} :</p>
                                <p>{{ $user->alumni?->blood_group }}</p>
                            </li>
                            <li>
                                <p>{{ __('Date of Birth') }} :</p>
                                <p>{{ $user->alumni?->date_of_birth }}</p>
                            </li>
                            <li>
                                <p>{{ __('City') }} :</p>
                                <p> {{ $user->alumni?->city }}</p>
                            </li>
                            <li>
                                <p>{{ __('State') }} :</p>
                                <p> {{ $user->alumni?->state }}</p>
                            </li>
                            <li>
                                <p>{{ __('Country') }} :</p>
                                <p>{{ $user->alumni?->country }}</p>
                            </li>
                            <li>
                                <p>{{ __('Zip Code') }} :</p>
                                <p>{{ $user->alumni?->zip }}</p>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- Info -->
                <div class="col-lg-4">
                    <div class="py-20 px-30 bd-ra-10 bg-f9f9f9 max-w-503 m-auto">
                        <div class="pb-25 mb-25 bd-b-one bd-c-ededed">
                            <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-10">{{ __('Educational Info') }}</h4>
                            @forelse ($user->institutions as $institute)
                            <div class="{{ $loop->last ? '' : 'pb-17' }}">
                                <p class="fs-14 fw-400 lh-17 text-707070 pb-10">{{ $institute->degree }}</p>
                                <ul class="zList-one">
                                    <li>
                                        <p>{{ __('Institute') }} :</p>
                                        <p>{{ $institute->institute }}</p>
                                    </li>
                                    <li>
                                        <p>{{ __('Passing Year') }} :</p>
                                        <p>{{ $institute->passing_year }}</p>
                                    </li>
                                </ul>
                            </div>
                            @empty
                            <div>
                                <p class="fs-14 fw-400 lh-17 text-707070 pb-10">{{ __('No Educational Info Found') }}
                                </p>
                            </div>
                            @endforelse
                        </div>
                        <div class="">
                            <h4 class="fs-18 fw-500 lh-22 text-1b1c17 pb-10">{{ __('Professional Info') }}</h4>
                            <ul class="zList-one">
                                <li>
                                    <p>{{ __('Company Name') }} :</p>
                                    <p>{{ $user->alumni?->company }}</p>
                                </li>
                                <li>
                                    <p>{{ __('Designation') }} :</p>
                                    <p>{{ $user->alumni?->company_designation }}</p>
                                </li>
                                <li>
                                    <p>{{ __('Office Address') }} :</p>
                                    <p>{{ $user->alumni?->company_address }}</p>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
