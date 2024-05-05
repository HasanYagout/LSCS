@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->
<div class="p-30">
    <div>
        <input type="hidden" id="member-list-route" value="{{ route('admin.membership.list') }}">

        <div class="d-flex flex-wrap justify-content-between align-items-center pb-16">
            <h4 class="fs-24 fw-500 lh-34 text-black">{{$title}}</h4>
        </div>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <!-- Table -->
        <div class="table-responsive zTable-responsive">
            <table class="table zTable" id="memberListDataTable">
              <thead>
                <tr>
                    <th scope="col"><div>{{ __('User name') }}</div></th>
                    <th scope="col"><div>{{ __('Plan Name') }}</div></th>
                    <th scope="col"><div>{{ __('Membership date') }}</div></th>
                    <th scope="col"><div>{{ __('Expired date') }}</div></th>
                    <th scope="col"><div>{{ __('Status') }}</div></th>
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
    <script src="{{ asset('admin/js/membership.js') }}"></script>
@endpush
