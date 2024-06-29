@extends('layouts.app')

@push('title')
    {{ $title }}
@endpush

@section('content')
    <!-- Page content area start -->
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Post Details') }}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <div class="d-flex flex-column rg-22 max-w-890 pb-30">
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ $jobPostData->title ?? '' }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">
                            {{ isset($jobPostData->employee_status) ? $jobPostData->employee_status : '' }}
                        </p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Job Context') }}</h4>
                        {!! $jobPostData->job_context !!}
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Job Responsibility') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">{!! $jobPostData->job_responsibility !!}</p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Educational Requirements') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">{!! $jobPostData->educational_requirements !!}</p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Job Location') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">{{ $jobPostData->location ?? '' }}</p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Salary') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">{{ $jobPostData->salary ?? '' }}</p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Compensation & Benefits') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">{{ $jobPostData->compensation_n_benefits ?? '' }}</p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Application Deadline') }}</h4>
                        <p class="fs-14 fw-400 lh-18 text-707070">
                            {{ isset($jobPostData->application_deadline) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $jobPostData->application_deadline)->format('l, F j, Y') : '' }}
                        </p>
                    </div>
                    <div class="d-flex flex-column rg-6">
                        <h4 class="fs-18 fw-500 lh-22 text-1b1c17">{{ __('Skills') }}</h4>
                        @if(isset($jobPostData->skills))
                            <ul class="fs-14 d-flex fw-400 lh-18 text-707070">
                                @foreach(json_decode($jobPostData->skills) as $skill)
                                    <li class="p-1 px-14 d-flex bg-f1a527 text-002a5c rounded m-1"> {{$skill }}</li>
                                @endforeach
                            </ul>
                        @endif

                    </div>
                    <div class="col-6">
                        <form action="{{ route('alumni.jobs.apply', ['company' => $company, 'slug' => $slug]) }}" method="POST">
                            @csrf
                            <select class="primary-form-control sf-select-without-search" name="cv_id" id="event_category_id">
                                <option selected="" disabled>{{ __('Select CV') }}</option>
                                @foreach ($cvs as $cv)
                                    <option value="{{ $cv->id }}">{{ $cv->name }}</option>
                                @endforeach
                            </select>
                            <button class="bd-c-afd449 d-inline-block fs-15 fw-500 lh-25 mt-20 px-30 py-13 rounded-3 text-f1a527">{{ __('Apply Now') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="{{ asset('alumni/js/job_post.js') }}"></script>
@endpush
