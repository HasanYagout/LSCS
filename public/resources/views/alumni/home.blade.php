@extends('layouts.app')
@push('title')
    {{ __('Home') }}
@endpush
@push('style')
{!! RecaptchaV3::initJs() !!}
@endpush
@section('content')
    <div class="p-30">
        <section class="home-section">
            <!-- Posts -->
            <div class="home-content">
                <div class="mb-3">
                    <form class="ajax reset" id="post-form" method="post" enctype="multipart/form-data"
                        action="{{ route('posts.store') }}" data-handler="postResponse">
                        @csrf
                        <!-- Create Post -->
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-26">{{ __('Create Post') }}</h4>
                            <!-- User -->
                            <div class="d-flex align-items-center cg-10 pb-20">
                                <div class="flex-shrink-0 w-50 h-50 bd-one bd-c-cdef84 rounded-circle overflow-hidden"><img
                                        src="{{ asset(getFileUrl($user->image)) }}" class="w-100"
                                        alt="{{ $user->name }}" />
                                </div>
                                <h4 class="fs-16 fw-500 lh-20 text-1b1c17">{{ $user->name }}</h4>
                            </div>
                            <!-- Post Input -->
                            <div class="pb-15">
                                <textarea name="body" class="form-control postInput" placeholder="{{ __('What’s on your mind?') }}"></textarea>
                            </div>
                            <div class="">
                                <!-- Attachment preview -->
                                <div id="files-area" class="pb-10">
                                    <span id="filesList">
                                        <span id="files-names"></span>
                                    </span>
                                </div>
                                <!-- Add image/video - post button -->
                                <div class="d-flex justify-content-between align-items-center flex-wrap g-10">
                                    <!-- Add image/video -->
                                    <div class="d-flex align-items-center cg-15">
                                        <p class="fs-16 lh-18 fw-500 text-707070">{{ __('Add to your post') }}:</p>
                                        <div class="align-items-center cg-10 d-flex flex-shrink-0">
                                            <label for="mAttachment1"><img
                                                    src="{{ asset('assets/images/icon/post-photo.svg') }}"
                                                    alt="" /></label>
                                            <input type="file" name="file[]"
                                                accept=".png,.jpg,.svg,.jpeg,.gif,.mp4,.mov,.avi,.mkv,.webm,.flv"
                                                id="mAttachment1" class="d-none" multiple />
                                            <label for="mAttachment1"><img
                                                    src="{{ asset('assets/images/icon/post-video.svg') }}"
                                                    alt="" /></label>
                                        </div>
                                    </div>
                                    <!-- Post button -->
                                    <button type="submit"
                                        class="border-0 py-10 px-26 bd-ra-12 bg-cdef84 hover-bg-one">{{ __('Post Now') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div id="post-block" class="mt-15 d-flex flex-column rg-15">

                </div>
            </div>
            <!-- Right side content -->
            <div class="home-rightSide">
                <div class="d-flex flex-column rg-30">
                    <!-- Upcoming Events -->
                    @if (count($upcomingEvents))
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <div class="d-flex justify-content-between align-items-center pb-30">
                                <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Upcoming Events') }}</h4>
                                <a href="{{ route('event.all') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($upcomingEvents as $event)
                                    <li>
                                        <div class="home-item-one">
                                            <div class="img">
                                                <img src="{{ asset(getFileUrl($event->thumbnail)) }}"
                                                    alt="{{ $event->title }}">
                                                <ul class="tag d-flex flex-wrap cg-2 rg-5">
                                                    <li><a
                                                            class="fs-12 fw-500 lh-16 text-1b1c17 px-6 bg-white rounded-pill d-flex">{{ eventType($event->type) }}</a>
                                                    </li>
                                                    <li><a
                                                            class="fs-12 fw-500 lh-16 text-1b1c17 px-6 bg-white rounded-pill d-flex">{{ $event->category->name }}</a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="content">
                                                <!-- Tab - Date -->
                                                <div class="d-flex align-items-center flex-wrap cg-10">
                                                    <p class="fs-14 fw-400 lh-17 text-707070">
                                                        {{ date('F j, g:i A', strtotime($event->date)) }}
                                                    </p>
                                                </div>
                                                <!-- Title -->
                                                <h4 class="title">{{ $event->title }}</h4>
                                                <!-- Location -->
                                                <div class="d-flex align-items-center cg-5">
                                                    <div class="d-flex max-w-10"><img
                                                            src="{{ asset('assets/images/icon/location.svg') }}"
                                                            alt="" /></div>
                                                    <p class="fs-14 fw-400 lh-17 text-707070">{{ $event->location }}</p>
                                                </div>
                                                <!-- Link -->
                                                <a href="{{ route('event.details', $event->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('Reservation') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Jobs -->
                    @if (count($latestJobs))
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <div class="d-flex justify-content-between align-items-center pb-30">
                                <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Jobs') }}</h4>
                                <a href="{{ route('jobPost.all-job-post') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($latestJobs as $job)
                                    <li>
                                        <!-- Logo - User -->
                                        <div class="d-flex align-items-center cg-10 pb-10">
                                            <div
                                                class="flex-shrink-0 w-45 h-45 bd-one bd-c-ededed rounded-circle d-flex justify-content-center align-items-center">
                                                <img src="{{ asset(getFileUrl($job->company_logo)) }}"
                                                    alt="{{ $job->title }}" />
                                            </div>
                                            <div class="">
                                                <h4 class="fs-16 fw-500 lh-18 text-1b1c17 pb-4">{{ $job->title }}</h4>
                                                <div class="d-flex align-items-center cg-5">
                                                    <div class="d-flex"><img
                                                            src="{{ asset('assets/images/icon/calendar-icon.svg') }}"
                                                            alt="">
                                                    </div>
                                                    <p class="fs-12 fw-400 lh-15 text-707070">
                                                        {{ date('l, F j, Y', strtotime($job->application_deadline)) }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Short description -->
                                        <p class="fs-14 fw-400 lh-24 text-707070 pb-10">
                                            {{ getSubText($job->job_context, 150) }}
                                        </p>
                                        <!-- Job nature -->
                                        <ul
                                            class="d-flex justify-content-between align-items-center flex-wrap cg-20 rg-10 pb-20">
                                            <li class="d-flex align-items-center cg-7">
                                                <div class="d-flex"><img
                                                        src="{{ asset('assets/images/icon/suitcase.svg') }}"
                                                        alt="" /></div>
                                                <p class="fs-14 fw-400 lh-16 text-707070">
                                                    {{ getEmployeeStatus($job->employee_status) }}</p>
                                            </li>
                                            <li class="d-flex align-items-center cg-7">
                                                <div class="d-flex"><img
                                                        src="{{ asset('assets/images/icon/location.svg') }}"
                                                        alt="" /></div>
                                                <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->location }}</p>
                                            </li>
                                            <li class="d-flex align-items-center cg-7">
                                                <div class="d-flex"><img
                                                        src="{{ asset('assets/images/icon/dollar-coin.svg') }}"
                                                        alt="" />
                                                </div>
                                                <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->salary }}</p>
                                            </li>
                                        </ul>
                                        <!-- Link -->
                                        <a href="{{ route('jobPost.details', $job->slug) }}"
                                            class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Notice -->
                    @if (count($latestNotice))
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <div class="d-flex justify-content-between align-items-center pb-30">
                                <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Notice') }}</h4>
                                <a href="{{ route('all.notice') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($latestNotice as $notice)
                                    <li>
                                        <div class="home-item-one">
                                            <div class="img"><img src="{{ asset(getFileUrl($notice->image)) }}"
                                                    alt="{{ $notice->title }}" />
                                            </div>
                                            <div class="content">
                                                <!-- Tab - Date -->
                                                <div class="d-flex align-items-center flex-wrap cg-10">
                                                    <p class="fs-14 fw-400 lh-17 text-707070">
                                                        {{ date('M d, Y', strtotime($notice->created_at)) }}
                                                    </p>
                                                </div>
                                                <!-- Title -->
                                                <h4 class="title">{{ $notice->title }}</h4>
                                                <!-- Info -->
                                                <p class="fs-14 fw-400 lh-17 text-707070">
                                                    {{ getSubText($notice->details, 150) }}</p>
                                                <!-- Link -->
                                                <a href="{{ route('notice.details', $notice->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Latest News -->
                    @if (count($latestNews))
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <div class="d-flex justify-content-between align-items-center pb-30">
                                <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Latest News') }}</h4>
                                <a href="{{ route('all.news') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($latestNews as $news)
                                    <li>
                                        <div class="home-item-one">
                                            <div class="img"><img src="{{ asset(getFileUrl($news->image)) }}"
                                                    alt="{{ $news->title }}" />
                                            </div>
                                            <div class="content">
                                                <!-- Tab - Date -->
                                                <div class="d-flex align-items-center flex-wrap cg-10">
                                                    <a
                                                        class="d-inline-block py-3 px-10 bg-f0f0f0 rounded-pill fs-12 fw-400 lh-16 text-1b1c17">{{ $news->category->name }}</a>
                                                    <p class="fs-14 fw-400 lh-17 text-707070">
                                                        {{ date('M d, Y', strtotime($news->created_at)) }}
                                                    </p>
                                                </div>
                                                <!-- Title -->
                                                <h4 class="title">{{ $news->title }}</h4>
                                                <!-- User -->
                                                <div class="d-flex align-items-center cg-5">
                                                    <div
                                                        class="flex-shrink-0 w-18 h-18 bd-one bd-c-1b1c17 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center">
                                                        <img src="{{ asset(getFileUrl($news->author->image)) }}"
                                                            alt="{{ $news->author->name }}" />
                                                    </div>
                                                    <p class="fs-10 fw-400 lh-12 text-707070">{{ $news->author->name }}
                                                    </p>
                                                </div>
                                                <!-- Link -->
                                                <a href="{{ route('news.details', $news->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    </div>

    <!-- Home right side Mobile offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="homeRightSideView" aria-labelledby="homeRightSideViewLabel">
        <div class="offcanvas-body">
            <div class="d-flex flex-column rg-30">
                <!-- Upcoming Events -->
                @if (count($upcomingEvents))
                    <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                        <!-- Title -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Upcoming Events') }}</h4>
                            <a href="{{ route('event.all') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($upcomingEvents as $event)
                                <li>
                                    <div class="home-item-one">
                                        <div class="img">
                                            <img src="{{ asset(getFileUrl($event->thumbnail)) }}"
                                                alt="{{ $event->title }}">
                                            <ul class="tag d-flex flex-wrap cg-2 rg-5">
                                                <li><a
                                                        class="fs-12 fw-500 lh-16 text-1b1c17 px-6 bg-white rounded-pill d-flex">{{ eventType($event->type) }}</a>
                                                </li>
                                                <li><a
                                                        class="fs-12 fw-500 lh-16 text-1b1c17 px-6 bg-white rounded-pill d-flex">{{ $event->category->name }}</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="content">
                                            <!-- Tab - Date -->
                                            <div class="d-flex align-items-center flex-wrap cg-10">
                                                <p class="fs-14 fw-400 lh-17 text-707070">
                                                    {{ date('F j, g:i A', strtotime($event->date)) }}
                                                </p>
                                            </div>
                                            <!-- Title -->
                                            <h4 class="title">{{ $event->title }}</h4>
                                            <!-- Location -->
                                            <div class="d-flex align-items-center cg-5">
                                                <div class="d-flex max-w-10"><img
                                                        src="{{ asset('assets/images/icon/location.svg') }}"
                                                        alt="" /></div>
                                                <p class="fs-14 fw-400 lh-17 text-707070">{{ $event->location }}</p>
                                            </div>
                                            <!-- Link -->
                                            <a href="{{ route('event.details', $event->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('Reservation') }}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Jobs -->
                @if (count($latestJobs))
                    <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                        <!-- Title -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Jobs') }}</h4>
                            <a href="{{ route('jobPost.all-job-post') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($latestJobs as $job)
                                <li>
                                    <!-- Logo - User -->
                                    <div class="d-flex align-items-center cg-10 pb-10">
                                        <div
                                            class="flex-shrink-0 w-45 h-45 bd-one bd-c-ededed rounded-circle d-flex justify-content-center align-items-center">
                                            <img src="{{ asset(getFileUrl($job->company_logo)) }}"
                                                alt="{{ $job->title }}" />
                                        </div>
                                        <div class="">
                                            <h4 class="fs-16 fw-500 lh-18 text-1b1c17 pb-4">{{ $job->title }}</h4>
                                            <div class="d-flex align-items-center cg-5">
                                                <div class="d-flex"><img
                                                        src="{{ asset('assets/images/icon/calendar-icon.svg') }}"
                                                        alt="">
                                                </div>
                                                <p class="fs-12 fw-400 lh-15 text-707070">
                                                    {{ date('l, F j, Y', strtotime($job->application_deadline)) }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Short description -->
                                    <p class="fs-14 fw-400 lh-24 text-707070 pb-10">
                                        {{ getSubText($job->job_context, 150) }}
                                    </p>
                                    <!-- Job nature -->
                                    <ul
                                        class="d-flex justify-content-between align-items-center flex-wrap cg-20 rg-10 pb-20">
                                        <li class="d-flex align-items-center cg-7">
                                            <div class="d-flex"><img src="{{ asset('assets/images/icon/suitcase.svg') }}"
                                                    alt="" />
                                            </div>
                                            <p class="fs-14 fw-400 lh-16 text-707070">
                                                {{ getEmployeeStatus($job->employee_status) }}</p>
                                        </li>
                                        <li class="d-flex align-items-center cg-7">
                                            <div class="d-flex"><img src="{{ asset('assets/images/icon/location.svg') }}"
                                                    alt="" />
                                            </div>
                                            <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->location }}</p>
                                        </li>
                                        <li class="d-flex align-items-center cg-7">
                                            <div class="d-flex"><img
                                                    src="{{ asset('assets/images/icon/dollar-coin.svg') }}"
                                                    alt="" /></div>
                                            <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->salary }}</p>
                                        </li>
                                    </ul>
                                    <!-- Link -->
                                    <a href="{{ route('jobPost.details', $job->slug) }}"
                                        class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Notice -->
                @if (count($latestNotice))
                    <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                        <!-- Title -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Notice') }}</h4>
                            <a href="{{ route('all.notice') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($latestNotice as $notice)
                                <li>
                                    <div class="home-item-one">
                                        <div class="img"><img src="{{ asset(getFileUrl($notice->image)) }}"
                                                alt="{{ $notice->title }}" /></div>
                                        <div class="content">
                                            <!-- Tab - Date -->
                                            <div class="d-flex align-items-center flex-wrap cg-10">
                                                <p class="fs-14 fw-400 lh-17 text-707070">
                                                    {{ date('M d, Y', strtotime($notice->created_at)) }}
                                                </p>
                                            </div>
                                            <!-- Title -->
                                            <h4 class="title">{{ $notice->title }}</h4>
                                            <!-- Info -->
                                            <p class="fs-14 fw-400 lh-17 text-707070">
                                                {{ getSubText($notice->details, 150) }}</p>
                                            <!-- Link -->
                                            <a href="{{ route('notice.details', $notice->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Latest News -->
                @if (count($latestNews))
                    <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                        <!-- Title -->
                        <div class="d-flex justify-content-between align-items-center pb-30">
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17">{{ __('Latest News') }}</h4>
                            <a href="{{ route('all.news') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-one">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($latestNews as $news)
                                <li>
                                    <div class="home-item-one">
                                        <div class="img"><img src="{{ asset(getFileUrl($news->image)) }}"
                                                alt="{{ $news->title }}" />
                                        </div>
                                        <div class="content">
                                            <!-- Tab - Date -->
                                            <div class="d-flex align-items-center flex-wrap cg-10">
                                                <a
                                                    class="d-inline-block py-3 px-10 bg-f0f0f0 rounded-pill fs-12 fw-400 lh-16 text-1b1c17">{{ $news->category->name }}</a>
                                                <p class="fs-14 fw-400 lh-17 text-707070">
                                                    {{ date('M d, Y', strtotime($news->created_at)) }}
                                                </p>
                                            </div>
                                            <!-- Title -->
                                            <h4 class="title">{{ $news->title }}</h4>
                                            <!-- User -->
                                            <div class="d-flex align-items-center cg-5">
                                                <div
                                                    class="flex-shrink-0 w-18 h-18 bd-one bd-c-1b1c17 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center">
                                                    <img src="{{ asset(getFileUrl($news->author->image)) }}"
                                                        alt="{{ $news->author->name }}" />
                                                </div>
                                                <p class="fs-10 fw-400 lh-12 text-707070">{{ $news->author->name }}</p>
                                            </div>
                                            <!-- Link -->
                                            <a href="{{ route('news.details', $news->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-one">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Edit post modal -->
    <div class="modal fade zModalTwo" id="postEditModal" tabindex="-1" aria-labelledby="postEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">
                <form action="{{ route('posts.update') }}" id="post-edit-form" class="ajax reset" method="POST"
                    data-handler="postUpdateResponse">
                    @csrf
                    @method('PUT')
                    <div class="modal-body zModalTwo-body" id="post-edit-modal-content">

                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit post comment modal -->
    <div class="modal fade zModalTwo" id="commentEditModal" tabindex="-1" aria-labelledby="commentEditModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content zModalTwo-content">
                <!-- Header -->
                <div class="align-items-center d-flex justify-content-between ps-4 pt-17">
                    <h4 class="fs-18 fw-500 lh-20 text-1b1c17">{{ __('Update Comment') }}</h4>
                </div>
                <form action="{{ route('posts.comments.update') }}" data-handler="postCommentUpdateResponse"
                    method="POST" class="ajax reset">
                    @method('put')
                    @csrf
                    <div class="modal-body zModalTwo-body" id="comment-edit-modal-content">
                        <!-- Body -->
                        <div class="pb-18 bd-c-black-10">
                            <input type="hidden" name="id">
                            <textarea class="form-control postInput" name="body" placeholder="{{ __('What’s your comment?') }}"></textarea>
                        </div>
                        <!-- Footer -->
                        <div class="">
                            <div class="pt-18">
                                <button type="submit"
                                    class="border-0 py-10 px-26 bd-ra-12 bg-cdef84 hover-bg-one w-100 d-flex justify-content-center align-items-center">{{ __('Update') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <input type="hidden" id="more-post-route" value="{{ route('more-post-load') }}">
    <input type="hidden" id="delete-post-route" value="{{ route('posts.delete') }}">
    <input type="hidden" id="post-like-route" value="{{ route('posts.like') }}">
    <input type="hidden" id="post-edit" value="{{ route('posts.edit') }}">
    <input type="hidden" id="post-update" value="{{ route('posts.update') }}">
    <input type="hidden" id="post-comment-store" value="{{ route('posts.comments.store') }}">
    <input type="hidden" id="load-single-post" value="{{ route('posts.single') }}">
    <input type="hidden" id="load-post-body" value="{{ route('posts.single.body') }}">
    <input type="hidden" id="load-likes" value="{{ route('posts.single.likes') }}">
    <input type="hidden" id="load-comments" value="{{ route('posts.single.comments') }}">
    <input type="hidden" id="post-comment-delete" value="{{ route('posts.comments.delete') }}">
    <input type="hidden" id="post-comment-update" value="{{ route('posts.comments.update') }}">
    @if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
        <div class="cookie-consent-wrap shadow-lg">
            @include('cookie-consent::index')
        </div>
    @endif
@endsection

@push('script')
    <script src="{{ asset('alumni/js/posts.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
