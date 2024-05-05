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
              <!--  -->
              <div class="d-flex align-items-center cg-8 pb-10">
                <!-- Author -->
                <div class="d-flex align-items-center cg-10">
                  <div class="flex-shrink-0 w-30 h-30 bd-one bd-c-1b1c17 rounded-circle overflow-hidden bg-eaeaea d-flex justify-content-center align-items-center"><img src="{{getFileUrl($news->author->image)}}" alt=""></div>
                  <p class="fs-14 fw-500 lh-17 text-707070">{{$news->author->name}}</p>
                </div>
                <!-- News type -->
                <p class="zBadge-one">{{$news->category->name}}</p>
                <!-- Date -->
                <p class="fs-14 fw-400 lh-18 text-707070">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $news->created_at)->format('jS, F, Y')}}</p>
              </div>
              <!-- Title -->
              <h4 class="fs-24 fw-600 lh-29 text-1b1c17 pb-20">{{$news->title}}</h4>
              <!-- Image -->
              <div class="bd-one bd-c-1b1c17 bd-ra-20 overflow-hidden mb-25">
                <!-- Image minimum size 1600*430  -->
                <img class="w-100" src="{{getFileUrl($news->image)}}" alt="">
              </div>
              <div>
                <!-- Info -->
                {!! $news->details !!}
              </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
