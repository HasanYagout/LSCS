@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->
<div class="p-30" >
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <!-- Date & Title -->
            <div class="pb-20">
                <p class="fs-14 fw-400 lh-24 text-707070 pb-5">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s',
                    $event->date)->format('jS F, h:i:s A')}} {{$event->location}}</p>
                <h4 class="fs-24 fw-600 lh-29 text-1b1c17">{{$event->title}}</h4>
            </div>
            <!-- Image -->
            <div class="bd-one bd-c-1b1c17 bd-ra-20 overflow-hidden mb-20">
                <!-- Image minimum size 1600*430  -->
                <img class="w-100" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/admin/event'.'/'.$event->thumbnail)}}" alt="">
            </div>

            <div>
                <!-- Description & list -->
                {!! $event->description !!}
            </div>
            @if($event->status == ACTIVE && $event->date >= now() && $event->number_of_ticket_left > 0)
            <!-- Button -->
            <div class="pur-ticket pt-3">
            <a href="{{ route('checkout', ['type' => 'event', 'slug' => $event->slug]) }}" class="bd-ra-12 bg-cdef84 d-inline-flex fs-15 fw-500 hover-bg-one lh-25 px-26 py-13 text-1b1c17">{{ __('Purchase Ticket') }}</a>
            </div>
            @endif
        </div>
    </div>
</div>
<!-- Page content area end -->

@endsection
