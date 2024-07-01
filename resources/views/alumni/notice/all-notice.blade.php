@extends('layouts.app')

@push('title')
{{$title}}
@endpush
@push('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            border-color: #0b0b0b;
        }
        .navbar {
            background-color: #002a5c;
        }
        .navbar-brand {
            color: #f1a527;
        }
        .news-card {
            border-color: black;
            border-radius: 10px;
            margin-bottom: 20px;
            overflow: hidden;
        }
        .news-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .news-card .card-body {
            padding: 20px;
            background-color: #ffffff;
        }
        .news-card-title {
            color: #002a5c;
            font-size: 1.5rem;
        }
        .news-card-text {
            color: #002a5c;
            margin-top: 10px;
        }
        .news-card .btn-read-more {
            background-color: #f1a527;
            color: #ffffff;
            border-radius: 50px;
            margin-top: 15px;
        }
        .footer {
            background-color: #002a5c;
            color: #ffffff;
            padding: 20px 0;
            text-align: center;
        }
    </style>
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
