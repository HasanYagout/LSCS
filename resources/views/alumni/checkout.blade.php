@extends('layouts.app')
@push('title')
{{ __('Chcekout') }}
@endpush
@section('content')
<div class="p-30">
    <div class="">
        <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __('Proceed Payment') }}</h4>
        <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
            <form action="{{ route('pay', $slug) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="type" value="{{ $type }}">
                <input type="hidden" name="id" value="{{ $id }}">
                <input type="hidden" id="selectGateway" name="gateway">
                <input type="hidden" id="selectCurrency" name="currency">
                <div class="row rg-30">
                    <div class="col-md-6">
                        <div class="rg-25 row">
                            <div class="col-md-12">
                                <div class="bd-one bd-c-eef0f2 bd-ra-20">
                                    <div
                                        class="py-22 px-25 bd-b-one bd-c-eef0f2 bg-f9f9f9 d-flex justify-content-between align-items-center max-h-69">
                                        <h4 class="fs-20 fw-500 lh-24 text-1b1c17">{{ __('Payment') }}</h4>
                                    </div>
                                    <div class="py-22 px-25">
                                        <div class="primary-form-group">
                                            <div class="primary-form-group-wrap">
                                                <label for="currencyAmount" class="form-label bg-body-tertiary">{{ __('Amount') }} ({{ currentCurrency('currency_code') }})</label>
                                                <input type="text" class="primary-form-control bg-body-tertiary" id="currencyAmount" readonly value="{{ $price }}"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pb-22 px-25">
                                        <ul class="zList-three" id="currencyAppend">

                                        </ul>
                                    </div>
                                    <div class="row d-none" id="bankDetails">
                                        <div class="col-12">
                                            <div class="invoice-payment-card-box bg-white radius-4 theme-border mb-25">
                                                <div
                                                    class="align-items-center border-bottom d-flex justify-content-between px-25 py-10">
                                                    <h4>{{ __('Bank Deposit') }}</h4>
                                                </div>
                                                <div class="p-20 pb-0">
                                                    <div class="rg-25 row">
                                                        <div class="col-md-12">
                                                            <div class="primary-form-group">
                                                                <div class="primary-form-group-wrap">
                                                                    <label for="bank_id" class="form-label">{{ __("Bank Name") }} <span class="text-danger">*</span></label>
                                                                    <select name="bank_id" class="primary-form-control form-select" id="bank_id">
                                                                        <option value="">--{{ __('Bank') }}--
                                                                        </option>
                                                                        @foreach ($banks as $bank)
                                                                            <option value="{{ $bank->id }}"
                                                                                data-details="{{ $bank->details }}">
                                                                                {{ $bank->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12 d-none" id="bankDetails">
                                                            <p class="my-2 ps-2"></p>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="primary-form-group">
                                                                <div class="primary-form-group-wrap">
                                                                    <label for="bank_slip" class="form-label">{{ __('Attachment') }} <span class="text-danger">*</span></label>
                                                                    <input type="file" name="bank_slip" class="primary-form-control" id="bank_slip" placeholder="__('Deposit slip')" />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($type == 'membership')
                            <div class="col-md-12">
                                <div class="bd-one bd-c-eef0f2 bd-ra-20 overflow-hidden">
                                    <div
                                        class="py-22 px-25 bd-b-one bd-c-eef0f2 bg-f9f9f9 d-flex justify-content-between align-items-center max-h-69">
                                        <h4 class="fs-20 fw-500 lh-24 text-1b1c17">{{ __('Details') }}</h4>
                                    </div>
                                    <div class="membership-plan bd-c-ededed bd-ra-12 p-20">
                                        <div class="pb-20">
                                        <div class="max-w-60 mb-10"><img src="{{ asset(getFileUrl($membership->badge)) }}" alt=""></div>
                                        <h4 class="fs-18 fw-500 lh-18 text-black pb-10">{{ $membership->title }}</h4>
                                        <p class="fs-14 fw-500 lh-14 text-707070"><span class="fs-32 fw-600 lh-32 text-1b1c17">${{$membership->price}}</span>/{{$membership->duration}} {{getDurationType($membership->duration_type)}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                            <div class="col-md-12">
                                <div class="bd-one bd-c-eef0f2 bd-ra-20 overflow-hidden">
                                    <div
                                        class="py-22 px-25 bd-b-one bd-c-eef0f2 bg-f9f9f9 d-flex justify-content-between align-items-center max-h-69">
                                        <h4 class="fs-20 fw-500 lh-24 text-1b1c17">{{ __('Details') }}</h4>
                                    </div>
                                    <div class="border-0 border-top rounded-top-0 zNews-item-one">
                                        <div><img class="w-100" src="{{ asset(getFileUrl($event->thumbnail)) }}" alt="{{ $event->title }}"></div>
                                        <div class="content">
                                            <p class="date"></p>
                                            <h4 class="title">{{ $event->title }}</h4>
                                            <p class="info">{{ getSubText($event->description, 100) }}</p>
                                            <a href="{{ route('event.details', $event->slug) }}" target="__blank" class="link">{{ __('More Details') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="bd-one bd-c-eef0f2 bd-ra-20 overflow-hidden">
                            <div
                                class="py-22 px-25 bd-b-one bd-c-eef0f2 bg-f9f9f9 d-flex justify-content-between align-items-center max-h-69">
                                <h4 class="fs-20 fw-500 lh-24 text-1b1c17">{{ __('Select Payment Method') }}</h4>
                                <div class="d-flex"><img src="{{ asset('assets/images/icon/home.svg')}}" alt="" /></div>
                            </div>
                            <div class="p-25">
                                <div class="mb-30">
                                    <div class="p-14 bg-fafafa bd-ra-20">
                                        <ul class="zList-three">
                                            @foreach ($gateways as $gateway)
                                            <li>
                                                <button type="button"  data-gateway="{{ $gateway->slug }}" class="paymentItem paymentItem-btn">
                                                  <div class="d-flex align-items-center cg-10">
                                                    <input required value="{{ $gateway->id }}" class="paymentItem-input form-check-input" {{ $loop->first ? 'checked' : '' }} type="radio" id="payMethod-{{ $gateway->slug }}" name="payMethodRadio">
                                                    <label for="payMethod-{{ $gateway->slug }}">{{ $gateway->title }}</label>
                                                  </div>
                                                  <div class="d-flex"><img src="{{ $gateway->icon }}" alt="{{ $gateway->title }}"></div>
                                                </button>
                                              </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                                <button type="submit" class="w-100 d-flex justify-content-center align-items-center p-13 border-0 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-1b1c17">{{ __("Checkout") }}</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<input type="hidden" id="amount" value="{{ $price }}">
<input type="hidden" id="getCurrencyByGatewayRoute" value="{{ route('get.currency') }}">
@endsection

@push('script')
<script src="{{ asset('alumni/js/checkout.js') }}"></script>
@endpush
