@extends('layouts.app')
@push('title')
{{ __('Payment Notify') }}
@endpush
@section('content')
<div class="p-30">
    <div class="">
        <div class="text-center py-sm-60">
            @if($success == true)
            <div class="d-flex justify-content-center pb-30"><img src="{{ asset('assets/images/successful-message.png')}}" alt="" /></div>
            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-8">{{ __('Successful') }}</h4>
            <p class="fs-12 fw-400 lh-17 pb-14 max-w-260 m-auto">{{ $message }}</p>
            @else
            <div class="d-flex justify-content-center pb-30"><img src="{{ asset('assets/images/failed-message.png')}}" alt="" /></div>
            <h4 class="fs-20 fw-600 lh-24 text-1b1c17 pb-8">{{ __('Failed') }}</h4>
            <p class="fs-12 fw-400 lh-17 pb-14 max-w-260 m-auto">{{ $message }}</p>
            @endif
            <a href="{{ route('transaction.list') }}" class="d-inline-block py-13 px-36 bg-cdef84 bd-ra-12 fs-15 fw-500 lh-25 text-1b1c17">{{ __('Go To Transaction') }}</a>
        </div>
    </div>
</div>
@endsection