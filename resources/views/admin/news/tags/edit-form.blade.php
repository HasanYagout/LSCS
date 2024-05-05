<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.news.tags.update', $newsTag->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body">
        <div class="row">
            <div class="primary-form-group mt-2">
                <div class="primary-form-group-wrap">
                  <label for="currentPassword" class="form-label">{{ __('Name') }} <span class="text-danger">*</span></label>
                  <input type="text" class="primary-form-control" name="name" placeholder="{{ __('name') }}" value="{{$newsTag->name}}">
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Update') }}</button>
    </div>
</form>
