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
            <!-- Items -->

            <div class="row rg-30">
                @foreach ($recommendations as $title => $info)
                    <div class="col-md col-sm-12">
                        <div class="rounded-3 zNews-item-one">
                            <div class="content row" style="background-color: #363636;">
                                <div class="align-items-center col-lg-12 d-flex justify-content-between">
                                    <h4 class="title text-white">{{ $info['count'] }}</h4>
                                    <div class="d-flex justify-content-between">
                                        <div class="d-flex p-2 rounded-4" style="background-color:
                                        @if ($title == 'Total') #b1813275;
                                        @elseif ($title == 'Pending') #ae75c47d;
                                        @elseif ($title == 'Confirmed') #17a2b894;
                                        @elseif ($title == 'Rejected') #dc35457a;
                                        @elseif ($title == 'Done') #00ff6c85;
                                        @else #f1a52775; @endif">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" style="color:
                                        @if ($title == 'Total') #f1a527;
                                        @elseif ($title == 'Pending') #ae75c4;
                                        @elseif ($title == 'Confirmed') #17a2b8;
                                        @elseif ($title == 'Rejected') #dc3545;
                                        @elseif ($title == 'Done') #00ff6c;
                                        @else #f1a52775; @endif" " fill="currentColor" class="bi {{ $info['icon'] }}" viewBox="0 0 16 16">
                                            <!-- SVG paths for each icon will be auto-generated based on the class -->
                                            @if ($info['icon'] == 'bi-list')
                                                <path fill-rule="evenodd" d="M3 4.5a.5.5 0 0 1 .5-.5H12a.5.5 0 0 1 0 1H3.5a.5.5 0 0 1-.5-.5zM3 7.5a.5.5 0 0 1 .5-.5H12a.5.5 0 0 1 0 1H3.5a.5.5 0 0 1-.5-.5zM3 10.5a.5.5 0 0 1 .5-.5H12a.5.5 0 0 1 0 1H3.5a.5.5 0 0 1-.5-.5z"/>
                                            @elseif ($info['icon'] == 'bi-clock')
                                                <path d="M8 3.5a.5.5 0 0 1 .5.5v4h2a.5.5 0 0 1 0 1H8a.5.5 0 0 1-.5-.5V4a.5.5 0 0 1 .5-.5z"/>
                                                <path d="M8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16zm0-1A7 7 0 1 0 8 1a7 7 0 0 0 0 14z"/>
                                            @elseif ($info['icon'] == 'bi-check-circle')
                                                <path d="M15.854 4.146a.5.5 0 1 1-.708.708L7 12.207l-3.646-3.647a.5.5 0 0 1 .708-.708L7 10.793l8.146-8.147a.5.5 0 0 1 .708 0z"/>
                                                <path d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zM8 16A8 8 0 1 1 8 0a8 8 0 0 1 0 16z"/>
                                            @elseif ($info['icon'] == 'bi-x-circle')
                                                <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16"/>
                                                <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708"/>
                                            @elseif ($info['icon'] == 'bi-check')
                                                <path d="M13.854 1.146a.5.5 0 0 1 0 .708l-8 8a.5.5 0 0 1-.708 0l-4-4a.5.5 0 1 1 .708-.708L6 8.293l7.646-7.647a.5.5 0 0 1 .708 0z"/>
                                                @endif
                                                </svg>
                                        </div>
                                    </div>

                                </div>
                                    <h2 class=" fw-normal  mt-1 text-b7bdc6 title">{{__($title)}}</h2>



                            </div>
                        </div>
                    </div>
                @endforeach
            </div>


                <div class="pt-30">
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    <input type="hidden" id="recommendation_route" value="{{ route('admin.instructor.dashboard') }}">
                    <input type="hidden" id="status_update_route"  value="{{ route('admin.instructor.recommendation.status.update') }}">
                    <select id="status-change" class="form-control mb-3">
                        <option value="">{{ __('Select Status') }}</option>
                        <option value="1">{{ __('Confirmed') }}</option>
                        <option value="2">{{ __('Done') }}</option>
                        <option value="3">{{ __('Rejected') }}</option>
                        <option value="0">{{ __('Pending') }}</option>
                    </select>
                    <button id="change-status-btn" class="bd-c-primary-color btn hover-bd-secondary
                  hover-color-secondary mb-3">{{ __('Change Status') }}</button>

                    <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">

                        <h4 class="title mb-3">{{ __('Recommendation Summary') }}</h4>
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable" id="recommendationTable">
                                <thead>
                                <tr>
                                    <th scope="col">
                                        <div>{{ __('check') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('ID') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Name') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('GPA') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Recommendations') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Status') }}</div>
                                    </th>
                                    <th scope="col">
                                        <div>{{ __('Action') }}</div>
                                    </th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            <div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered modal-lg">
                    <div class="modal-content">

                    </div>
                </div>
            </div>


        </div>
    </div>

@endsection
@push('script')

    <script src="{{ asset('public/admin/js/recommendation.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
