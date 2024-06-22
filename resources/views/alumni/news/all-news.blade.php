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
    <!-- Page content area start -->
    <div class="p-30" >

    </div>
    <!-- Page content area end -->

    <nav class="navbar navbar-expand-lg">
        <a class="navbar-brand" href="#">College News</a>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-4">
                <div class="card news-card">
                    <img src="https://via.placeholder.com/350x200" alt="News Image">
                    <div class="card-body">
                        <h5 class="card-title news-card-title">News Title 1</h5>
                        <p class="card-text news-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl eros, pulvinar facilisis justo mollis...</p>
                        <a href="#" class="btn btn-read-more">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card news-card">
                    <img src="https://via.placeholder.com/350x200" alt="News Image">
                    <div class="card-body">
                        <h5 class="card-title news-card-title">News Title 2</h5>
                        <p class="card-text news-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl eros, pulvinar facilisis justo mollis...</p>
                        <a href="#" class="btn btn-read-more">Read More</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card news-card">
                    <img src="https://via.placeholder.com/350x200" alt="News Image">
                    <div class="card-body">
                        <h5 class="card-title news-card-title">News Title 3</h5>
                        <p class="card-text news-card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque nisl eros, pulvinar facilisis justo mollis...</p>
                        <a href="#" class="btn btn-read-more">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')

@endpush



