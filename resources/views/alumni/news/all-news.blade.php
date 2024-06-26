@extends('layouts.app')

@push('title')
    {{$title}}
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


