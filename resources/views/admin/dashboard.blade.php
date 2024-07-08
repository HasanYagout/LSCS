@extends('layouts.app')
@push('title')
    {{$pageTitle}}
@endpush

@section('content')

    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>

            <div class="row rg-30">
                @php
                    $items = [
                        ['title' => __('Total Alumni'), 'count' => $totalAlumni, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/></svg>'],
                                                ['title' => __('Total Instructors'), 'count' => $totalInstructors, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/></svg>'],
                        ['title' => __('Total Admins'), 'count' => $totalAdmins, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-person" viewBox="0 0 16 16"><path d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/><path d="M8 9a5 5 0 0 0-4.546 2.916C2.164 13.62 3.223 15 4.879 15h6.243c1.656 0 2.715-1.38 1.425-3.084A5 5 0 0 0 8 9z"/></svg>'],
                        ['title' => __('Upcoming Event'), 'count' => $totalEvents, 'icon' => '<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
<rect x="3" y="6" width="18" height="15" rx="2" stroke="#1B1C17" stroke-width="1.4"/>
<path d="M4 11H20" stroke="#1B1C17" stroke-width="1.4" stroke-linecap="round"/>
<path d="M9 16H15" stroke="#1B1C17" stroke-width="1.4" stroke-linecap="round"/>
<path d="M8 3L8 7" stroke="#1B1C17" stroke-width="1.4" stroke-linecap="round"/>
<path d="M16 3L16 7" stroke="#1B1C17" stroke-width="1.4" stroke-linecap="round"/>
</svg>'],
                        ['title' => __('Total Companies'), 'count' => $totalCompany, 'icon' => '<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-building" viewBox="0 0 16 16">
  <path d="M4 2.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zM4 5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM7.5 5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zM4.5 8a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5zm2.5.5a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5zm3.5-.5a.5.5 0 0 0-.5.5v1a.5.5 0 0 0 .5.5h1a.5.5 0 0 0 .5-.5v-1a.5.5 0 0 0-.5-.5z"/>
  <path d="M2 1a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1zm11 0H3v14h3v-2.5a.5.5 0 0 1 .5-.5h3a.5.5 0 0 1 .5.5V15h3z"/>
</svg>'],
                        ['title' => __('Total Jobs'), 'count' => $totalJobs, 'icon' => '<svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M17.0712 5.5H2.92829C2.21821 5.5 1.64258 6.07563 1.64258 6.78571V17.0714C1.64258 17.7815 2.21821 18.3571 2.92829 18.3571H17.0712C17.7812 18.3571 18.3569 17.7815 18.3569 17.0714V6.78571C18.3569 6.07563 17.7812 5.5 17.0712 5.5Z" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
<path d="M13.8569 5.49997V2.92854C13.8569 2.58754 13.7214 2.26052 13.4803 2.0194C13.2392 1.77828 12.9121 1.64282 12.5711 1.64282H7.42829C7.0873 1.64282 6.76027 1.77828 6.51916 2.0194C6.27804 2.26052 6.14258 2.58754 6.14258 2.92854V5.49997" stroke="#707070" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
</svg>']

                    ];
                @endphp

                @foreach ($items as $item)
                    <div class="col-md col-lg-4 col-sm-12">
                        <div class="h-100 zNews-item-one">
                            <div class="content">
                                <h4 class="title">{{ $item['title'] }}</h4>
                                <div class="d-flex justify-content-between mt-20">
                                    <h2 class="fs-5 fw-semibold mt-1 title">{{ $item['count'] }}</h2>
                                    <div class="d-flex">
                                        {!! $item['icon'] !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


        @if(auth('admin')->user()->role_id==USER_ROLE_INSTRUCTOR)
                <div class="pt-30">
                    {{-- <h4 class="fs-24 fw-500 lh-34 text-black pb-16">My Job Post</h4> --}}
                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                        <!-- Table -->
                        <h4 class="title mb-3">{{ __('Latest Transaction Summary') }}</h4>
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable" id="recommendationTable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <div>{{ __('Name') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Purpose') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Transaction ID') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Payment Method') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Date and Time') }}</div>
                                    </th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
{{--    <input type="hidden" id="recommendation_route" value="{{ route('admin.recommendation') }}">--}}
@endsection

@push('script')
    <script src="{{ asset('public/common/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/charts.js') }}"></script>
    <script src="{{ asset('public/admin/js/admin-dashboard.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
