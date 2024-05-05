<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Mail Configuration') }}</h2>
        <a href="javascript:void(0);" id="sendTestMailBtn"
            class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-7f56d9 bd-ra-12"> <i
                class="fa fa-envelope"></i> {{ __('Send Test Mail') }}
        </a>
    </div>

    <form class="ajax" action="{{ route('super_admin.setting.settings_env.update') }}" method="POST"
        enctype="multipart/form-data" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL MAILER') }} <span class="text-danger">*</span></label>
                            <input type="text" name="MAIL_MAILER" value="{{ env('MAIL_MAILER') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL HOST') }} <span class="text-danger">*</span></label>
                            <input type="text" name="MAIL_HOST" value="{{ env('MAIL_HOST') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL PORT') }} <span class="text-danger">*</span></label>
                            <input type="text" name="MAIL_PORT" value="{{ env('MAIL_PORT') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL USERNAME') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="MAIL_USERNAME" value="{{ env('MAIL_USERNAME') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL PASSWORD') }} <span
                                    class="text-danger">*</span></label>
                            <input type="password" name="MAIL_PASSWORD" value="{{ env('MAIL_PASSWORD') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="primary-form-group my-2">
                    <div class="primary-form-group-wrap">
                        <label for="MAIL_ENCRYPTION" class="form-label">{{ __('MAIL ENCRYPTION') }}<span
                                class="text-danger">*</span></label>
                        <select name="MAIL_ENCRYPTION" class="primary-form-control sf-select-edit-modal">
                            <option value="tls" {{ env('MAIL_ENCRYPTION') == 'tls' ? 'selected' : '' }}>
                                {{ __('tls') }}
                            </option>
                            <option value="ssl" {{ env('MAIL_ENCRYPTION') == 'ssl' ? 'selected' : '' }}>
                                {{ __('ssl') }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL FROM ADDRESS') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="MAIL_FROM_ADDRESS" value="{{ env('MAIL_FROM_ADDRESS') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{ __('MAIL FROM NAME') }} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="MAIL_FROM_NAME" value="{{ env('MAIL_FROM_NAME') }}"
                                class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 fw-500 border-0 lh-25 py-10 px-26 bg-7f56d9 bd-ra-12"
                    type="submit">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</div>
