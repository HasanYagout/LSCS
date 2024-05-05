<form class="ajax reset" action="{{ route('admin.membership.update', $membership->slug) }}" method="post"
    data-handler="commonResponseForModal" enctype="multipart/form-data">
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
        <div class="row">
            <div class="col-md-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="currentPassword" class="form-label">{{ __('Title') }} <span
                                class="text-danger">*</span></label>
                        <input type="text" class="primary-form-control" name="title" value="{{$membership->title}}">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="primary-form-group mt-2">
                    <div class="primary-form-group-wrap">
                        <label for="eventType" class="form-label">{{__('Duration Type')}} <span
                                class="text-danger">*</span></label>
                        <select class="primary-form-control sf-select-without-search" id="eventType"
                            name="duration_type">
                            @foreach(getDurationType() as $index => $type)
                            <option {{$membership->duration_type == $index ?'selected':''}} value="{{$index}}"> {{ $type
                                }}</option>
                            @endforeach
                        </select>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group mt-4">
                        <div class="primary-form-group-wrap">
                            <label for="currentPassword" class="form-label">{{ __('Duration Time') }} <span class="text-danger">*</span></label>
                            <input type="number" class="primary-form-control" name="duration" value="{{$membership->duration}}">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="primary-form-group mt-4">
                        <div class="primary-form-group-wrap">
                            <label for="currentPassword" class="form-label">{{ __('Price') }} <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="primary-form-control" name="price" value="{{$membership->price}}">
                        </div>
                    </div>
                </div>

            <div class="col-md-6">
                <div class="primary-form-group mt-4">
                    <div class="primary-form-group-wrap">
                        <label for="BatchName" class="form-label">{{ __('Status') }} <span
                                class="text-danger">*</span></label>
                        <select class="primary-form-control sf-select-without-search" id="BatchName" name="status">
                            <option {{$membership->status == 1?'selected':''}} value="1">{{ __('Active') }}</option>
                            <option {{$membership->status == 0?'selected':''}} value="0">{{ __('Deactive') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-12 mt-4">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap zImage-upload-details w-100">
                        <div class="zImage-inside">
                            <div class="d-flex pb-12"><img src="{{ getDefaultImage() }}"></div>
                            <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                        </div>
                        <label for="zImageUpload" class="form-label">{{__('Upload Image')}} <span
                                class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
                        <div class="upload-img-box">
                            <img src="{{ getFileUrl($membership->badge)}}">
                            <input type="file" name="badge" accept="image/*" onchange="previewFile(this)">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit"
            class="py-10 px-26 bg-cdef84 border-0 bd-ra-12 fs-15 fw-500 lh-25 text-black hover-bg-one">{{ __('Update')
            }}</button>
    </div>
</form>
