@extends('layouts.app')
@push('title')
    {{$pageTitle}}
@endpush

@section('content')
    <style>
        svg{
            filter: saturate(200%);


        }
        .zNews-item-one {
            transition: transform 0.3s ease;
        }

        .zNews-item-one:hover {
            transform: translateY(-10px);
        }
    </style>
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($pageTitle) }}</h4>

            <div class="row rg-30">
                @foreach ($items as $item)
                    <div class="col-md col-lg-3 col-sm-12">
                        <div class="h-100 zNews-item-one shadow-sm">
                            <div class="content row" style="background-color: #363636;">
                                <div class="align-items-center col-lg-12 d-flex justify-content-between">
                                    <h4 class="title text-white">{{ $item['count'] }}</h4>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex p-2 rounded-4" style="background-color:
                            @if ($item['title'] == __('Total Alumni')) #b1813275;
                            @elseif ($item['title'] == __('Total Instructors')) #ae75c47d;
                            @elseif ($item['title'] == __('Total Admins')) #17a2b894;
                            @elseif ($item['title'] == __('Upcoming Event')) #dc35457a;
                            @elseif ($item['title'] == __('Total Companies')) #00ff6c85;
                            @else #f1a52775; @endif">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color: {{ $item['color'] }};" fill="currentColor" class="bi {{ $item['icon'] }}" viewBox="0 0 16 16">
                                                {!! $item['svg'] !!}
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                <h4 class="title text-white">{{ $item['title'] }}</h4>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>



        </div>
    </div>
    {{--    <input type="hidden" id="recommendation_route" value="{{ route('admin.recommendation') }}">--}}
@endsection

@push('script')
    <script src="{{ asset('public/common/js/apexcharts.min.js') }}"></script>
    <script src="{{ asset('public/admin/js/charts.js') }}"></script>
    <script src="{{ asset('public/admin/js/admin-dashboard.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
