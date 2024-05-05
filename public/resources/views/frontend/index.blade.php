@extends('frontend.layouts.app')
@push('title')
    {{ __('Home') }}
@endpush
@section('content')

    <!-- Start Banner -->
    <section class="home-banner" data-background="{{ asset(getFileUrl(getOption('banner_background_breadcrumb'))) }}">
        <div class="container">
            <div class="row justify-content-center position-relative">
                <div class="col-lg-10">
                    <div class="text-center">
                        <h4 class="fs-74 fw-700 lh-84 text-white pb-21">{{ getOption('banner_title') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-white max-w-833 m-auto pb-29">{{ getOption('banner_description') }}
                        </p>
                        <div class="d-flex justify-content-center align-items-center flex-wrap g-10">
                            <a href="#about-us-section"
                                class="py-15 px-32 bd-one bd-c-primary-color bd-ra-12 d-flex align-items-center cg-16 bg-primary-color fs-18 fw-600 lh-28 text-black-color hover-color-white hover-bg-color-transparent hover-border-color-white">
                                {{ __('About Us') }}
                                <i class="fa-solid fa-long-arrow-right"></i>
                            </a>
                            <a href="{{ route('all.event') }}"
                                class="py-15 px-32 bd-one bd-c-white bd-ra-12 d-flex align-items-center cg-16 bg-transparent fs-18 fw-600 lh-28 text-white hover-bg-color-primary hover-border-color-primary hover-color-black">
                                {{ __('All Events') }}
                                <i class="fa-solid fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Banner -->

    <!-- Start Join with community -->
    <section class="joinCommunity-section pb-110">
        <div class="container">
            <div class="joinCommunity-wrap bg-event-bg py-78 px-10 bd-one bd-c-black-10 bd-ra-25 text-center"
                data-background="{{ asset('public/frontend/images/community-bg-1.png') }}">
                <span
                    class="d-inline-block py-15 px-25 bg-color4 bd-ra-12 fs-18 fw-400 lh-18 text-black-color mb-23">{{ __('Join With Community') }}</span>
                <h4 class="fs-36 fw-600 lh-36 text-black pb-42">{{ __('Why you should join us') }}</h4>
                <div class="items d-flex justify-content-center flex-wrap g-25">
                    <div
                        class="item flex-grow-1 max-w-370 bd-one bd-c-black-10 bd-ra-14 px-26 pt-51 pb-35 bg-white text-center hover-scale-1-1">
                        <img src="{{ asset(getFileUrl(getOption('join_us_left_icon'))) }}" class="mb-20" alt="" />
                        <h4 class="fs-24 fw-500 lh-28 text-black-color pb-9">{{ getOption('join_us_left_title') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">{!! getOption('join_us_left_description') !!}</p>
                    </div>
                    <div
                        class="item flex-grow-1 max-w-370 bd-one bd-c-black-10 bd-ra-14 px-26 pt-51 pb-35 bg-white text-center hover-scale-1-1">
                        <img src="{{ asset(getFileUrl(getOption('join_us_middle_icon'))) }}" class="mb-20"
                            alt="" />
                        <h4 class="fs-24 fw-500 lh-28 text-black-color pb-9">{{ getOption('join_us_middle_title') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">{!! getOption('join_us_middle_description') !!}</p>
                    </div>
                    <div
                        class="item flex-grow-1 max-w-370 bd-one bd-c-black-10 bd-ra-14 px-26 pt-51 pb-35 bg-white text-center hover-scale-1-1">
                        <img src="{{ asset(getFileUrl(getOption('join_us_right_icon'))) }}" class="mb-20"
                            alt="" />
                        <h4 class="fs-24 fw-500 lh-28 text-black-color pb-9">{{ getOption('join_us_right_title') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">{!! getOption('join_us_right_description') !!}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Join with community -->

    <!-- Start About -->
    <section class="position-relative" id="about-us-section">
        <div class="about-img position-absolute bottom-0 start-0 d-none d-xl-block"><img
                src="{{ asset(getFileUrl(getOption('about_us_background_breadcrumb'))) }}" alt="" /></div>
        <div class="container">
            <div class="row justify-content-center justify-content-xl-end">
                <div class="col-xl-8 col-lg-10">
                    <div class="about-content">
                        <span
                            class="py-15 px-25 d-inline-block mb-29 bg-white bd-ra-12 fs-18 fw-400 lh-18 text-black-color">{{ __('About Us') }}</span>
                        <h4 class="pb-32 fs-50 fw-700 lh-46 text-black-color">{{ getOption('about_us_title') }}</h4>
                        <div class="list-pb-22">
                            {!! getOption('about_us_description') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End About -->

    <!-- Start Upcoming Events -->
    @if (count($upcomingEvents))
        <section class="upcoming-events"
            data-background="{{ asset(getFileUrl(getOption('upcoming_events_background'))) }}">
            <div class="container position-relative">
                <div class="row justify-content-center">
                    <div class="col-lg-10">
                        <!--  -->
                        <div class="text-center pb-37 max-w-677 m-auto">
                            <span
                                class="d-inline-block py-15 px-25 rounded-pill bd-one bd-c-white fs-18 fw-400 lh-18 text-white mb-22">{{ __('Upcoming Events') }}</span>
                            <h4 class="pb-18 fs-50 fw-700 lh-50 text-white">{{ __('Our Upcoming Events') }}</h4>
                            <p class="fs-18 fw-400 lh-28 text-white">
                                {{ __('Zaialumni is a user friendly that helps alumni easily connect and manage their activities. Alumni can sign up and get approved by submitting necessary.') }}
                            </p>
                        </div>
                        <!--  -->
                        <div class="swiper upcomingEvent bd-ra-25">
                            <div class="swiper-wrapper">
                                @foreach ($upcomingEvents as $upcomingEvent)
                                    <div class="swiper-slide">
                                        <div class="event-slider">
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <div class="up-event-content">
                                                        <div
                                                            class="d-flex justify-content-center justify-content-xl-start align-items-center cg-63 pb-11">
                                                            <p
                                                                class="fs-18 fw-500 lh-28 text-para-color line-horizontal-event">
                                                                {{ \Carbon\Carbon::parse($upcomingEvent->date)->format('M d, Y') }}
                                                            </p>
                                                            <p class="fs-18 fw-500 lh-28 text-para-color">
                                                                {{ \Carbon\Carbon::parse($upcomingEvent->date)->format('h:i A') }}
                                                            </p>
                                                        </div>
                                                        <a href="{{ route('event.view.details', $upcomingEvent->slug) }}"
                                                            class="d-inline-block fs-36 fw-600 lh-46 text-black-color mb-14 line-clamp-2 sf-text-ellipsis min-h-92">{{ $upcomingEvent->title }}</a>
                                                        <div
                                                            class="d-flex justify-content-center justify-content-xl-start align-items-center cg-7 pb-23">
                                                            <div class="d-flex"><img
                                                                    src="{{ asset('public/frontend/images/icon/location.svg') }}"
                                                                    alt=""></div>
                                                            <p class="fs-18 fw-500 lh-28 text-para-color">
                                                                {{ $upcomingEvent->location }}</p>
                                                        </div>
                                                        <ul class="event-duration"
                                                            data-countdown-date="{{ \Carbon\Carbon::parse($upcomingEvent->date)->format('m/d/Y H:i:s') }}">
                                                            <li class="item">
                                                                <h4 class="eTime" data-hours></h4>
                                                                <p class="eInfo">{{ __('Hours') }}</p>
                                                            </li>
                                                            <li class="separate">:</li>
                                                            <li class="item">
                                                                <h4 class="eTime" data-minutes></h4>
                                                                <p class="eInfo">{{ __('Minutes') }}</p>
                                                            </li>
                                                            <li class="separate">:</li>
                                                            <li class="item">
                                                                <h4 class="eTime" data-seconds></h4>
                                                                <p class="eInfo">{{ __('Second') }}</p>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-xl-6">
                                                    <a href="{{ route('event.view.details', $upcomingEvent->slug) }}"
                                                        class="up-event-img hover-scale-img-two"><img
                                                            src="{{ getFileUrl($upcomingEvent->thumbnail) }}"
                                                            alt="{{ $upcomingEvent->title }}"
                                                            class="w-100 h-100 object-fit-cover" /></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="upEvent-button">
                                <div class="swiper-button-next"><i class="fa-solid fa-long-arrow-right"></i></div>
                                <div class="swiper-button-prev"><i class="fa-solid fa-long-arrow-left"></i></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- End Upcoming Events -->

    <!-- Start Stories -->
    <section class="pt-110 pb-110 position-relative">
        <div class="world-map"><img src="{{ asset('public/frontend/images/world-map.png') }}" alt="" /></div>
        <div class="container position-relative">
            <div class="row">
                <div class="col-lg-6">
                    <div class="header-one">
                        <span
                            class="d-inline-block py-15 px-25 bg-color4 bd-ra-12 fs-18 fw-400 lh-18 text-black-color mb-19">{{ __('Stories') }}</span>
                        <h4 class="fs-50 fw-700 lh-60 text-black-color pb-38">{{ __('Our Stories') }}</h4>
                    </div>
                    <ul class="stories-list">
                        @foreach ($stories as $story)
                            <li class="hover-scale-img">
                                <div class="img"><img src="{{ getFileUrl($story->thumbnail) }}"
                                        alt="{{ $story->title }}" /></div>
                                <div class="content">
                                    <div class="d-flex align-items-center cg-11 pb-10">
                                        <div class="d-flex"><img src="{{ asset('public/frontend/images/icon/calendar-1.svg') }}"
                                                alt=""></div>
                                        <p class="fs-18 fw-400 lh-18 text-para-color">
                                            {{ \Carbon\Carbon::parse($story->created_at)->format('M d, Y') }}</p>
                                    </div>
                                    <h4
                                        class="mb-16 min-h-68 line-clamp-2 sf-text-ellipsis fs-24 fw-500 lh-34 text-black-color">
                                        {{ $story->title }}</h4>
                                    <a href="{{ route('story.view', $story->slug) }}"
                                        class="d-flex align-items-center cg-16 fs-18 fw-600 lh-28 text-black-color">
                                        {{ __('Know More') }}
                                        <span><i class="fa-solid fa-arrow-right"></i></span>
                                    </a>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-6">
                    <div class="stories-right">
                        <h4 class="max-w-291 pb-17 fs-36 fw-700 lh-46 text-black-color">
                            {{ __('Your network around the globe.') }}</h4>
                        <p class="max-w-486 pb-26 fs-18 fw-400 lh-28 text-para-color">
                            {{ __('Connect alumni with mentors or coaches who can offer them guidance, advice, or feedback on their personal or professional goals, They can also help them expand their network.') }}
                        </p>
                        <a href="{{ route('login') }}"
                            class="mb-54 py-15 px-32 bd-ra-12 d-inline-flex align-items-center cg-16 bg-primary-color fs-18 fw-600 lh-28 text-black-color hover-bg-color-one">
                            {{ __('Join Community') }}
                            <i class="fa-solid fa-long-arrow-right"></i>
                        </a>
                        <div
                            class="d-flex justify-content-center flex-sm-wrap flex-md-nowrap flex-column flex-sm-row align-items-center align-items-sm-start g-24">

                            <div
                                class="flex-grow-1 max-w-sm-188 w-100 p-30 bd-one bd-c-black-10 bd-ra-10 bg-event-bg d-flex flex-column justify-content-center align-items-center hover-scale-1-1 countUp-item">
                                <h4 class="fs-36 fw-600 lh-36 text-black-color counter">
                                    {{ $totalAlumni }}
                                </h4>
                                <p class="fs-18 fw-400 lh-28 text-para-color">{{ __('Member') }}</p>
                            </div>
                            <div
                                class="flex-grow-1 max-w-sm-188 w-100 p-30 bd-one bd-c-black-10 bd-ra-10 bg-event-bg d-flex flex-column justify-content-center align-items-center hover-scale-1-1 countUp-item">
                                <h4 class="fs-36 fw-600 lh-36 text-black-color counter">
                                    {{ $totalDepartments }}
                                </h4>
                                <p class="fs-18 fw-400 lh-28 text-para-color">{{ __("Department's") }}</p>
                            </div>
                            <div
                                class="flex-grow-1 max-w-sm-188 w-100 p-30 bd-one bd-c-black-10 bd-ra-10 bg-event-bg d-flex flex-column justify-content-center align-items-center hover-scale-1-1 countUp-item">
                                <h4 class="fs-36 fw-600 lh-36 text-black-color counter">
                                    {{ $totalSessions }}
                                </h4>
                                <p class="fs-18 fw-400 lh-28 text-para-color">{{ __('Sessions') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Stories -->

    <!-- Start New Alumni -->
    <section class="pb-110">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-6">
                    <!--  -->
                    <div class="text-center pb-50 header-one">
                        <span
                            class="d-inline-block py-15 px-25 bg-color4 bd-ra-12 fs-18 fw-400 lh-18 text-black-color mb-25">{{ __('New Alumni') }}</span>
                        <h4 class="fs-50 fw-700 lh-60 text-black-color pb-14">{{ __('Recent Join Alumni') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">
                            {{ __('The Alumni Association leverages the resources, talents, and initiatives of alumni and friends to advise, guide, advocate for and support the Association.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="row rg-24">
                @foreach ($alumnus as $alumni)
                    <div class="col-lg-3 col-md-4 col-sm-6">
                        <div class="bd-ra-25 bg-event-bg hover-scale-img">
                            <div class="bd-ra-25 overflow-hidden h-341">
                                <img class="w-100 h-100 object-fit-cover" src="{{ getFileUrl($alumni->image) }}"
                                    alt="{{ $alumni->name }}" />
                            </div>
                            <div class="pt-21 pb-23 px-10 text-center">
                                <h4 class="fs-20 fw-600 lh-28 text-black-color pb-2">{{ $alumni->name }}</h4>
                                <p class="fs-18 fw-400 lh-28 text-para-color">{{ $alumni->department_name }},
                                    {{ __('Batch') }} {{ $alumni->batch_name }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- End New Alumni -->

    <!-- Start Gallery -->
    <section class="pb-110">
        <div class="container">
            <!--  -->
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <!--  -->
                    <div class="text-center pb-50 header-one">
                        <span
                            class="d-inline-block py-15 px-25 bg-color4 bd-ra-12 fs-18 fw-400 lh-18 text-black-color mb-25">{{ __('Gallery') }}</span>
                        <h4 class="fs-50 fw-700 lh-60 text-black-color pb-14">{{ __('Image Gallery') }}</h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">
                            {{ __('The Alumni Association leverages the resources, talents, and initiatives of alumni and friends to advise.') }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="swiper imageGallery">
                <div class="swiper-wrapper">
                    @foreach ($photoGalleries as $photoGallery)
                        <div class="swiper-slide">
                            <div class="galleryImage-item bd-ra-25 overflow-hidden galleryMain">
                                <a href="{{ getFileUrl($photoGallery->photo) }}" title="{{ $photoGallery->caption }}">
                                    <img src="{{ getFileUrl($photoGallery->photo) }}" alt="{{ $photoGallery->caption }}"
                                        class="w-100 h-100 object-fit-cover" />
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="gallery-button">
                    <div class="swiper-button-next"><i class="fa-solid fa-long-arrow-right"></i></div>
                    <div class="swiper-button-prev"><i class="fa-solid fa-long-arrow-left"></i></div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Gallery -->

    <!-- Start Blog -->
    <section class="pb-110">
        <div class="container">
            <!--  -->
            <div class="row justify-content-center">
                <div class="col-lg-5">
                    <!--  -->
                    <div class="text-center pb-50 header-one">
                        <span
                            class="d-inline-block py-15 px-25 bg-color4 bd-ra-12 fs-18 fw-400 lh-18 text-black-color mb-25">{{ __('Alumni Blogs') }}</span>
                        <h4 class="fs-50 fw-700 lh-60 text-black-color pb-14">{{ __('News & Views from our community.') }}
                        </h4>
                        <p class="fs-18 fw-400 lh-28 text-para-color">
                            {{ __('Explore news, views and perspectives from us and your alumni community.') }}
                        </p>
                    </div>
                </div>
            </div>
            <!--  -->
            <div class="row rg-24 pb-50">
                @foreach ($news as $singleNews)
                    <div class="col-lg-4 col-md-6">
                        <div class="hover-scale-img bd-one bd-c-black-10 bd-ra-25 bg-event-bg hover-scale-img">
                            <div class="bd-ra-14 overflow-hidden h-234 position-relative">
                                <img class="w-100 h-100 object-fit-cover" src="{{ getFileUrl($singleNews->image) }}"
                                    alt="{{ $singleNews->title }}" />
                                <p
                                    class="position-absolute top-22 left-22 p-10 bd-ra-10 bg-primary-color max-w-77 fs-16 fw-400 lh-19 text-black-color text-center">
                                    {{ \Carbon\Carbon::parse($singleNews->created_at)->format('M d, Y') }}</p>
                            </div>
                            <div class="pt-29 pb-34 px-25">
                                <div class="d-flex align-items-center cg-10 pb-10">
                                    <div class="w-30 h-30 rounded-circle overflow-hidden"><img
                                            src="{{ getFileUrl($singleNews->author->image) }}"
                                            alt="{{ $singleNews->author->name }}" /></div>
                                    <p class="fs-16 fw-400 lh-14 text-para-color">BY : {{ $singleNews->author->name }},
                                        {{ $singleNews->category->name }}</p>
                                </div>
                                <h4
                                    class="fs-24 fw-600 lh-34 text-black-color mb-25 line-clamp-2 sf-text-ellipsis min-h-68">
                                    {{ $singleNews->title }}</h4>
                                <a href="{{ route('news.view.details', $singleNews->slug) }}"
                                    class="fs-18 fw-600 lh-28 text-black-color d-inline-flex align-items-center cg-16 hover-color-primary">
                                    {{ __('Read More') }}
                                    <i class="fa-solid fa-long-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="text-center">
                <a href="{{ route('our.news') }}"
                    class="align-items-center bd-c-black-color bd-one bd-ra-12 bg-white cg-16 d-inline-flex fs-18 fw-600 hover-bg-color-primary hover-border-color-primary justify-content-center lh-28 px-32 py-15 text-black-color">
                    {{ __('Explore All Blogs') }}
                    <i class="fa-solid fa-long-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>
    <!-- End Blog -->
@endsection
@push('script')
    <script></script>
@endpush
