@extends('web.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')

<section class="breadcrumb-wrap py-50 py-md-75 py-lg-100" data-background="{{getSettingImage('page_breadcrumb')}}">
    <div class="text-center position-relative">
      <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{$title}}</h4>
      <ul class="breadcrumb-list">
        <li><a href="{{route('index')}}">{{__('Home')}}</a></li>
        <li><a>{{$title}}</a></li>
      </ul>
    </div>
</section>


<section class="pb-110 pt-60">
    <div class="container">
      <!-- Items -->
      <div class="">
        <div class="row rg-24">
            @forelse ( $stories as $story )
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="hover-scale-img">
                        <div class="bd-ra-14 overflow-hidden h-157"><img class="w-100 h-100 object-fit-cover" src="{{getFileUrl($story->thumbnail)}}" alt="" /></div>
                        <div class="pt-24">
                            <div class="d-flex align-items-center cg-11 pb-10">
                                <div class="d-flex"><img src="{{asset('public/frontend/images/icon/calendar.svg')}}" alt="" /></div>
                                <p class="fs-18 fw-400 lh-18 text-para-color">{{ \Carbon\Carbon::parse($story->created_at)->format('M d, Y') }}</p>
                            </div>
                            <div class="pb-16 mb-20 bd-b-one bd-c-black-10">
                                <h4 class="fs-24 fw-600 lh-34 text-black-color line-clamp-2 sf-text-ellipsis min-h-68">
                                    {{$story->title}}</h4>
                            </div>
                            <a href="{{route('story.view', $story->slug)}}" class="fs-18 fw-600 lh-28 text-black-color d-inline-flex align-items-center cg-16 hover-color-primary">
                                {{__(' Know More')}}
                                <i class="fa-solid fa-long-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{__('No Story Found')}}</p>
            @endforelse

        </div>
      </div>
       {{$stories->links()}}
    </div>
  </section>
@endsection

