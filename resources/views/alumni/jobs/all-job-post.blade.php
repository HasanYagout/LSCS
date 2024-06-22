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
            box-shadow: 6px 6px 8px 4px rgba(241, 165, 39, 0.5); /* Updated shadow color */
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
            margin-right: 10px;
            border: 1px solid #ff4757;
            color: #ff4757;
            padding: 2px 8px;
            border-radius: 20px;
        }
        .job-card .tags span:hover {
            background-color: #ff4757;
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
            @foreach($jobs as $job)
                <div class="col-lg-6">
                    <div class="job-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/').'/'.$job->posted_by.'/'.$job->company->image}}" class="rounded-circle mr-3" alt="Company Logo">
                                <div>
                                    <h5 class="mb-0">{{$job->company->name}}</h5>
                                    <small class="text-muted">{{$job->title}}</small>
                                </div>
                            </div>
                            <a href="{{route('alumni.jobs.details',$job->slug)}}" class="btn btn-apply">Apply now</a>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <p class="mb-0"><strong>Budget:</strong> $100 / Hours</p>
                                    <p class="mb-0"><strong>Preferred:</strong> +2 Years Experience</p>
                                </div>
                                <div class="tags">
                                    <span>Figma</span>
                                    <span>UX Design</span>
                                    <span>Design Thinking</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Repeat the above card for each job listing -->
    </div>

@endsection

@push('script')
    <script src="{{ asset('public/alumni/js/all_jobs.js') }}"></script>
@endpush
