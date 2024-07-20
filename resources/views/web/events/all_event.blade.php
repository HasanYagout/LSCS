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
            @forelse ($allEvent as $event)
                <div class="col-lg-4 col-md-6">
                    <div class="bd-c-black-10 bd-one rounded-top-4 hover-scale-img">
                        <div class="rounded-top-4 h-234 overflow-hidden position-relative">
                            <img class="container h-100 object-fit-cover p-0 register-right shadow-lg w-100"
                                 onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                 src="{{asset('public/storage/admin/events').'/'.$event->thumbnail}}" alt="{{__('event-img')}}">
                            <p class="position-absolute top-22 left-22 p-10 bd-ra-10 bg-primary-color max-w-77 fs-16 fw-400 lh-19 text-scroll-track text-center">
                                {{ date('M d, Y', strtotime($event->date)) }}
                            </p>
                        </div>
                        <div class="pt-20 pb-25 px-25 shadow-lg p-3 bg-primary-color">
                            <div class="d-flex align-items-center cg-10 pb-10">
                                <div class="w-40 h-40 rounded-circle overflow-hidden">
                                    <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'"
                                         src="{{asset('public/storage/admin/image').'/'.$event->author->image}}" alt="">
                                </div>
                                <p class="fs-16 fw-400 lh-14 text-secondary-color">{{ $event->author->first_name . ' ' . $event->author->last_name }}</p>
                            </div>
                            <div class="d-flex align-items-center cg-63 pb-10">
                                <p class="fs-18 fw-500 lh-28 text-para-color line-horizontal-event">{{ date('M d, Y', strtotime($event->date)) }}</p>
                                <p class="fs-18 fw-500 lh-28 text-para-color">{{ date('h:i A', strtotime($event->date)) }}</p>
                            </div>
                            <h4 class="fs-24 fw-600 lh-34 text-scroll-track line-clamp-2 sf-text-ellipsis min-h-68 p-10">
                                {{ $event->title }}
                            </h4>
                            <div class="d-flex align-items-center cg-7 pb-29">
                                <div class="d-flex">
                                    <img src="{{asset('/frontend/images/icon/location.svg')}}" alt="">
                                </div>
                                <p class="fs-18 fw-500 lh-28 text-para-color">{{ $event->location }}</p>
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

