<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Social Login (Google) Configuration') }}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="{{asset('assets/images/icon/delete.svg')}}" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{route('admin.setting.common.settings.update')}}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Google Client ID') }}</label>

                        <input type="text" name="google_client_id" id="google_client_id"
                               value="{{getOption('google_client_id')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Google Client Secret') }} </label>

                        <input type="text" name="google_client_secret" id="google_client_secret"
                               value="{{getOption('google_client_secret')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label>{{ __('Set callback URL') }} : <strong>{{ url('/auth/google/callback') }}</strong></label>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 fw-500 border-0 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"
                        type="submit">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</div>
