@extends('web.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')

<section class="breadcrumb-wrap py-50 py-md-75 py-lg-100 bg-dark">
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
                <div class="col-lg-3 col-md-6">
                    <div class="hover-scale-img bd-one bd-c-black-10 bd-ra-14 bg-event-bg hover-scale-img">
                        <div class="bd-ra-14 overflow-hidden h-234 position-relative">
                        <img class="w-100 h-100 object-fit-cover container pd register-right rounded-5 s shadow-lg" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/admin/events').'/'.$event->thumbnail}}" alt="{{__('event-img')}}">
                    </div>
                    <div class="pt-20 pb-25 px-25  shadow-lg p-3 mb-3 bg-primary-color">
                        <div class="d-flex align-items-center cg-63 pb-10">
                        <p class="fs-18 fw-500 lh-28 text-para-color line-horizontal-event">{{ date('M d, Y', strtotime($event->date)) }}</p>
                        <p class="fs-18 fw-500 lh-28 text-para-color">{{ date('h:i A', strtotime($event->date)) }}</p>
                        </div>
                        <h4 class="fs-24 fw-600 lh-34 text-scroll-track line-clamp-2 sf-text-ellipsis min-h-68 p-10">{{ $event->title }}</h4>
                        <div class="d-flex align-items-center cg-7 pb-29">
                        <div class="d-flex"><img src="{{asset('/frontend/images/icon/location.svg')}}" alt=""></div>
                        <p class="fs-18 fw-500 lh-28 text-para-color">{{$event->location}}</p>
                        </div>
                        <a href="{{route('event.view.details', $event->slug)}}" class="fs-18 fw-600 lh-28 text-scroll-track d-inline-flex align-items-center cg-16 hover-color-secondary bd-c-scroll-track-color bd-one bd-ra-12 p-2">
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

