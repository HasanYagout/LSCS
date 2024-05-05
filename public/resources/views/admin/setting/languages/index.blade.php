@extends('layouts.app')
@section('content')
@push('title')
    {{$title}}
@endpush
<!-- Page content area start -->
<div class="p-30">
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
        <div class="row">
            <input type="hidden" id="language-route" value="{{ route('admin.setting.languages.index') }}">
            <div class="col-lg-12">
                <div class="col-md-12 bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                    <div class="d-flex flex-wrap item-title justify-content-end mb-3">
                        <div>
                            <button
                                class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one border-0"
                                type="button" data-bs-toggle="modal" data-bs-target="#add-modal">
                                <i class="fa fa-plus"></i> {{ __('Add Language') }}
                            </button>
                        </div>
                    </div>
                    <div class="customers__table">
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable" id="commonDataTable">
                                <thead>
                                    <tr>
                                        <th scope="col">
                                            <div>{{ __("Flag") }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __("Language") }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __("ISO code") }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __("RTL") }}</div>
                                        </th>
                                        <th scope="col">
                                            <div>{{ __("Font") }}</div>
                                        </th>
                                        <th scope="col" class="text-center">
                                            <div>{{ __("Action") }}</div>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content area end -->

<!-- Add Modal section start -->
<div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ __('Add Language') }}</h5>
                <button type="button" class="border-0 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="ajax reset" action="{{ route('admin.setting.languages.store') }}" method="post"
                data-handler="commonResponseForModal" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="row rg-25">
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="currentPassword" class="form-label">{{ __('Language') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="primary-form-control" name="language"
                                        placeholder="{{ __('Language') }}">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="iso_code" class="form-label">{{ __('ISO Code') }} <span
                                            class="text-danger">*</span></label>
                                    <select name="iso_code" class="primary-form-control" id="sf-select-modal-add">
                                        <option value="">--{{ __('Select ISO Code') }}--</option>
                                        @foreach(languageIsoCode() as $code => $isoCountryName)
                                        <option value="{{$code}}">{{ $isoCountryName.'('.$code.')' }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap zImage-upload-details mw-100">
                                    <div class="zImage-inside">
                                        <div class="d-flex pb-12"><img
                                                src="{{ asset('assets/images/icon/upload-img-1.svg')}}" alt="" />
                                        </div>
                                        <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                                    </div>
                                    <label for="zImageUpload" class="form-label">{{__('Flag')}} <span
                                            class="text-mime-type">(jpeg,png,jpg,svg,webp)</span> <span
                                            class="text-danger">*</span></label>
                                    <div class="upload-img-box">
                                        <img src="" />
                                        <input type="file" name="flag" id="flag" accept="image/*"
                                            onchange="previewFile(this)" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="attachmentFile" class="form-label">{{ __('Font File') }}</label>
                                <input type="file" class="primary-form-control" id="attachmentFile"
                                    accept="application/pdf" name="font">
                                @if ($errors->has('font'))
                                <span class="text-danger"><i class="fas fa-exclamation-triangle"></i> {{
                                    $errors->first('font') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="input__group">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label class="form-label" for="rtl">{{ __('RTL Supported') }} <span
                                                class="text-danger">*</span></label>
                                        <select name="rtl" class="sf-select-without-search">
                                            <option value="0">{{__("No")}}</option>
                                            <option value="1">{{__("Yes")}}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-12">
                            <div class="d-flex form-check">
                                <div class="zCheck form-check form-switch">
                                    <input class="form-check-input" type="checkbox" value="1" name="default"
                                        role="switch" id="flexCheckChecked" />
                                </div>
                                <label class="form-check-label ps-3" for="flexCheckChecked">
                                    {{ __('Default Language') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit"
                        class="fs-15 border-0 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one">{{
                        __('Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Add Modal section end -->

<!-- Edit Modal section start -->
<div class="modal fade" id="edit-modal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

        </div>
    </div>
</div>
<!-- Edit Modal section end -->
@endsection
@push('script')
<script src="{{asset('admin/js/languages.js')}}"></script>
@endpush
