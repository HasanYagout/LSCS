@extends('layouts.app')

@push('title')
    {{ $title }}
@endpush

@section('content')
    <!-- Page content area start -->
    <div class="p-30" >
        <div class="">
{{--        {{dd(get_defined_vars())}}--}}
            <input type="hidden" id="job-post-list-route" value="{{ route('company.jobs.applied',['id'=>$jobPostData->id]) }}">
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
                                   <li class="p-1 d-flex bg-secondary-color text-primary-color rounded m-1"> {{$skill }}</li>
                            @endforeach
                                </ul>
                        @endif

                    </div>

                </div>
                <div id="search-section">
                    <div class="collapse" id="collapseExample">
                        <div class="alumniFilter">
                            <h4 class="fs-18 fw-500 lh-38 text-1b1c17 pb-10">{{__('Filter your search')}}</h4>
                            <div class="filterOptions">
                                <div class="item">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="Department" class="form-label">{{__('Department')}}</label>

                                            <select class="sf-select-without-search primary-form-control" name='department'
                                                    id='department'>
                                                <option selected="" value=0>{{__('All Majors')}}</option>
                                                @foreach ($majors as $major)
                                                    <option value="{{ $major->name}}">{{ $major->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="passing_year" class="form-label">{{__('Passing Year')}}</label>
                                            <select class="sf-select-without-search primary-form-control" name='passing_year'
                                                    id='passing-year'>
                                                <option selected="" value=0>{{__('All Year')}}</option>
                                                @foreach ($years as $year)
                                                    <option value="{{ $year }}">{{ $year}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="primary-form-group">
                                        <div class="primary-form-group-wrap">
                                            <label for="is_member" class="form-label">{{__('GPA')}}</label>
                                            <select class="sf-select-without-search primary-form-control" name='gpa'
                                                    id='GPA'>
                                                <option value="-1" selected>{{__('All')}}</option>
                                                @foreach ($gpas as $gpa)
                                                    <option value="{{ $gpa }}">{{ $gpa }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>



{{--                                <div class="item">--}}
{{--                                    <div class="primary-form-group">--}}
{{--                                        <div class="primary-form-group-wrap">--}}
{{--                                            <label for="is_member" class="form-label">{{__('Course')}}</label>--}}
{{--                                            <select class="sf-select-without-search primary-form-control" name='is_member'--}}
{{--                                                    id='is-member'>--}}
{{--                                                <option value="-1" selected>{{__('All')}}</option>--}}

{{--                                                <option value="90">90+</option>--}}
{{--                                                <option value="80">80</option>--}}
{{--                                                <option value="70">70</option>--}}
{{--                                                <option value="60">60</option>--}}

{{--                                            </select>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <button
                                    class="bg-cdef84 border-0 bd-ra-12 py-13 px-26 fs-15 fw-500 lh-25 text-black hover-bg-one advance-filter">{{__('Search Now')}}</button>
                                <!-- <div class="item">
                                                          </div> -->
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table zTable" id="appliedJobsTable">
                    <thead>
                    <tr>
                        <th scope="col"><div>{{ __('Name') }}</div></th>
                        <th scope="col"><div>{{ __('GPA') }}</div></th>
                        <th scope="col"><div>{{ __('Major') }}</div></th>
                        <th scope="col"><div>{{ __('Graduation Year') }}</div></th>
                        <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                    </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')

    <script src="{{ asset('public/company/js/applied_jobs.js') }}"></script>
@endpush
