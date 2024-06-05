@extends('layouts.app')

@push('title')
{{$title}}
@endpush


@section('content')
    <div class="container">
        <div class="row">
            @foreach($events as $event)
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-header">
                            {{$event->title}}
                        </div>
                        <div class="card-body">
                            <img src="{{asset('public/storage/admin/events').'/'.$event->thumbnail}}" alt="" width="300">
                        </div>

                        <div class="card-footer">
                            {!! $event->description !!}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        {{$events->links()}}
    </div>
@endsection

