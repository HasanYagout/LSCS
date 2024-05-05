<div class="customers__area mb-30">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{__('Google analytics configuration')}}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="{{asset('assets/images/icon/delete.svg')}}" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post" class="form-horizontal"
          data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Google Analytics Tracking Id') }} </label>
                        <input type="text" min="0" max="100" step="any" name="google_analytics_tracking_id"
                               value="{{getOption('google_analytics_tracking_id')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 fw-500 border-0 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"
                        type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>
