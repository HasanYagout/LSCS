@extends('layouts.app')

@push('title')
    {{$title}}
@endpush
@push('style')
    <style>
        .job-card {
            border: 1px solid #eaeaea;
            border-radius: 8px;
            margin-bottom: 20px;
            padding: 20px;
            border-color: #0b0b0b;
        }
        .job-card .card-header {
            background: #fff;
            border-bottom: none;
        }
        .job-card .card-body {
            padding: 20px;
        }
        .job-card .btn-apply {
            background-color: #ffc107;
            color: #000;
            border-radius: 50px;
        }
        .job-card .btn-apply:hover {
            background-color: #e0a800;
            color: #000;
        }
        .job-card .tags span {
            background-color: #edf0f3;
            padding: 12px 15px;

            border-radius: 5px;
        }
        .job-card .tags span:hover {
            background-color: var(--secondary-color);
            color: #fff;
        }
    </style>
@endpush
@section('content')
    @php
        use Illuminate\Support\Facades\Auth;
        $authenticatedGuard = null;
        $authenticatedUser = null;

        foreach (config('auth.guards') as $guardName => $guardConfig) {
            if (Auth::guard($guardName)->check()) {
                $authenticatedGuard = $guardName;
                $authenticatedUser = Auth::guard($guardName)->user();
                break;
            }
        }
    @endphp
    <div class="container mt-5">
        <div class="row">
            <form action="{{ route('alumni.jobs.all-job-post') }}" method="GET" class="mb-4">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Search jobs" name="search" value="{{ request('search') }}">
                    <div class="input-group-append">
                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                    </div>
                </div>
            </form>
        </div>
                <div class="row">
                    @foreach($jobs as $job)
                        <div class="col-md-4 mt-30">
                            <div class="card news-card border-dark rounded rounded">
                                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/').'/'.$job->posted_by.'/'.$job->company->image}}" alt="Company Logo">
                                <div class="card-body">
                                    <h5 class="card-title news-card-title">{{$job->company->name}}</h5>
                                    <small class="text-muted">{{$job->title}}</small>
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="tags">
                                            <span>{{$job->employee_status}}</span>
                                            <span> / </span>
                                            <span>{{$job->location}}</span>
                                        </div>
                                    </div>
                                    <a href="{{route('alumni.jobs.details',['company'=>$job->user_id,'slug'=>$job->slug])}}" class="py-13 px-26 bg-secondary-color border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one" >Apply now</a>
                                </div>
                            </div>
                        </div>

                    @endforeach
                </div>
        </div>
        {{$jobs->links()}}
        <!-- Repeat the above card for each job listing -->
    </div>

@endsection

@push('script')
    <script src="{{ asset('public/alumni/js/all_jobs.js') }}"></script>
@endpush
