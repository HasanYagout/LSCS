@extends('frontend.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')

<section class="breadcrumb-wrap py-50 py-md-75 py-lg-100" data-background="{{getSettingImage('page_breadcrumb')}}">
    <div class="text-center position-relative">
      <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{$title}}</h4>
      <ul class="breadcrumb-list">
        <li><a href="{{route('index')}}">{{__('Home')}}</a></li>
        <li><a href="{{route('all.job')}}">{{$title}}</a></li>
      </ul>
    </div>
</section>


<section class="pb-110 pt-60">
    <div class="container">
      <!-- Items -->
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <div class="pb-45">
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{ $jobPostData->title ?? '' }}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{ isset($jobPostData->employee_status) ? getEmployeeStatus($jobPostData->employee_status) : '' }}</p>
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Job Context')}}</h4>
              {!! $jobPostData->job_context !!}
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Job Responsibility')}}</h4>
              {!! ($jobPostData->job_responsibility) !!}
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Employee Status')}}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{getEmployeeStatus($jobPostData->employee_status)}}</p>
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Educational Requirements')}}</h4>
              {!! $jobPostData->educational_requirements !!}
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Job Location')}}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{ $jobPostData->location ?? '' }}</p>
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Salary')}}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{ $jobPostData->salary ?? '' }}</p>
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Compensation &amp Benefits')}}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{ $jobPostData->compensation_n_benefits ?? '' }}</p>
            </div>
            <div class="pb-28">
              <h4 class="fs-24 fw-500 lh-29 text-black-color pb-8">{{__('Application Deadline')}}</h4>
              <p class="fs-18 fw-400 lh-23 text-para-color">{{ isset($jobPostData->application_deadline) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $jobPostData->application_deadline)->format('l, F j, Y') : '' }}</p>
            </div>
          </div>
          <a href="{{ $jobPostData->post_link ?? '' }}" target="_blank" class="border-0 bd-ra-12 py-16 px-30 bg-primary-color fs-18 fw-500 lh-25 text-black-color">{{ __('Apply Now') }}</a>
        </div>
      </div>
    </div>
  </section>

@endsection

