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
      <!-- Items -->
      <div class="">
        <div class="row rg-24">
            @forelse ( $allNews as $news )
                <div class="col-lg-4 col-md-6">
                    <div class="hover-scale-img bd-one bd-c-black-10 bd-ra-25 bg-event-bg">
                        <div class="bd-ra-14 overflow-hidden h-234 position-relative">
                            <img class="w-100 h-100 object-fit-cover" src="{{getFileUrl($news->image)}}" alt="">
                            <p class="position-absolute top-22 left-22 p-10 bd-ra-10 bg-primary-color max-w-77 fs-16 fw-400 lh-19 text-black-color text-center">{{ date('M d, Y', strtotime($news->created_at)) }}</p>
                        </div>
                    <div class="pt-29 pb-34 px-25">
                        <div class="d-flex align-items-center cg-10 pb-10">
                            <div class="w-30 h-30 rounded-circle overflow-hidden"><img src="{{getFileUrl($news->author->image)}}" alt=""></div>
                            <p class="fs-16 fw-400 lh-14 text-para-color">{{__('BY')}} : {{$news->author->name}}</p>
                        </div>
                        <h4 class="fs-24 fw-600 lh-34 line-clamp-2 mb-25 min-h-auto min-h-md-68 sf-text-ellipsis text-black-color">{{ $news->title }}</h4>
                        <a href="{{route('news.view.details', $news->slug)}}" class="fs-18 fw-600 lh-28 text-black-color d-inline-flex align-items-center cg-16 hover-color-primary">
                            {{__('Read More')}}
                            <i class="fa-solid fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
            @empty
                <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{__('No News Found')}}</p>
            @endforelse

        </div>
      </div>
       {{$allNews->links()}}
    </div>
  </section>




@endsection

