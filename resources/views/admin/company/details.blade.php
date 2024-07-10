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
                            <div class="card-header text-secondary-color  bg-primary-color  m-2">
                                <img  onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/company' . $company->logo) }}" alt="Company Logo" class=" object-fit-cover rounded-circle">
                                <h2 class="mb-3 mt-5">{{ $company->name }}</h2>
                            </div>

                        </div>

                    </div>

                </div>
                <h3 class="card-title m-4 text-black  ">Company Details</h3>
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class=" mb-2">General</h5>
                                <p class="card-text m-1"><strong>Email:</strong> {{ $company->email }}</p>
                                <p class="card-text m-1"><strong>Phone:</strong> {{ $company->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card m-1">
                            <div class="card-body m-1">
                                <h5>Jobs</h5>
                                <h1>{{count($company->jobs)}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-lg-6">
                        <iframe src="{{asset('public/storage/company'.'/'.$company->proposal)}}" type="application/pdf" width="100%" height="500px" ></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content area end -->
    @endsection
