@extends('web.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')

    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{$title}}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{route('index')}}">{{__('Home')}}</a></li>
                <li><a href="{{route('all.alumni')}}">{{$title}}</a></li>
            </ul>
        </div>
    </section>

    <section class="pb-110 pt-60">
        <div class="container">
            <!-- Items -->
            <div class="pb-62">
                <div class="row rg-24">

                    @forelse ( $allAlumni as $alumni)

                        <div class="col-lg-3 col-md-4 col-sm-6">
                            <div class="bd-ra-25 bg-event-bg">
                                <div class="bd-ra-25 overflow-hidden h-341">
                                    <img class="w-100 h-100 object-fit-cover" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/alumni').'/'.$alumni->image}}" alt="{{$alumni->first_name}}">
                                </div>
                                <div class="pt-21 pb-23 px-10 text-center">
                                    <h4 class="fs-20 fw-600 lh-28 text-black-color pb-2">{{$alumni->first_name.' '.$alumni->last_name}}</h4>
                                    <p class="fs-18 fw-400 lh-28 text-para-color">{{$alumni->major}}, {{__('Batch')}} {{$alumni->graduation_year}}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{__('No Alumni Found')}}</p>
                    @endforelse
                </div>
            </div>

            <div class="d-flex justify-content-center">
                <a href="{{route('admin.list-search-with-filter')}}" class="border-0 bd-ra-12 py-15 px-32 bg-primary-color d-flex align-items-center cg-16 fs-18 fw-600 lh-28 text-black-color">
                    {{__('View All Alumni')}}
                    <i class="fa-solid fa-long-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>


@endsection

