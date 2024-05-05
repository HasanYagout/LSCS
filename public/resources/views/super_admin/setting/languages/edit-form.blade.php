<div class="modal-header p-20 border-0 pb-0">
    <h5 class="modal-title fs-18 fw-600 lh-24 text-1b1c17">{{ __('Update Language') }}</h5>
    <button type="button" class="w-30 h-30 rounded-circle bd-one bd-c-e4e6eb p-0 bg-transparent" data-bs-dismiss="modal"
        aria-label="Close"><i class="fa-solid fa-times"></i></button>
</div>
<form class="ajax reset" action="{{ route('super_admin.setting.languages.update', $language->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <div class="row rg-10">
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Language') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="language"
                            value="{{ $language->language }}" required placeholder="{{ __('Type Language Name') }}">
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="iso_code" class="form-label">{{ __('ISO Code') }} <span
                                class="text-danger">*</span></label>
                        <select name="iso_code" class="sf-select-edit-modal primary-form-control">
                            <option value="">--{{ __('Select ISO Code') }}--</option>
                            @foreach (languageIsoCode() as $code => $isoCountryName)
                                <option value="{{ $code }}"
                                    {{ $code == $language->iso_code ? 'selected' : '' }}>
                                    {{ $isoCountryName . '-' . $code }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap zImage-upload-details mw-100">
                        <div class="zImage-inside">
                            <div class="d-flex pb-12"><img src="{{ asset('assets/images/icon/upload-img-1.svg') }}"
                                    alt="" /></div>
                            <p class="fs-15 fw-500 lh-16 text-1b1c17">{{ __('Drag & drop files here') }}</p>
                        </div>
                        <label for="zImageUpload" class="form-label">{{ __('Flag') }} <span
                                class="text-mime-type">(jpeg,png,jpg,svg,webp)</span> <span
                                class="text-danger">*</span></label>
                        <div class="upload-img-box">
                            <img src="{{ getFileUrl($language->flag_id) }}" />
                            <input type="file" name="flag" id="flag" accept="image/*"
                                onchange="previewFile(this)" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="primary-form-group">
                <div class="primary-form-group-wrap">
                    <label for="attachmentFile" class="form-label">{{ __('Font File') }}
                        @if ($language->font)
                            <a href="{{ getFileUrl($language->font) }}"
                                class="position-absolute top-0 start-100 bg-cdef84 badge border border-light rounded-circle bg-danger p-2"
                                target="_blank">
                                <span class="visually-hidden"></span>
                            </a>
                        @endif
                    </label>
                    <input type="file" class="primary-form-control" id="attachmentFile" accept="application/pdf"
                        name="font">
                    @if ($errors->has('font'))
                        <span class="text-danger"><i class="fas fa-exclamation-triangle"></i>
                            {{ $errors->first('font') }}</span>
                    @endif

                </div>
            </div>
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="rtl" class="form-label">{{ __('RTL Supported') }}</label>
                        <select class="sf-select-without-search" name="rtl" required>
                            <option {{ $language->rtl == 0 ? 'selected' : '' }} value="0">{{ __('No') }}
                            </option>
                            <option {{ $language->rtl == 1 ? 'selected' : '' }} value="1">{{ __('Yes') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="d-flex form-check ps-0">
                    <div class="zCheck form-check form-switch">
                        <input class="form-check-input" type="checkbox" value="1" name="default"
                            {{ $language->default == STATUS_ACTIVE ? 'checked' : '' }} role="switch"
                            id="flexSwitchCheckChecked-{{ $language->id }}" />
                    </div>
                    <label class="form-check-label ps-3" for="flexCheckChecked-{{ $language->id }}">
                        {{ __('Default Language') }}
                    </label>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer border-0 pt-0">
        <button type="submit"
            class="m-0 fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12 border-0">{{ __('Update') }}</button>
    </div>
</form>
