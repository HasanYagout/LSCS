<form data-handler="commonResponseForModal" class="ajax reset" action="{{ route('admin.event.update', $event->slug) }}"
    method="post" enctype="multipart/form-data">
    @csrf
    <div class="max-w-840 px-5 mx-3">
        <div class="modal-body zModalTwo-body model-lg">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center pb-30">
                <h4 class="fs-20 fw-500 lh-38 text-1b1c17">{{__('Update New')}}</h4>
                <div class="mClose">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><img
                            src="{{asset('public/assets/images/icon/delete.svg')}}" alt="" /></button>
                </div>
            </div>
            <div class="row rg-25">
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="eventTitle" class="form-label">{{__('Event Title')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" class="primary-form-control" value="{{$event->title}}" id="eventTitle"
                                name="title" placeholder="{{ __('Title') }}">
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="eventDate" class="form-label">{{__('Date')}} <span
                                    class="text-danger">*</span></label>
                            <input type="text" name="date" id="eventDate" value="{{$event->date}}"
                                class="date-time-picker primary-form-control" />
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="eventCategory" class="form-label">{{__('Event Category')}} <span
                                    class="text-danger">*</span></label>
                            <select class="primary-form-control sf-select-without-search" name="event_category_id"
                                id="event_category_id">
                                <option selected="">{{__('Select Event')}}</option>
                                @foreach ($categories as $category)
                                <option {{$event->event_category_id == $category->id ?'selected':''}} value="{{
                                    $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>


                @if(auth('admin')->user()->role_id == USER_ROLE_ADMIN)
                <div class="col-md-6">
                    <div class="primary-form-group">
                        <div class="primary-form-group-wrap">
                            <label for="BatchName" class="form-label">{{ __('Status') }} <span
                                    class="text-danger">*</span></label>
                            <select class="primary-form-control sf-select-without-search" id="BatchName" name="status">
                                <option {{$event->status == 1?'selected':''}} value="1">{{ __('Publish') }}</option>
                                <option {{$event->status == 0?'selected':''}} value="0">{{ __('Pending') }}</option>
                            </select>
                        </div>
                    </div>
                </div>
                @endif


      <div class="col-12">
        <div class="primary-form-group">
          <div class="primary-form-group-wrap">
            <label for="eventDescription" class="form-label">{{__('Description')}} <span class="text-danger">*</span></label>
            <textarea name="description" class="summernoteOne primary-form-control min-h-180" id="eventDescription" placeholder="{{ __('Write description...') }}" spellcheck="false">{{ $event->description }}</textarea>
          </div>
        </div>
      </div>

    <div class="pb-4 col-md-6">
        <div class="primary-form-group">
          <div class="primary-form-group-wrap zImage-upload-details">
            <div class="zImage-inside">
              <div class="d-flex pb-12"><img src="{{ asset('public/assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
              <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
            </div>
            <label for="zImageUpload" class="form-label">{{__('Upload Image')}} <span
              class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
            <div class="upload-img-box">
              <img src="{{ asset('public/storage/admin/events'.'/'.$event->thumbnail) }}">
                <input type="file" name="thumbnail" accept="image/*" onchange="previewFile(this)">
            </div>
          </div>
        </div>
    </div>

            </div>
            <div class="modal-footer mt-4">
                <button type="submit"
                    class="d-inline-flex py-13 px-26 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black hover-bg-one border-0">{{__('Update
                    Now')}}</button>
            </div>

        </div>
</form>
