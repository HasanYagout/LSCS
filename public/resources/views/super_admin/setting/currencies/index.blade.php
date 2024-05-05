@extends('super_admin.layouts.app')
@push('title')
    {{ $title }}
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
            <div class="row bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
                <input type="hidden" id="currency-route" value="{{ route('super_admin.setting.currencies.index') }}">
                <div class="col-lg-12">
                    <div class="customers__area bg-style mb-30">
                        <div class="item-title d-flex flex-wrap justify-content-end">
                            <div class="mb-3">
                                <button class="border-0 fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12"
                                    type="button" data-bs-toggle="modal" data-bs-target="#add-modal">
                                    <i class="fa fa-plus"></i> {{ __('Add Currency') }}
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive zTable-responsive">
                            <table class="table zTable" id="commonDataTable">
                                <thead>
                                    <tr>
                                        <th>
                                            <div>{{ __('#SL') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Code') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Symbol') }}</div>
                                        </th>
                                        <th>
                                            <div>{{ __('Placemnent') }}</div>
                                        </th>
                                        <th>
                                            <div class="text-center">{{ __('Action') }}</div>
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
    <!-- Page content area end -->
    <!-- Add Modal section start -->
    <div class="modal fade" id="add-modal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-20 border-0 pb-0">
                    <h5 class="modal-title fs-18 fw-600 lh-24 text-1b1c17">{{ __('Add Currency') }}</h5>
                    <button type="button" class="w-30 h-30 rounded-circle bd-one bd-c-e4e6eb p-0 bg-transparent"
                        data-bs-dismiss="modal" aria-label="Close"><i class="fa-solid fa-times"></i></button>
                </div>
                <form class="ajax reset" action="{{ route('super_admin.setting.currencies.store') }}" method="post"
                    data-handler="settingCommonHandler">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="currency_code" class="form-label">{{ __('Currency ISO Code') }}
                                            <span class="text-danger">*</span></label>
                                        <select id="sf-select-currency-add" class="primary-form-control" id="currency_code"
                                            name="currency_code">
                                            @foreach (getCurrency() as $code => $currencyItem)
                                                <option value="{{ $code }}">{{ $currencyItem }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="primary-form-group mt-4">
                                <div class="primary-form-group-wrap">
                                    <label for="symbol" class="form-label">{{ __('Symbol') }} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="symbol" id="symbol"
                                        placeholder="{{ __('Type Symbol') }}" class="primary-form-control">
                                </div>
                            </div>

                            <div class=" mt-4">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="currency_placement" class="form-label">{{ __('Currency Placement') }}
                                            <span class="text-danger">*</span></label>
                                        <select class="primary-form-control sf-select-without-search" id="eventType"
                                            name="currency_placement">
                                            <option value="">--{{ __('Select Option') }}--</option>
                                            <option value="before">{{ __('Before Amount') }}</option>
                                            <option value="after">{{ __('After Amount') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="d-flex form-check ps-0">
                                    <div class="zCheck form-check form-switch">
                                        <input class="form-check-input mt-0" value="1" name="current_currency"
                                            type="checkbox" id="flexCheckChecked">
                                    </div>
                                    <label class="form-check-label ps-3 d-flex" for="flexCheckChecked">
                                        {{ __('Current Currency') }}
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-0">
                        <button type="submit"
                            class="m-0 fs-15 border-0 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12">{{ __('Save') }}</button>
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
    <script src="{{ asset('super_admin/custom-js/currencies.js') }}"></script>
@endpush
