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
        <li><a href="{{route('all.event')}}">{{$title}}</a></li>
      </ul>
    </div>
</section>

<section class="pb-110 pt-60">
    <div class="container">
      <!--  -->
      <div class="max-w-548 m-auto text-center pb-45">
        <div class="d-flex justify-content-center align-items-center cg-63 pb-12">
          <p class="fs-18 fw-500 lh-28 text-para-color line-horizontal-event">{{ date('M d, Y', strtotime($event->date)) }}</p>
          <p class="fs-18 fw-500 lh-28 text-para-color">{{ date('h:i A', strtotime($event->date)) }}</p>
        </div>
        <h4 class="fs-36 fw-600 lh-46 text-black-color pb-10">{{$event->title}}</h4>
        <div class="d-flex justify-content-center align-items-center cg-7 pb-29">
          <div class="d-flex"><img src="{{asset('/frontend/images/icon/location.svg')}}" alt=""></div>
          <p class="fs-18 fw-500 lh-28 text-para-color">{{$event->location}}</p>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <!-- Image -->
          <div class="bd-ra-20 overflow-hidden mb-42"><img src="{{ getFileUrl($event->thumbnail)}}" alt="" class="w-100"></div>
          <!-- Text -->
          <p class="fs-18 fw-400 lh-28 text-para-color pb-25">
           {!! ($event->description) !!}
          </p>
        </div>
      </div>
    </div>
  </section>

@endsection

