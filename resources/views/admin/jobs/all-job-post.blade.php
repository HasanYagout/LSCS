@extends('layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')


<!-- Page content area start -->
<div class="p-30">
    <div>
        <input type="hidden" id="job-post-update-route" value="{{ route('admin.jobs.update.status',':id') }}">
        <input type="hidden" id="job-post-list-route" value="{{ route('admin.jobs.all-job-post') }}">
        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
        </div>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <!-- Table -->
        <div class="table-responsive zTable-responsive">
            <table class="table zTable" id="jobPostAlldataTable">
              <thead>
                <tr>
                  <th scope="col"><div>{{ __('Company') }}</div></th>
                  <th scope="col"><div>{{ __('Company Name') }}</div></th>
                  <th scope="col"><div>{{ __('Job Title') }}</div></th>
                  <th scope="col"><div>{{ __('Application Deadline') }}</div></th>
                  <th scope="col"><div>{{ __('Posted By') }}</div></th>
                   <th scope="col"><div>{{ __('Status') }}</div></th>
                  <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                </tr>
              </thead>
            </table>
        </div>

      </div>
    </div>
</div>
<!-- Page content area End -->

<!-- Edit Modal section start -->
<div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

        </div>
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
                            <label for="Department" class="form-label">{{__('Posted By')}}</label>

                            <select class="sf-select-without-search primary-form-control" name='department'
                                    id='posted_by'>
                                <option value="" selected>{{__('Choose')}}</option>

                                <option  value='admin'>{{__('Admin')}}</option>
                                <option  value='company'>{{__('Company')}}</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="passing_year" class="form-label">{{__('Status')}}</label>
                            <select class="sf-select-without-search primary-form-control" name='passing_year'
                                    id='status'>
                                <option value="" selected>{{__('Choose')}}</option>

                                <option  value='1'>{{__('Active')}}</option>
                                <option  value='0'>{{__('Inactive')}}</option>

                            </select>
                        </div>
                    </div>
                </div>
                <div class="item">
                    <div class="primary-form-group">

                        <div class="primary-form-group-wrap">
                            <label for="is_member" class="form-label">{{__('Company')}}</label>
                            <select class="sf-select-without-search primary-form-control" name='company'
                                    id='company'>
                                <option value="" selected>{{__('Choose')}}</option>

                                @foreach($companies as $company)
                                    <option value="{{$company->company->name}}">{{$company->company->name}}</option>
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
<!-- Edit Modal section end -->
@endsection

@push('script')
<script src="{{ asset('public/admin/js/job_post.js') }}"></script>
@endpush
