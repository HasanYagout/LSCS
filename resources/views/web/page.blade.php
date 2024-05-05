@extends('frontend.layouts.app')
@push('title')
    {{ __($pageTitle) }}
@endpush
@section('content')
    <!-- Start Breadcrumb -->
    <section class="breadcrumb-wrap py-50 py-md-75 py-lg-100"  data-background="{{getSettingImage('page_breadcrumb')}}">
        <div class="text-center position-relative">
            <h4 class="fs-50 fw-700 lh-60 text-white pb-8">{{__($pageTitle)}}</h4>
            <ul class="breadcrumb-list">
                <li><a href="{{route('index')}}">{{__('Home')}}</a></li>
                <li><a>{{__($pageTitle)}}</a></li>
            </ul>
        </div>
    </section>
    <!-- End Breadcrumb -->

    <!-- Start Privacy Policy -->
    <section class="pb-110 pt-60">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                   {!! $description !!}
                </div>
            </div>
        </div>
    </section>
    <!-- End Privacy Policy -->
@endsection
