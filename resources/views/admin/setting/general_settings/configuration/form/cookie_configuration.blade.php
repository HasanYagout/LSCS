<div class="customers__area mb-30">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{__('Cookie Configuration')}}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="{{asset('assets/images/icon/delete.svg')}}" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{ route('admin.setting.common.settings.update') }}" method="post"
          class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-12 mb-4">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{__('Cookie Consent Text')}} </label>
                        <textarea class="primary-form-control" name="cookie_consent_text" cols="30"
                                  rows="10">{{getOption('cookie_consent_text')}}</textarea>
                    </div>
                </div>

            </div>
        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 border-0 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"
                        type="submit">{{ __('Update') }}</button>
            </div>
        </div>
    </form>
</div>
