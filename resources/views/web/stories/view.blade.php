@extends('frontend.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')

    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100" data-background="{{getSettingImage('page_breadcrumb')}}">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{$title}}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{route('index')}}">{{__('Home')}}</a></li>
                <li><a href="{{route('all.stories')}}">{{$title}}</a></li>
            </ul>
        </div>
    </section>

    <section class="pb-110 pt-60">
        <div class="container">
            <!--  -->
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-6 col-sm-10">
                    <div class="text-center pb-28">
                        <div class="d-flex justify-content-center align-items-center cg-11 pb-10">
                            <div class="d-flex"><img src="{{asset('public/frontend/images/icon/calendar.svg')}}" alt="{{$story->title}}"/></div>
                            <p class="fs-18 fw-400 lh-18 text-para-color">{{ \Carbon\Carbon::parse($story->created_at)->format('M d, Y') }}</p>
                        </div>
                        <h4 class="fs-24 fw-600 lh-34 text-black-color">{{$story->title}}</h4>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Image -->
                    <div class="bd-ra-20 overflow-hidden mb-42"><img src="{{getFileUrl($story->thumbnail)}}" alt="" class="w-100"/></div>
                    <!-- Text -->
                    {!! ($story->body) !!}
                </div>
            </div>
        </div>
    </section>

@endsection

