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

            @forelse($newsData as $news)
                <div class="col-xl-3 col-md-6 col-sm-6 mb-4">
                    <div class="border-0 card news-card overflow-hidden rounded-4 shadow">
                        <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/admin/news').'/'.$news->image}}" class="card-img-top" alt="News Image" style=" object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title text-f1a527" style="color: #002a5c;">{{$news->title}}</h5>
                            <p class="card-text news-card-text fs-13" style="color: #002a5c;">{{ getSubText($news->details, 200)}}</p>
                            <a href="{{route('alumni.news.details',$news->slug)}}" class="bg-f1a527 border-0 btn btn-primary btn-read-more">Read More</a>
                        </div>
                    </div>
                </div>
            @empty
                <p class="text-center w-100 py-5">{{__('No News Found')}}</p>
            @endforelse
        </div>
    </div>
@endsection


