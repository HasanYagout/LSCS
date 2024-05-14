@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
    <!-- Page content area start -->
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{__($title)}}</h4>
            <!-- Items -->
            <div class="row rg-30">

              @forelse ( $Allnotice as $notice )
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="zNews-item-one">
                    <div class="img"><img src="{{getFileUrl($notice->image)}}" alt=""></div>
                    <div class="content">
                        <p class="date">{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $notice->created_at)->format('jS, F, Y')}}</p>
                        <h4 class="title">{{$notice->title}}</h4>
                        <p class="info">{{ getSubText($notice->details, 350) }}</p>
                        <a href="{{route('notice.details', $notice->slug)}}" class="link">{{__('More Details')}}</a>
                    </div>
                    </div>
                </div>
              @empty
                <div class="">{{__("NO Data Found")}}</div>
              @endforelse

            </div>
          </div>
    </div>
    <!-- Page content area end -->
@endsection
