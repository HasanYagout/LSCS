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
        <li><a href="{{route('our.notice')}}">{{$title}}</a></li>
      </ul>
    </div>
</section>


<section class="pb-110 pt-60">
    <div class="container">
      <!-- Items -->
      <div class="">
        <div class="row rg-24">
            @forelse ( $allNotice as $notice )
                <div class="col-lg-4 col-md-6">
                    <div class="bd-ra-25 h-100 bg-event-bg py-32 px-27">
                        <p class="fs-18 fw-500 lh-28 text-para-color">{{ date('M d, Y', strtotime($notice->created_at)) }}</p>
                        <a href="{{route('notice.view.details', $notice->slug)}}" class="d-block fs-24 fw-600 lh-34 text-black-color mb-16 line-clamp-2 sf-text-ellipsis min-h-68">{{ $notice->title }}</a>
                        <p class="fs-18 fw-400 lh-28 text-para-color line-clamp-6 sf-text-ellipsis">{{getSubText($notice->details, 300)}}</p>
                    </div>
                </div>
            @empty
                <p class="fs-18 fw-400 lh-28 text-para-color text-center py-78">{{__('No Notice Found')}}</p>
            @endforelse

        </div>
      </div>
       {{$allNotice->links()}}
    </div>
  </section>




@endsection

