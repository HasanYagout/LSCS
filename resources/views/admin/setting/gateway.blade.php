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
            <div class="col-lg-12 col-md-12 bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <div class="table-responsive zTable-responsive">
                    <table class="table zTable">
                        <thead>
                            <tr>
                                <th><div>{{ __('SL') }}</div></th>
                                <th><div>{{ __('Image') }}</div></th>
                                <th><div>{{ __('Title') }}</div></th>
                                <th><div>{{ __('Slug') }}</div></th>
                                <th><div>{{ __('Status') }}</div></th>
                                <th><div>{{ __('Mode') }}</div></th>
                                <th><div>{{ __('Action') }}</div></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($gateways as $gateway)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <div class="">
                                        <div class="btn btn-dropdown site-language">
                                            <img src="{{ asset($gateway->image) }}" class="gateway-image" alt="">
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $gateway->title }}</td>
                                <td>{{ $gateway->slug }}</td>
                                <td>
                                    @if ($gateway->status == ACTIVE)
                                    <div class="status-btn status-btn-green font-13 radius-4">
                                        {{ __('Active') }}</div>
                                    @else
                                    <div class="status-btn status-btn-orange font-13 radius-4">
                                        {{ __('Deactive') }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if ($gateway->mode == GATEWAY_MODE_LIVE)
                                    <div class="status-btn status-btn-green font-13 radius-4">
                                        {{ __('Live') }}</div>
                                    @elseif($gateway->slug != 'bank')
                                    <div class="status-btn status-btn-orange font-13 radius-4">
                                        {{ __('Sandbox') }}</div>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class=" bg-f9f9f9 border-0 btn-action mr-1 edit"
                                        data-toggle="tooltip" title="{{__('Edit')}}" data-id="{{ $gateway->id }}">
                                        <img src="{{asset('assets/images/icon/edit.svg')}}" alt="edit">
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Page content area end -->
{{-- Modal --}}
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">{{ __('Edit Gateway') }}</h4>
                <button type="button" class="border-0 btn-close" data-bs-dismiss="modal" aria-label="Close"><span
                        class="iconify" data-icon="akar-icons:cross"></span></button>
            </div>
            <form class="ajax" action="{{ route('admin.setting.gateway.store') }}" method="POST"
                data-handler="responseOnGatewaStore">
                @csrf
                <input type="hidden" name="id" id="id" required>
                <div class="modal-body">
                    <h4 class="mb-15">{{ __('Gateway') }}</h4>
                    <div class="modal-inner-form-box bg-off-white theme-border radius-4 p-20">
                        <div class="row">
                            <div class="upload-profile-photo-box mb-25">
                                <div class="profile-user position-relative d-inline-block">
                                    <img src="" class="image" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-25">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Title') }}</label>
                                        <input type="text" class="primary-form-control title" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-25">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Slug') }}</label>
                                        <input type="text" name="slug" class="primary-form-control slug" readonly>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-25">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Status') }}</label>
                                        <select name="status" id="status"
                                            class="primary-form-control sf-select-without-search">
                                            <option value="0">{{ __('Deactive') }}</option>
                                            <option value="1">{{ __('Active') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 mb-25 mode-div">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Mode') }}</label>
                                        <select name="mode" id="mode"
                                            class="primary-form-control sf-select-without-search">
                                            <option value="1">{{ __('Live') }}</option>
                                            <option value="2">{{ __('Sandbox') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bank-div">
                            <div class="bank-div-append">

                            </div>
                            <div class="row mb-20">
                                <div class="col-12 text-end">
                                    <button type="button"
                                        class="fs-15 fw-500 lh-25 border-0 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one ml-10 border-0 green-color add-bank"
                                        title="{{ __('Add Bank') }}">
                                        <span class="iconify" data-icon="material-symbols:add"></span> {{ __('Add Bank')
                                        }}</button>
                                </div>
                            </div>
                        </div>

                        <div class="row url-div">
                            <div class="col-md-12 mb-25 gateway-input" id="gateway-url">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Url') }}
                                            /{{ __('Hash') }}</label>
                                        <input class="primary-form-control" type="text" name="url">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row key-secret-div">
                            <div class="col-md-12 mb-25 gateway-input" id="gateway-key">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Key') }}</label>
                                        <input class="primary-form-control" type="text" name="key">
                                    </div>
                                </div>
                                <small class="d-none small">{{ __('Client id, Public Key, Key, Store id, Api Key')
                                    }}</small>
                            </div>
                            <div class="col-md-12 mb-25 gateway-input" id="gateway-secret">
                                <div class="primary-form-group mt-2">
                                    <div class="primary-form-group-wrap">
                                        <label class="label-text-title color-heading font-medium mb-2 form-label">{{
                                            __('Secret') }}</label>
                                        <input class="primary-form-control" type="text" name="secret">
                                    </div>
                                </div>
                                <small class="d-none small">{{ __('Client Secret, Secret, Store Password, Auth Token')
                                    }}</small>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <label class="label-text-title color-heading font-medium mb-2">{{ __('Conversion Rate')
                                    }}
                                    <button type="button"
                                        class="add-currency bd-ra-12 bg-cdef84 border-0 edit-btn fs-15 fw-500 hover-bg-one lh-25 ml-10fs-15 text-black"><svg
                                            xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            viewBox="0 0 21 21">
                                            <path fill="none" stroke="currentColor" stroke-linecap="round"
                                                stroke-linejoin="round" d="M5.5 10.5h10m-5-5v10" />
                                        </svg></span>
                                    </button>
                                </label>
                                <div id="currencyConversionRateSection"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-start">
                    <button type="button" class="border-0 btn btn-grey" data-bs-dismiss="modal"
                        title="{{ __('Back') }}">{{ __('Back') }}</button>
                    <button type="submit"
                        class="fs-15 fw-500 lh-25 border-0 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one ml-10fs-15 fw-500 lh-25 border-0 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one ml-10"
                        title="{{ __('Submit') }}">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<input type="hidden" id="getInfoRoute" value="{{ route('admin.setting.gateway.get.info') }}">
<input type="hidden" id="getCurrencySymbol" value="{{ getCurrencySymbol() }}">
<input type="hidden" id="allCurrency" value="{{ json_encode(getCurrency()) }}">
<input type="hidden" id="gatewaySettings" value="{{ gatewaySettings() }}">
@endsection
@push('script')
    <script src="{{ asset('admin/js/gateway.js') }}"></script>
@endpush
