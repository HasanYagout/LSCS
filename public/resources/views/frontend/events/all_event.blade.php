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
      <!-- Items -->
      <div class="">
        <div class="row rg-24">

            @forelse ( $allEvent as $event )
                <div class="col-lg-4 col-md-6">
                    <div class="bd-ra-25 bg-event-bg p-20 hover-scale-img">
                    <div class="bd-ra-20 overflow-hidden h-215">
                        <img class="w-100 h-100 object-fit-cover" src="{{getFileUrl($event->thumbnail)}}" alt="{{__('event-img')}}">
                    </div>
                    <div class="pt-25 pl-7 pb-14">
                        <div class="d-flex align-items-center cg-63 pb-10">
                        <p class="fs-18 fw-500 lh-28 text-para-color line-horizontal-event">{{ date('M d, Y', strtotime($event->date)) }}</p>
                        <p class="fs-18 fw-500 lh-28 text-para-color">{{ date('h:i A', strtotime($event->date)) }}</p>
                        </div>
                        <h4 class="fs-24 fw-600 h-auto lh-34 min-h-md-84 pb-14 text-black-color">{{ $event->title }}</h4>
                        <div class="d-flex align-items-center cg-7 pb-29">
                        <div class="d-flex"><img src="{{asset('/frontend/images/icon/location.svg')}}" alt=""></div>
                        <p class="fs-18 fw-500 lh-28 text-para-color">{{$event->location}}</p>
                        </div>
                        <a href="{{route('event.view.details', $event->slug)}}" class="fs-18 fw-600 lh-28 text-black-color d-inline-flex align-items-center cg-16 hover-color-primary">
                        {{__('Know More')}}
                        <i class="fa-solid fa-long-arrow-right"></i>
                        </a>
                    </div>
                    </div>
                </div>
            @empty
                <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{__('No Event Found')}}</p>
            @endforelse

        </div>
      </div>
        {{$allEvent->links()}}
    </div>
  </section>


@endsection

