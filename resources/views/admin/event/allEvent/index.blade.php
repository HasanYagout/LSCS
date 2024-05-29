@extends('admin.layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->
<div class="p-30" style="margin-left:250px;">
    <div>
        <input type="hidden" id="event-all-list-route" value="{{ route('admin.event.all') }}">

        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
        </div>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <!-- Table -->
        <div class="table-responsive zTable-responsive">
            <table class="table zTable" id="allEventDataTable">
              <thead>
                <tr>
                    <th scope="col"><div>{{ __('Event Title') }}</div></th>
                    <th scope="col"><div>{{ __('Category') }}</div></th>
                    <th scope="col"><div>{{ __('Date & Time') }}</div></th>
                    <th scope="col"><div>{{ __('Location') }}</div></th>
                     <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                </tr>
              </thead>
            </table>
        </div>

      </div>
    </div>
</div>
<!-- Page content area end -->


@endsection

@push('script')
<script src="{{ asset('public/admin/js/all-event.js') }}"></script>
@endpush
