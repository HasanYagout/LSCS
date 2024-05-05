<div class="modal-header">
    <h5 class="modal-title">{{ __('Update Passing Year') }}</h5>
    <button type="button" class="border-0 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.passing_years.update', $passingYear->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    @method('PATCH')
    <div class="modal-body">
        <div class="row">
            <div class="col-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                      <label for="passing_year" class="form-label">{{ __('Passing Year') }}<span class="text-danger">*</span></label>
                      <input type="text" class="primary-form-control" name="passing_year" value="{{ $passingYear->name }}" required>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 bd-ra-12 hover-bg-one border-0">{{ __('Update') }}</button>
    </div>
</form>
