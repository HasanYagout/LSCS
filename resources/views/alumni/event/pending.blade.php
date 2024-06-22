@php use Illuminate\Support\Carbon; @endphp
@extends('layouts.app')

@push('title')
    {{$title}}
@endpush
@push('style')
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
        }
        .navbar {
            background-color: #002a5c;
        }
        .navbar-brand {
            color: #f1a527;
        }
        .news-card {
            border: none;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 42, 92, 0.2);
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
        }
        .news-card .btn-read-more {
            background-color: #f1a527;
            color: #ffffff;
            border-radius: 50px;
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
    <div class="container">
        <div class="row">
            @foreach($events as $event)
                <div class="col-md-4 mt-30">
                    <div class="card news-card">
                        <img src="{{asset('public/storage/admin/events').'/'.$event->thumbnail}}" alt="News Image">
                        <div class="card-body">
                            @php
                                $date = Carbon::parse($event->date);

// Format the date as 'Jun 15'
                        $formattedDate = $date->format('M d');
                            @endphp
                            <p class="card-text news-card-text">{{$formattedDate}}</p>
                            <h5 class="card-title news-card-title">{!! Str::limit($event->description, 150, '...'); !!}</h5>
                            <a href="#" class="btn btn-read-more">Read More</a>
                        </div>
                    </div>
                </div>

            @endforeach
        </div>
        {{$events->links()}}
    </div>
@endsection

