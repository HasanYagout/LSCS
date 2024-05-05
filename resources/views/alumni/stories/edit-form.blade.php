<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<form class="ajax reset" action="{{ route('stories.update', $story->slug) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body model-lg">
        <div class="max-w-840">
            <div class="row rg-25">
                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="title" class="form-label">{{__('Title')}} <span class="text-danger">*</span></label>
                            <input type="text" class="primary-form-control" value="{{$story->title}}" id="title" name="title" placeholder="{{ __('Title') }}">
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="body" class="form-label">{{__('Description')}} <span class="text-danger">*</span></label>
                            <textarea name="body" class="primary-form-control min-h-180 summernoteOne" id="body" placeholder="{{ __('Write description...') }}" spellcheck="false">{!! $story->body !!}</textarea>
                        </div>
                    </div>
                </div>

                @if(auth()->user()->role == USER_ROLE_ADMIN)
                    <div class="col-md-12">
                        <div class="primary-form-group">
                            <div class="primary-form-group-wrap">
                                <label for="BatchName" class="form-label">{{ __('Status') }} <span
                                        class="text-danger">*</span></label>
                                <select class="primary-form-control sf-select-without-search" id="BatchName" name="status">
                                    <option {{$story->status == 1?'selected':''}} value="1">{{ __('Publish') }}</option>
                                    <option {{$story->status == 0?'selected':''}} value="0">{{ __('Pending') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="pb-4 col-md-6 ">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap zImage-upload-details">
                            <div class="zImage-inside">
                                <div class="d-flex pb-12"><img src="{{asset('assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
                                <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                            </div>
                            <label for="zImageUpload" class="form-label">{{__('Upload Image')}} <span class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
                            <div class="upload-img-box">
                                <img src="{{ getFileUrl($story->thumbnail) }}">
                                <input type="file" name="thumbnail" accept="image/*" onchange="previewFile(this)">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button type="submit" id="post"
            class="py-13 px-50 border-0 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black">{{__('Update Story')}}</button>
    </div>

</form>
