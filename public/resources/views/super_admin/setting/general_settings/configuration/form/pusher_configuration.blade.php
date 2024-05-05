<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('Pusher Configuration') }}</h2>
        <div class="mClose">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                    src="http://localhost:8000/assets/images/icon/delete.svg" alt=""></button>
        </div>
    </div>
    <form class="ajax" action="{{route('super_admin.setting.settings_env.update')}}" method="post"
          class="form-horizontal" data-handler="commonResponseForModal">
        @csrf
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Pusher App Id') }}</label>
                        <input type="text" name="pusher_app_id" id="pusher_app_id"
                               value="{{getOption('pusher_app_id')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Pusher App Key') }} </label>
                        <input type="text" name="pusher_app_key"
                               id="pusher_app_key"
                               value="{{getOption('pusher_app_key')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Pusher App Secret') }} </label>
                        <input type="text" name="pusher_app_secret"
                               id="pusher_app_secret"
                               value="{{getOption('pusher_app_secret')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-black row mb-3">
            <div class="col-lg-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label class="form-label">{{ __('Pusher Cluster') }} </label>
                        <input type="text" name="pusher_cluster"
                               id="pusher_cluster"
                               value="{{getOption('pusher_cluster')}}" class="primary-form-control">
                    </div>
                </div>
            </div>
        </div>
        <div class="justify-content-end row text-end">
            <div class="col-md-12">
                <button type="submit"
                        class="fs-15 fw-500 border-0 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one float-right">{{__('Update')}}</button>
            </div>
        </div>
    </form>
</div>
