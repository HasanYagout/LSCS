<form class="ajax reset" action="{{ route('admin.news.update', $news->id) }}" method="post"
    data-handler="commonResponseForModal">
    @csrf
    <div class="modal-body zModalTwo-body model-lg">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center pb-30">
            <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Update New')}}</h4>
            <div class="mClose">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                        src="{{asset('assets/images/icon/delete.svg')}}" alt="" /></button>
            </div>
        </div>
        <div class="row rg-25">
            <div class="col-md-6">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Title') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" value="{{ $news->title }}" name="title"
                            placeholder="{{ __('Title') }}">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="BatchName" class="form-label">{{ __('Category') }} <span class="text-danger">
                                *</span> </label>
                        <select class="primary-form-control sf-select-without-search" id="category_id"
                            name="category_id">
                            @foreach ($categories as $category)
                            <option {{$news->news_category_id == $category->id ?'selected':''}} value="{{ $category->id
                                }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                      <label for="BatchName" class="form-label">{{ __('Tag') }} <span class="text-danger">*</span></label>
                      <select name="tag_ids[]" id="tag_ids" multiple class="tag_ids primary-form-control sf-select-edit-modal">
                        @foreach ($tags as $tag)
                            <option {{ in_array($tag->id, $oldTags) ? 'selected' : '' }} value="{{ $tag->id }}">{{ $tag->name }}</option>
                        @endforeach
                    </select>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="BatchName" class="form-label">{{ __('Status') }} <span
                                class="text-danger">*</span></label>
                        <select class="primary-form-control sf-select-without-search" id="BatchName" name="status">
                            <option {{$news->status == 1?'selected':''}} value="1">{{ __('Publish') }}</option>
                            <option {{$news->status != 1?'selected':''}} value="0">{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventDescription" class="form-label">{{__('Description')}}</label>
                    <textarea name="details" class="primary-form-control min-h-180 summernoteOne" id="eventDescription" placeholder="{{ __('Write description...') }}" spellcheck="false">{{ $news->details}}</textarea>
                  </div>
                </div>
            </div>

            <div class="primary-form-group">
                <div class="primary-form-group-wrap zImage-upload-details">
                    <div class="zImage-inside">
                    <div class="d-flex pb-12"><img src="{{ asset('assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
                    <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                    </div>
                    <label for="zImageUpload" class="form-label">{{__('Upload Image')}} <span
                            class="text-mime-type">(jpg,jpeg,png)</span></label>
                    <div class="upload-img-box">
                        <img src="{{ getFileUrl($news->image) }}">
                        <input type="file" name="image" accept="image/*" onchange="previewFile(this)">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit"
            class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Save')
            }}</button>
    </div>
</form>
