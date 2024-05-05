<div class="modal-header p-20 border-0 pb-0">
    <h5 class="modal-title fs-18 fw-600 lh-24 text-1b1c17">{{ __('Update Currency') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle bd-one bd-c-e4e6eb p-0 bg-transparent" data-bs-dismiss="modal"
        aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax reset" action="{{ route('super_admin.setting.currencies.update', $currency->id) }}" method="post"
    data-handler="settingCommonHandler">
    @csrf
    @method('PATCH')
    <div class="modal-body">
        <div class="row rg-15">
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="currency_code" class="form-label">{{ __('Currency ISO Code') }} <span
                                class="text-danger">*</span></label>
                        <select class="sf-select-edit-modal primary-form-control" id="currency_code"
                            name="currency_code">
                            @foreach (getCurrency() as $code => $currencyItem)
                                <option value="{{ $code }}"
                                    {{ $code == $currency->currency_code ? 'selected' : '' }}>{{ $currencyItem }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="symbol" class="form-label">{{ __('Symbol') }}<span
                                class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="symbol" placeholder="Type symbol"
                            value="{{ $currency->symbol }}" required>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="currency_placement" class="form-label">{{ __('Currency Placement') }}<span
                                class="text-danger">*</span></label>
                        <select class="sf-select-without-search primary-form-control" name="currency_placement">
                            <option value="">--{{ __('Select Option') }}--</option>
                            <option {{ $currency->currency_placement == 'before' ? 'selected' : '' }} value="before">
                                {{ __('Before Amount') }}</option>
                            <option {{ $currency->currency_placement == 'after' ? 'selected' : '' }} value="after">
                                {{ __('After Amount') }}</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12 mt-4">
                <div class="d-flex form-check ps-0">
                    <div class="zCheck form-switch">
                        <input class="form-check-input mt-0" value="1" name="current_currency"
                            {{ $currency->current_currency == STATUS_ACTIVE ? 'checked' : '' }} type="checkbox"
                            id="flexCheckChecked--{{ $currency->id }}">
                    </div>
                    <label class="form-check-label ps-3 d-flex" for="flexCheckChecked-{{ $currency->id }}">
                        {{ __('Current Currency') }}
                    </label>
                </div>
            </div>

        </div>
    </div>
    <div class="modal-footer border-0 pt-0">
        <button type="submit"
            class="m-0 fs-15 fw-500 lh-25 border-0 py-10 px-26 bg-7f56d9 bd-ra-12">{{ __('Update') }}</button>
    </div>
</form>
