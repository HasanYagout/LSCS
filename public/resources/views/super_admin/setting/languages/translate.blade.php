@extends('super_admin.layouts.app')
@push('super_admin-style')
@endpush
@section('content')
    <div class="p-30">
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{ __($title) }}</h4>
            <div class="row bd-c-ebedf0 bd-half bd-ra-25 bg-white h-100 p-30">
                <input type="hidden" id="language-route" value="{{ route('super_admin.setting.languages.index') }}">
                <div class="col-lg-12">
                    <div class="d-flex flex-wrap gap-2 item-title justify-content-between mb-20">
                        <button type="button" class="border-0 fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12"
                            data-bs-toggle="modal" data-bs-target="#importModal" title="Import Keywords">
                            {{ __('Import Keywords') }}
                        </button>
                        <button type="button"
                            class="fs-15 fw-500 lh-25 py-10 px-26 border-0 bg-7f56d9 bd-ra-12 addmore">
                            <i class="fa fa-plus"></i>
                            {{ __('Add More') }}
                        </button>
                    </div>
                    <div class="table-responsive zTable-responsive">
                        <table class="table zTable">
                            <thead>
                                <tr>
                                <tr>
                                    <th class="min-w-160">
                                        <div>{{ __('Key') }}</div>
                                    </th>
                                    <th class="min-w-160">
                                        <div>{{ __('Value') }}</div>
                                    </th>
                                    <th class="text-center w-28">
                                        <div>{{ __('Action') }}</div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="append">
                                @foreach ($translators as $key => $value)
                                    <tr>
                                        <td>
                                            <textarea type="text" class="key form-control" readonly required>{!! $key !!}</textarea>
                                        </td>
                                        <td>
                                            <input type="hidden" value="0" class="is_new">
                                            <textarea type="text" class="val form-control" required>{!! $value !!}</textarea>
                                        </td>
                                        <td class="text-end">
                                            <button type="button"
                                                class="border-0 updateLangItem fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12">{{ __('Update') }}</button>
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
    <!-- Add Modal section start -->
    <div class="modal fade" id="importModal" aria-hidden="true" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form class="ajax" action="{{ route('super_admin.setting.languages.import') }}" method="POST"
                    data-handler="languageHandler">
                    @csrf
                    <input type="hidden" name="current" value="{{ $language->iso_code }}">
                    <div class="modal-header p-20 border-0 pb-0">
                        <h5 class="modal-title fs-18 fw-600 lh-24 text-1b1c17">{{ __('Import Language') }}</h5>
                        <button type="button" class="w-30 h-30 rounded-circle bd-one bd-c-e4e6eb p-0 bg-transparent"
                            data-bs-dismiss="modal" aria-label="Close">
                            <i class="fa-solid fa-times"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-inner-form-box">
                            <div class="row">
                                <div class="mb-30">
                                    <span
                                        class="text-danger text-center">{{ __('Note: If you import keywords, your current keywords will be deleted and replaced by the imported keywords.') }}</span>
                                </div>
                                <div class="col-md-12">
                                    <label for="status" class="label-text-title color-heading font-medium mb-2">
                                        {{ __('Language') }} </label>
                                    <select name="import" class="sf-select flex-shrink-0 export" id="inputGroupSelect02">
                                        <option value=""> {{ __('Select Option') }} </option>
                                        @foreach ($languages as $lang)
                                            <option value="{{ $lang->iso_code }}">{{ __($lang->language) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-start border-0 pt-0">
                        <button type="button"
                            class="border-0 updateLangItem fs-15 fw-500 lh-25 text-black py-10 px-26 bg-e4e6eb hover-bg-three hover-color-white bd-ra-12"
                            data-bs-dismiss="modal" title="Back">{{ __('Back') }}</button>
                        <button type="submit"
                            class="border-0 updateLangItem fs-15 fw-500 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12"
                            title="Submit">{{ __('Import') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <input type="hidden" id="updateLangItemRoute"
        value="{{ route('super_admin.setting.languages.update.translate', [$language->id]) }}">
@endsection

@push('script')
    <script src="{{ asset('super_admin/custom-js/languages.js') }}"></script>
@endpush
