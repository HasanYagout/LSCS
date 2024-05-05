<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Social Login (Facebook) Configuration') }}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="https://zaialumni-stg.zainikthemes.com/assets/images/icon/delete.svg" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{route('admin.setting.common.settings.update')}}" method="POST"
          enctype="multipart/form-data" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12 p-1">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Facebook Client ID') }}</label>
                        <input type="text" name="facebook_client_id" id="facebook_client_id"
                               value="{{getOption('facebook_client_id')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12 p-1 ">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Facebook Client Secret') }} </label>
                        <input type="text" name="facebook_client_secret" id="facebook_client_secret"
                               value="{{getOption('facebook_client_secret')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <label>{{ __('Set callback URL') }} : <strong>{{ url('/auth/facebook/callback') }}</strong></label>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 fw-500 lh-25 border-0 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"
                        type="submit">{{ __('Save') }}</button>
            </div>
        </div>
    </form>
</div>
