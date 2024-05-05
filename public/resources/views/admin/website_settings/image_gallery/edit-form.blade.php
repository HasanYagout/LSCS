<div class="modal-header">
    <h5 class="modal-title">{{ __('Update Currency') }}</h5>
    <button type="button" class="border-0 btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<form class="ajax reset" action="{{ route('admin.setting.website-settings.image_galleries.update', $gallery->id) }}" method="post"
      data-handler="commonResponseForModal">
    @csrf
    @method('PATCH')
    <div class="modal-body">
        <div class="row rg-25">
            <div class="col-12">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="caption" class="form-label">{{ __('Caption') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" value="{{$gallery->caption}}" name="caption" id="caption" required
                               placeholder="{{ __('Caption') }}">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="mw-100 primary-form-group-wrap zImage-upload-details">
                        <div class="zImage-inside">
                            <div class="d-flex pb-12"><img src="{{ asset('assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
                            <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                        </div>
                        <label for="zImageUpload" class="form-label">{{__('Upload Photo')}} <span
                                class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
                        <div class="upload-img-box">
                            <img src="{{getFileUrl($gallery->photo)}}">
                            <input type="file" name="photo" accept="image/*" onchange="previewFile(this)">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="status" class="form-label">{{ __('Status') }} <span
                                class="text-danger">*</span></label>
                        <select class="primary-form-control sf-select-without-search" id="status" name="status">
                            <option {{$gallery->status == 1?'selected':''}} value="1">{{ __('Publish') }}</option>
                            <option {{$gallery->status != 1?'selected':''}} value="0">{{ __('Unpublished') }}</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit"
                class="fs-15 fw-500 lh-25 text-black py-10 px-26 bg-cdef84 border-0 bd-ra-12 hover-bg-one">{{ __('Update') }}</button>
    </div>
</form>
