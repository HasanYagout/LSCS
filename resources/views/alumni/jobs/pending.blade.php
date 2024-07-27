@php use Illuminate\Support\Facades\Auth; @endphp
@extends('layouts.app')

@push('title')
    {{$title}}
@endpush
@push('style')
    <style>
        .job-card {
            border-radius: 8px;
            margin-bottom: 20px;
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

    <div class="container mt-5">

        <div class="row">
            @foreach($appliedJobs as $jobs)
                <div class="col-lg-4">
                    <div class="job-card card rounded-top-4">
                    <div class="border-0 news-card rounded rounded">
                        <img class="rounded-top-4" onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{asset('public/storage/').'/'.$jobs->posted_by.'/'.$jobs->company->image}}" alt="Company Logo">
                        <div class="card-body">
                            <h5 class="card-title">{{$jobs->posted_by=='admin'?$jobs->admin->first_name.' '.$jobs->admin->last_name:$jobs->company->name}}</h5>
                            <small class="text-muted">{{$jobs->job->title}}</small>
                            <div class="d-flex my-3 justify-content-between align-items-center mb-4">
                                <div class="tags">
                                    @foreach(json_decode($jobs->job->skills) as $skill)
                                        <span>{{$skill}}</span>
                                    @endforeach
                                </div>
                            </div>
{{--                            <a href="{{route('alumni.jobs.details',['company'=>$jobs->user_id,'slug'=>$jobs->slug])}}" class="py-13 px-26 bg-secondary-color border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one" >Apply now</a>--}}
                        </div>
                    </div>
                </div>
                </div>
            @endforeach
        </div>
        {{ $appliedJobs->links() }}
        <!-- Repeat the above card for each job listing -->
    </div>

@endsection

@push('script')
    <script src="{{ asset('public/alumni/js/all_jobs.js') }}"></script>
@endpush
