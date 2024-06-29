@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
    <div class="container mt-5">
        <div class="row">
              @forelse ( $Allnotice as $notice )
                <div class="col-xl-3 col-lg-4 col-sm-6 mb-4">
                    <div class="border-0 card news-card overflow-hidden rounded-4 shadow">
                        <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/admin/notice').'/'.$notice->image}}" alt="">
                    <div class="card-body">
                        <h4 class="title">{{$notice->title}}</h4>
                        <p class="card-text news-card-text fs-13">{{ getSubText($notice->details, 200) }}</p>
                        <a href="{{route('alumni.notice.details', $notice->slug)}}" class="bg-f1a527 border-0 btn btn-primary btn-read-more">{{__('More Details')}}</a>
                    </div>
                    </div>
                </div>
              @empty
                <div class="">{{__("NO Data Found")}}</div>
              @endforelse
                {{$Allnotice->links()}}
            </div>
          </div>

    <!-- Page content area end -->
@endsection
