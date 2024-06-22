@extends('layouts.app')

@push('title')
    {{$title}}
@endpush

@section('content')

    <!-- Page content area start -->
    <div class="p-30">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card text-center">
                        <div class="card-header text-white text-002a5c bg-light ">
                            <img  onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/company' . $company->logo) }}" alt="Company Logo" class=" object-fit-cover rounded-circle">
                            <h2>{{ $company->name }}</h2>
                        </div>

                    </div>

                </div>

            </div>
            <h5 class="card-title">Company Details</h5>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>General</h5>
                            <p class="card-text"><strong>Email:</strong> {{ $company->email }}</p>
                            <p class="card-text"><strong>Phone:</strong> {{ $company->phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5>Jobs</h5>
                            <h1>{{count($company->jobs)}}</h1>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        {{--                        <h5>Posts</h5>--}}
                        {{--                        <h1>{{count($company->jobs)}}</h1>--}}
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-lg-6">
                    <iframe src="{{asset('public/storage/company'.'/'.$company->proposal)}}" type="application/pdf" width="100%" height="800px"></iframe>
                </div>
            </div>
        </div>
    </div>
    <!-- Page content area end -->
@endsection
