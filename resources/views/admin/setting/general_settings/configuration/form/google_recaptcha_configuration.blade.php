<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Google Recaptcha Credentials') }}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="{{asset('assets/images/icon/delete.svg')}}" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{route('admin.setting.common.settings.update')}}" method="post" class="form-horizontal"
          data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Google Recaptcha Site Key') }}</label>
                        <input type="text" name="google_recaptcha_site_key" id="google_recaptcha_site_key"
                               value="{{getOption('google_recaptcha_site_key')}}" class="primary-form-control">
                    </div>
                </div>

            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Google Recaptcha Secret Key') }} </label>
                        <input type="text" name="google_recaptcha_secret_key"
                               id="google_recaptcha_secret_key"
                               value="{{getOption('google_recaptcha_secret_key')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="justify-content-end row text-end">
            <div class="col-md-12">
                <button type="submit"
                        class="fs-15 border-0 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one float-right">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
