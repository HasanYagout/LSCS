@extends('layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')


<!-- Page content area start -->
<div class="p-30">
    <div>
        <input type="hidden" id="job-post-list-route" value="{{ route('jobPost.all-job-post') }}">
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
                  <th scope="col"><div>{{ __('Job Title') }}</div></th>
                  <th scope="col"><div>{{ __('Employee Status') }}</div></th>
                  <th scope="col"><div>{{ __('Salary') }}</div></th>
                  <th scope="col"><div>{{ __('Application Deadline') }}</div></th>
                  {{-- <th scope="col"><div>{{ __('Status') }}</div></th> --}}
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
<!-- Edit Modal section end -->
@endsection

@push('script')
<script src="{{ asset('alumni/js/job_post.js') }}"></script>
@endpush
