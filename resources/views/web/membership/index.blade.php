@extends('frontend.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100" data-background="{{ getSettingImage('page_breadcrumb') }}">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{ $title }}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('all.membership') }}">{{ $title }}</a></li>
            </ul>
        </div>
    </section>


    <section class="pb-110 pt-60">
        <div class="container">
            <!--  -->
            @auth()
                <div class="max-w-437 m-auto pb-40">
                    <div class="pt-19 pb-22 px-20 bg-event-bg bd-ra-20 d-flex align-items-start cg-11">
                        @if ($user->currentMembership)
                            <p
                                class="align-items-center bg-success d-flex flex-shrink-0 fs-20 fw-600 h-40 justify-content-center lh-28 rounded-circle text-white w-40">
                                <i class="fa-solid fa-check"></i>
                            </p>
                        @else
                            <p
                                class="w-40 h-40 rounded-circle d-flex justify-content-center align-items-center bg-color3 fs-20 fw-600 lh-28 text-red">
                                !</p>
                        @endif
                        <div class="">
                            @if (auth()->user() && $user->currentMembership)
                                <h4 class="fs-18 fw-500 lh-28 text-black pb-6">{{ __('Currently you are') }}
                                    {{ $user->currentMembership->membership->title }} {{ __('Member') }}</h4>
                                <p
                                    class="bd-one bd-c-stroke-color bd-ra-7 bg-black-color fs-18 fw-500 lh-22 text-white d-inline-block py-4 px-9">
                                    {{ __('Expire at') }} : {{ $user->currentMembership->expired_date }}</p>
                            @else
                                <h4 class="fs-18 fw-500 lh-28 text-black">{{ __('Currently you have no membership plan') }}
                                </h4>
                            @endif
                        </div>
                    </div>
                </div>
            @endauth
            <!--  -->


            <!-- membership package -->
            <div class="max-w-964 m-auto">
                <div class="row rg-30">

                    @forelse ($all_membership as $membership)
                        <div class="col-lg-4 col-sm-6">
                            <div
                                class="bd-c-stroke-color bd-one bd-ra-12 m-auto max-w-303 @if (!(auth()->user() && $user->currentMembership && $user->currentMembership->membership_id == $membership->id)) membership-plan-active @endif p-20">
                                <div class="bd-b-one bd-c-stroke-color pb-24 mb-24">
                                    <div class="max-w-60 mb-24"><img src="{{ getFileUrl($membership->badge) }}"
                                            alt=""></div>
                                    <h4 class="fs-18 fw-500 lh-18 text-black-color pb-12">{{ $membership->title }}</h4>
                                    <p class="fs-18 fw-500 lh-18 text-para-color"><span
                                            class="fs-36 fw-600 lh-36 text-black-color">{{ showPrice($membership->price) }}</span>/{{ $membership->duration }}{{ getDurationType($membership->duration_type) }}
                                    </p>
                                </div>
                                @if (auth()->user() && $user->currentMembership && $user->currentMembership->membership_id == $membership->id)
                                    <button disabled
                                        class="d-inline-block bd-ra-12 bg-border-color border-0 fs-15 fw-500 lh-25 px-25 py-16 text-black-color">
                                        {{ __('Get Membership') }}</button>
                                @else
                                    <a href="{{ route('membership-package') }}"
                                        class="d-inline-block bd-ra-12 bg-border-color border-0 fs-15 fw-500 lh-25 px-25 py-16 text-black-color hover-bg-color-one">
                                        {{ __('Get Membership') }}</a>
                                @endif

                            </div>
                        </div>
                    @empty
                        <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{ __('No Membership Found') }}</p>
                    @endforelse

                </div>
            </div>
        </div>
    </section>
@endsection
