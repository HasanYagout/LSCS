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
        <li><a href="{{route('our.news')}}">{{$title}}</a></li>
      </ul>
    </div>
</section>

<section class="pb-110 pt-60">
    <div class="container">
      <!--  -->
      <div class="row justify-content-center">
        <div class="col-lg-7">
          <div class="text-center pb-28">
            <div class="d-flex justify-content-center align-items-center flex-wrap cg-14 rg-10 pb-10">
              <div class="d-flex align-items-center cg-10">
                <div class="w-30 h-30 rounded-circle overflow-hidden bd-one bd-c-black-color">
                    <img src="{{getFileUrl($news->author->image)}}" alt="">
                </div>
                <p class="fs-18 fw-500 lh-22 text-para-color">{{$news->author->name}}</p>
              </div>
              <div class="d-flex align-items-center cg-14">
                <p class="py-6 px-10 rounded-pill fs-18 fw-500 lh-16 text-black-color bg-color2">{{$news->category->name}}</p>
                <p class="fs-18 fw-500 lh-22 text-para-color">{{ date('M d, Y', strtotime($news->created_at)) }}</p>
              </div>
            </div>
            <h4 class="fs-36 fw-600 lh-46 text-black-color">{{$news->title}}</h4>
          </div>
        </div>
      </div>
      <div class="row justify-content-center">
        <div class="col-lg-8">
          <!-- Image -->
          <div class="bd-ra-20 overflow-hidden mb-42"><img src="{{getFileUrl($news->image)}}" alt="" class="w-100"></div>
          <!-- Text -->
          <p class="fs-18 fw-400 lh-28 text-para-color pb-25">
            {!! ($news->details) !!}
          </p>
        </div>
      </div>
    </div>
  </section>

@endsection

