@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
<!-- Page content area start -->
<div class="p-30">
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
                <img class="w-100" src="{{asset('public/storage/admin/events').'/'.$event->thumbnail}}" alt="">
            </div>

            <div>
                <!-- Description & list -->
                {!! $event->description !!}
            </div>

        </div>
    </div>
</div>
<!-- Page content area end -->

@endsection
