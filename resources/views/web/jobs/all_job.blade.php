@extends('web.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{ $title }}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{ route('index') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('all.job') }}">{{ $title }}</a></li>
            </ul>
        </div>
    </section>


    <section class="pb-110 pt-60">
        <div class="container">
            <!-- Items -->
            <div class="">
                <div class="row rg-24">
                    @forelse ($allJob as $job)
                        <div class="col-lg-4 col-md-6">
                            <div class="bd-one bd-c-black-10 bd-ra-25 bg-white py-28 px-25">
                                <!--  -->
                                <div class="d-flex align-items-center flex-wrap flex-sm-nowrap rg-10 cg-11 pb-17">
                                    <div
                                        class="flex-shrink-0 w-51 h-51 bd-one bd-c-stroke-color rounded-circle d-flex justify-content-center align-items-center">
                                        <img src="{{ asset('public/storage/company').'/'.$job->company_logo }}" alt="">
                                    </div>
                                    <div class="">
                                        <h4 class="fs-20 fw-500 lh-18 text-black-color mb-8 line-clamp-1 sf-text-ellipsis">
                                            {{ $job->title }}</h4>
                                        <div class="d-flex align-items-center cg-7">
                                            <div class="d-flex"><img
                                                    src="{{ asset('public/frontend/images/icon/calendar-1.svg') }}" alt="">
                                            </div>
                                            <p class="fs-18 fw-400 lh-22 text-para-color">
                                                {{ isset($job->application_deadline) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $job->application_deadline)->format('l, F j, Y') : '' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="pb-23">
                                    <div
                                        class="fs-18 fw-400 lh-28 text-para-color mb-21 line-clamp-3 sf-text-ellipsis min-h-84">
                                        {{ getSubText($job->job_context, 300) }}
                                    </div>
                                </div>
                                <!--  -->
                                <div class="d-flex align-items-center flex-wrap cg-8 rg-21 pb-30">
                                    <div class="d-flex align-items-center cg-7">
                                        <div class="d-flex"><img
                                                src="{{ asset('/frontend/images/icon/bag-suitcase.svg') }}" alt="">
                                        </div>
                                        <p class="fs-18 fw-400 lh-16 text-para-color">
                                            {{ $job->employee_status}}, </p>
                                    </div>
                                    <div class="d-flex align-items-center cg-7">
                                        <div class="d-flex"><img src="{{ asset('public/frontend/images/icon/location-1.svg') }}"
                                                alt=""></div>
                                        <p class="fs-18 fw-400 lh-16 text-para-color">{{ $job->location ?? '' }}</p>
                                    </div>
                                    <div class="d-flex align-items-center cg-7">
                                        <div class="d-flex"><img src="{{ asset('/frontend/images/icon/dollar-coin.svg') }}"
                                                alt=""></div>
                                        <p class="fs-18 fw-400 lh-16 text-para-color">{{ $job->salary ?? '' }}</p>
                                    </div>
                                </div>
                                <!--  -->
                                <a href="{{ route('job.view.details', $job->slug) }}"
                                    class="fs-18 fw-500 lh-22 text-black-color text-decoration-underline hover-color-primary">{{ __('More Details') }}</a>
                            </div>
                        </div>
                    @empty
                        <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{ __('No Job Found') }}</p>
                    @endforelse

                </div>
            </div>
            {{ $allJob->links() }}
        </div>
    </section>
@endsection
