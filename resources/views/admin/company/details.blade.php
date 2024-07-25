    @extends('layouts.app')

    @push('title')
        {{$title}}
    @endpush

    @section('content')
        <style>

            .proposal-iframe {
                height: 500px; /* Default height */
            }

            @media (min-width: 1200px) {
                .proposal-iframe {
                    height: 900px; /* Height for large screens */
                }
            }

        </style>
        <!-- Page content area start -->
        <div class="p-30">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card text-center">
                            <div class=" hover-scale-img  bg-dark">
                                <img  onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ asset('public/storage/company' . $company->logo) }}" alt="Company Logo" class=" w-100 h-100 object-fit-cover container pd register-right rounded-5 s  ">

                            </div>
                            <div class="pt-20 pb-15 px-15 text-center bg-primary-color ">
                                <h1 class="fs-70 fw-600 lh-28 text-scroll-track pb-2">{{ $company->name }}</h1>
                            </div>
                        </div>

                    </div>

                </div>
                <h3 class="card-title m-4 text-black  ">Company Details</h3>
                <div class="row">
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class=" pt-10 pb-5 px-5 text-center bg-primary-color text-scroll-track ">General</h5>
                                <p class="pt-3 text-center"><strong>Email:</strong> {{ $company->email }}</p>
                                <p class="pt-4 text-center"><strong>Phone:</strong> {{ $company->phone }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="pt-10 pb-5 px-5 text-center bg-primary-color text-scroll-track">Jobs</h5>
                                <h1 class="pt-3 text-center">{{count($company->jobs)}}</h1>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">

                    </div>
                </div>
                <div class="row mt-3 ">
                    <div class="col-lg-12">
                        <iframe class="proposal-iframe" src="{{asset('public/storage/company/proposal'.'/'.$company->proposal)}}" type="application/pdf" width="100%" height="500px" ></iframe>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page content area end -->
    @endsection
