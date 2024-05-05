@extends('layouts.app')

@push('title')
{{$title}}
@endpush

@section('content')
    <!-- Page content area start -->
    <div class="p-30">
        <div class="">
            <input type="hidden" id="news-list-route" value="{{ route('all.news') }}">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
              <!-- Table -->
              <div class="table-responsive zTable-responsive">
                <table class="table zTable" id="newsDataTable">
                    <thead>
                      <tr>
                        <th scope="col"><div>{{ __('Image') }}</div></th>
                        <th scope="col"><div>{{ __('Title') }}</div></th>
                        <th scope="col"><div>{{ __('Category') }}</div></th>
                        <th scope="col"><div>{{ __('Status') }}</div></th>
                        <th scope="col"><div>{{ __('Name') }}</div></th>
                         <th class="w-110 text-center" scope="col"><div>{{ __('Action') }}</div></th>
                      </tr>
                    </thead>
                  </table>
              </div>
            </div>
          </div>
        </div>
    </div>
    <!-- Page content area end -->

@endsection

@push('script')
<script src="{{ asset('admin/js/news.js') }}"></script>
@endpush



