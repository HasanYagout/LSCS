<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="border-0 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>



<form class="ajax reset" action="{{ route('super_admin.setting.email-temp-update', $template->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body model-lg">
        <div class="row">
            <div class="col-md-12 mb-25">
                <p class="alert-success p-20">{{__("Email Template Fields")}} : @foreach(emailTempFields() as $key=>$item) {{$key}} @endforeach</p>
            </div>

            <div class="col-md-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="subject" class="form-label">{{ __('Subject') }}<span class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="subject" value="{{ $template->subject }}"  placeholder="{{ __('Subject') }}" required>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mb-25  m-t-2">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap mt-3">
                    <label for="body" class="form-label">{{__('Body')}} <span class="text-danger">*</span></label>
                    <textarea class="summernoteOne" name="body" id="body" placeholder="Body">{!! $template->body !!}</textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one border-0">{{ __('Save') }}</button>
    </div>
</form>
