<div class="email-inbox__area">
    <div class="item-top mb-30 d-flex flex-wrap justify-content-between">
        <h2>{{ __('SMS Configuration') }}</h2>

        <a href="javascript:void(0);" id="sendTestSMSBtn"
           class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"> <i
                class="fa fa-envelope"></i> {{ __('Send Test SMS') }} </a>
    </div>
    <form class="ajax reset" action="{{route('admin.setting.sms-configuration')}}" method="POST" enctype="multipart/form-data"
          data-handler="commonResponseForModal">
        @csrf
        <div class="row">
            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{__('TWILIO ACCOUNT SID')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="TWILIO_ACCOUNT_SID" value="{{getOption('TWILIO_ACCOUNT_SID')}}"
                                   class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{__('TWILIO AUTH TOKEN')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="TWILIO_AUTH_TOKEN" value="{{getOption('TWILIO_AUTH_TOKEN')}}"
                                   class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-4 mb-3">
                <div class="form-group text-black">
                    <div class="primary-form-group mt-2">
                        <div class="primary-form-group-wrap">
                            <label class="form-label">{{__('TWILIO PHONE NUMBER')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="TWILIO_PHONE_NUMBER" value="{{getOption('TWILIO_PHONE_NUMBER')}}"
                                   class="primary-form-control">
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="row mb-3">
            <div class="col-md-12 text-end">
                <button class="fs-15 fw-500 lh-25 border-0 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one"
                        type="submit">{{ __('Update') }}</button>
            </div>
        </div>

    </form>
</div>
