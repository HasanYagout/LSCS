@extends('layouts.app')
@push('title')
    {{ __('Home') }}
@endpush
@push('style')

    <style>
        body .lightbox .lb-close {
            position: absolute;
            top: 0px;
            right: 144px;
            z-index: 1051;
        }

        body .lightbox .lb-prev, body .lightbox .lb-next {
            position: relative;
            top: 52%;
            transform: translateY(-50%);
        }

        body .lightbox .lb-prev {
            opacity: 1;
            left: -100px;
        }

        body .lightbox .lb-next {
            right: -100px;
            opacity: 1;
        }
        .page-link{
        }
        .active>.page-link, .page-link.active{
            background-color: var(--secondary-color);
            border: none;
        }
    </style>
@endpush
@section('content')

    <div class="p-30" >
        <section class="home-section">
            <!-- Posts -->
            <div class="home-content">
                <div class="mb-3">
                    <form class="ajax reset" id="post-form" method="post" enctype="multipart/form-data"
                        action="{{ route('admin.posts.store') }}" data-handler="postResponse">
                        @csrf
                        <!-- Create Post -->
                        <div class="p-25 bg-white bd-one bd-c-black-10 bd-ra-25">
                            <!-- Title -->
                            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-26">{{ __('Create Post') }}</h4>
                            <!-- User -->

                            <div class="d-flex align-items-center cg-10 pb-20">
                                <div class="flex-shrink-0 w-50 h-50 bd-one bd-c-primary-color rounded-circle overflow-hidden">
                                    <img
                                        class="h-100 object-fit-cover"
                                        src="{{ asset('public/storage/admin'.'/'.'image'.'/'.auth('admin')->user()->image) }}"
                                        onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                        alt="{{auth('admin')->user()->name}}"/>
                                </div>
                                <h4 class="fs-16 fw-500 lh-20 text-1b1c17">{{auth('admin')->user()->name}}</h4>
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
                                                    onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                                    src="{{ asset('public/assets/images/icon/post-photo.svg') }}"
                                                    alt="" /></label>
                                            <input type="file" name="file[]"
                                                accept=".png,.jpg,.svg,.jpeg,.gif,.mp4,.mov,.avi,.mkv,.webm,.flv"
                                                id="mAttachment1" class="d-none" multiple />
                                            <label for="mAttachment1"><img
                                                    onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                                    src="{{ asset('public/assets/images/icon/post-video.svg') }}"
                                                    alt="" /></label>
                                        </div>
                                    </div>
                                    <!-- Post button -->
                                    <button type="submit"
                                        class="border-0 py-10 px-26 bd-ra-12 bg-secondary-color">{{ __('Post Now') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <div id="post-block" class="mt-15 d-flex flex-column rg-15">
                    @include('admin.partials.post',$posts)
                </div>

                <div class="py-13">
                    {{$posts->links()}}
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
                                <a href="{{ route('admin.event.all') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
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
                                                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/admin/events').'/'.$event->thumbnail }}"
                                                    alt="{{ $event->title }}">
                                                <ul class="tag d-flex flex-wrap cg-2 rg-5">

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

                                                <!-- Link -->
                                                <a href="{{ route('admin.event.details', $event->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('Reservation') }}</a>
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
                                <a href="{{ route('admin.jobs.all-job-post') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
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
                                                class="flex-shrink-0 w-45 overflow-hidden h-45 bd-one bd-c-ededed rounded-circle d-flex justify-content-center align-items-center">
                                                <img class="h-100 object-fit-cover" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ $job->posted_by=='company' ? asset('public/storage/company').'/'.'image'.'/'.$job->company->image :asset('public/storage/admin').'/'.'image'.'/'.$job->admin->image }}"
                                                    alt="{{ $job->title }}" />
                                            </div>
                                            <div class="">
                                                <h4 class="fs-16 fw-500 lh-18 text-1b1c17 pb-4">{{ $job->title }}</h4>
                                                <div class="d-flex align-items-center cg-5">
                                                    <div class="d-flex"><img
                                                            src="{{ asset('public/assets/images/icon/calendar-icon.svg') }}"
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
                                                        src="{{ asset('public/assets/images/icon/suitcase.svg') }}"
                                                        alt="" /></div>
                                                <p class="fs-14 fw-400 lh-16 text-707070">
                                                    {{ $job->employee_status}}</p>
                                            </li>
                                            <li class="d-flex align-items-center cg-7">
                                                <div class="d-flex"><img
                                                        src="{{ asset('public/assets/images/icon/location.svg') }}"
                                                        alt="" /></div>
                                                <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->location }}</p>
                                            </li>

                                        </ul>
                                        <!-- Link -->
                                        <a href="{{ route('admin.jobs.details', $job->slug) }}"
                                            class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                                <a href="{{ route('admin.all.notice') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($latestNotice as $notice)
                                    <li>
                                        <div class="home-item-one">
                                            <div class="img"><img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/notice'.'/'.$notice->image) }}"
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
                                                <a href="{{ route('admin.notice.details', $notice->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                                <a href="{{ route('admin.all.news') }}"
                                    class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
                                    <span>{{ __('See All') }}</span>
                                    <span><i class="fa-solid fa-arrow-right"></i></span>
                                </a>
                            </div>
                            <!-- Content -->
                            <ul class="zList-five">
                                @foreach ($latestNews as $news)
                                    <li>
                                        <div class="home-item-one">
                                            <div class="img"><img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/news'.'/'.$news->image) }}"
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
                                                        class="align-items-center bd-c-1b1c17 bd-one d-flex flex-shrink-0 h-45 justify-content-center overflow-hidden rounded-circle w-45">
                                                        <img class="h-100 object-fit-cover" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/admin/image'.'/'.$news->author->image)}}"
                                                            alt="{{ $news->author->first_name .$news->author->last_name }}" />
                                                    </div>
                                                    <p class="fs-10 fw-400 lh-12 text-707070">{{ $news->author->first_name .$news->author->last_name }}
                                                    </p>
                                                </div>
                                                <!-- Link -->
                                                <a href="{{ route('admin.news.details', $news->slug) }}"
                                                    class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                            <a href="{{ route('admin.event.all') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
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
                                            <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/events'.'/'.$event->thumbnail) }}"
                                                alt="{{ $event->title }}">
                                            <ul class="tag d-flex flex-wrap cg-2 rg-5">
{{--                                                <li><a--}}
{{--                                                        class="fs-12 fw-500 lh-16 text-1b1c17 px-6 bg-white rounded-pill d-flex">{{ eventType($event->type) }}</a>--}}
{{--                                                </li>--}}
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
                                                        src="{{ asset('public/assets/images/icon/location.svg') }}"
                                                        alt="" /></div>
{{--                                                <p class="fs-14 fw-400 lh-17 text-707070">{{ $event->location }}</p>--}}
                                            </div>
                                            <!-- Link -->
                                            <a href="{{ route('admin.event.details', $event->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('Reservation') }}</a>
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
                            <a href="{{ route('admin.jobs.all-job-post') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
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
                                            <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/company').'/'.$job->company->image }}"
                                                alt="{{ $job->title }}" />
                                        </div>
                                        <div class="">
                                            <h4 class="fs-16 fw-500 lh-18 text-1b1c17 pb-4">{{ $job->title }}</h4>
                                            <div class="d-flex align-items-center cg-5">
                                                <div class="d-flex"><img
                                                        src="{{ asset('public/assets/images/icon/calendar-icon.svg') }}"
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
                                            <div class="d-flex"><img src="{{ asset('public/assets/images/icon/suitcase.svg') }}"
                                                    alt="" />
                                            </div>
                                            <p class="fs-14 fw-400 lh-16 text-707070">
                                                {{$job->employee_status}}</p>
                                        </li>
                                        <li class="d-flex align-items-center cg-7">
                                            <div class="d-flex"><img src="{{ asset('public/assets/images/icon/location.svg') }}"
                                                    alt="" />
                                            </div>
                                            <p class="fs-14 fw-400 lh-16 text-707070">{{ $job->location }}</p>
                                        </li>

                                    </ul>
                                    <!-- Link -->
                                    <a href="{{ route('admin.jobs.details', $job->slug) }}"
                                        class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                            <a href="{{ route('admin.all.notice') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($latestNotice as $notice)
                                <li>
                                    <div class="home-item-one">
                                        <div class="img"><img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/notice'.'/'.$notice->image) }}"
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
                                            <a href="{{ route('admin.notice.details', $notice->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                            <a href="{{ route('admin.all.news') }}"
                                class="flex-shrink-0 fs-14 fw-500 lh-17 text-1b1c17 d-flex align-items-center cg-6 hover-color-secondary">
                                <span>{{ __('See All') }}</span>
                                <span><i class="fa-solid fa-arrow-right"></i></span>
                            </a>
                        </div>
                        <!-- Content -->
                        <ul class="zList-five">
                            @foreach ($latestNews as $news)
                                <li>
                                    <div class="home-item-one">
                                        <div class="img"><img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/news'.'/'.$news->image) }}"
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
                                                    <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/news'.'/'.$news->author->image) }}"
                                                        alt="{{ $news->author->first_name .$news->author->last_name }}" />
                                                </div>
                                                <p class="fs-10 fw-400 lh-12 text-707070">{{ $news->author->first_name .'f' . $news->author->last_name }}</p>
                                            </div>
                                            <!-- Link -->
                                            <a href="{{ route('admin.news.details', $news->slug) }}"
                                                class="fs-14 fw-500 lh-17 text-1b1c17 text-decoration-underline hover-color-secondary">{{ __('More Details') }}</a>
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
                <form action="{{ route('admin.posts.update') }}" id="post-edit-form" class="ajax reset" method="POST"
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

{{--    <input type="hidden" id="more-post-route" value="{{ route('admin.posts.more-post-load') }}">--}}
    <input type="hidden" id="delete-post-route" value="{{ route('admin.posts.delete') }}">
{{--    <input type="hidden" id="post-like-route" value="{{ route('admin.posts.like') }}">--}}
    <input type="hidden" id="post-edit" value="{{ route('alumni.posts.edit') }}">
    <input type="hidden" id="post-update" value="{{ route('alumni.posts.update') }}">
{{--    <input type="hidden" id="post-comment-store" value="{{ route('alumni.posts.comments.store') }}">--}}
    <input type="hidden" id="load-single-post" value="{{ route('alumni.posts.single') }}">
    <input type="hidden" id="load-post-body" value="{{ route('alumni.posts.single.body') }}">
{{--    <input type="hidden" id="load-likes" value="{{ route('alumni.posts.single.likes') }}">--}}
{{--    <input type="hidden" id="load-comments" value="{{ route('alumni.posts.single.comments') }}">--}}
{{--    <input type="hidden" id="post-comment-delete" value="{{ route('alumni.posts.comments.delete') }}">--}}
{{--    <input type="hidden" id="post-comment-update" value="{{ route('alumni.posts.comments.update') }}">--}}
    @if (!empty(getOption('cookie_status')) && getOption('cookie_status') == STATUS_ACTIVE)
        <div class="cookie-consent-wrap shadow-lg">
            @include('cookie-consent::index')
        </div>
    @endif
@endsection

@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lightbox.option({
                'resizeDuration': 200,
                'wrapAround': true,
                'fitImagesInViewport':true,
                'showImageNumberLabel':true
            });
        });
    </script>
{{--    <script src="{{ asset('public/alumni/js/posts.js') }}?ver={{ env('VERSION' ,0) }}"></script>--}}
@endpush
