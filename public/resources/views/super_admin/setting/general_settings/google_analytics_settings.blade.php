@extends('super_admin.layouts.app')
@section('content')
    <!-- Page content area start -->
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb__content">
                        <div class="breadcrumb__content__left">
                            <div class="breadcrumb__title">
                                <h2>{{__(@$pageTitle)}}</h2>
                            </div>
                        </div>
                        <div class="breadcrumb__content__right">
                            <nav aria-label="breadcrumb">
                                <ul class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('super_admin.dashboard')}}">{{__('Dashboard')}}</a></li>
                                    <li class="breadcrumb-item"><a href="#">{{__('Referral ')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{__(@$pageTitle)}}</li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xxl-2 col-lg-3 col-md-4 mb-3 pr-0">
                    @include('super_admin.setting.partials.general-sidebar')
                </div>
                <div class="col-xxl-10 col-lg-9 col-md-8">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-top mb-30">
                            <h2>{{__('Google analytics tracking Id update')}}</h2>
                        </div>
                        <form class="ajax" action="{{ route('super_admin.setting.referral.update') }}" method="post" class="form-horizontal" data-handler="commonResponse">
                            @csrf
                            <div class="row">
                                <div class="input__group mb-25 col-md-6">
                                    <label>{{__('Google Analytics Tracking Id')}}</label>
                                    <div class="input-group">
                                        <input type="text" min="0" max="100" step="any" name="google_analytics_tracking_id" value="{{getOption('google_analytics_tracking_id')}}"  class="form-control">
                                        @if ($errors->has('google_analytics_tracking_id'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('google_analytics_tracking_id') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="input__group mb-25 col-md-6">
                                    <label>{{__('Google Analytics Status')}} </label>
                                    <div class="input-group">
                                        <select name="google_analytics_status" id="" class="form-control">
                                            <option value="1" {{ getOption('google_analytics_status') == 1 ? 'selected':'' }}>{{ __('Yes') }}</option>
                                            <option value="0" {{ getOption('google_analytics_status') != 1 ? 'selected':'' }}>{{ __('No') }}</option>
                                        </select>
                                        @if ($errors->has('google_analytics_status'))
                                            <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{ $errors->first('google_analytics_status') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-12 text-end">
                                    <button class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one" type="submit">{{ __('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Page content area end -->
@endsection
