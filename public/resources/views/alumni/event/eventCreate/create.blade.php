@extends('layouts.app')
@push('title')
    {{$title}}
@endpush

@section('content')
<div class="p-30">
    <div class="">
      <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
      <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
        <form class="ajax reset" data-handler="commonResponseRedirect" data-redirect-url="{{route('event.my-event')}}" action="{{ route('event.store') }}" method="post" enctype="multipart/form-data" >
            @csrf
          <div class="max-w-840">
            <div class="pb-30"></div>
            <div class="row rg-25">
              <div class="col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventTitle" class="form-label">{{__('Event Title')}} <span class="text-danger">*</span></label>
                    <input type="text" class="primary-form-control" id="eventTitle" name="title" placeholder="{{ __('Title') }}">
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventDate" class="form-label">{{__('Date')}} <span class="text-danger">*</span></label>
                    <input type="text" name="date" id="eventDate" class="date-time-picker primary-form-control" />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventCategory" class="form-label">{{__('Event Category')}} <span class="text-danger">*</span></label>
                    <select class="primary-form-control sf-select-without-search" name="event_category_id" id="event_category_id">
                        <option selected="">{{__('Select Event')}}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventType" class="form-label">{{__('Event Type')}} <span class="text-danger">*</span></label>
                    <select class="primary-form-control sf-select-without-search" id="eventType" name="type">
                      @foreach(eventType() as $index => $type)
                        <option value="{{$index}}"> {{ $type }}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventTicket" class="form-label">{{__('Number of Ticket')}} <span class="text-danger">*</span></label>
                    <input type="number" name="number_of_ticket" class="primary-form-control" id="eventTicket" placeholder="300">
                  </div>
                </div>
              </div>

            <div class="col-md-6 d-none" id="eventPrice">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventTicket" class="form-label">{{__('Ticket Price')}} <span class="text-danger">*</span></label>
                    <input type="number" name="price" step="0.01" class="primary-form-control" id="price" placeholder="$300">
                  </div>
                </div>
            </div>

            <div class="col-md-12">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap">
                    <label for="eventLocation" class="form-label">{{__('Location')}} <span class="text-danger">*</span></label>
                    <textarea name="location" class="primary-form-control" id="eventDescription" placeholder="{{ __('Write location...') }}" spellcheck="false"></textarea>
                  </div>
                </div>
            </div>

            <div class="col-12">
                <div class="primary-form-group">
                    <div class="primary-form-group-wrap">
                        <label for="eventDescription" class="form-label">{{__('Description')}} <span class="text-danger">*</span></label>
                        <textarea name="description" class="primary-form-control min-h-180 summernoteOne" id="eventDescription" placeholder="{{ __('Write description...') }}" spellcheck="false"></textarea>
                    </div>
                </div>
            </div>

             <div class="pb-4 col-md-6 ">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap zImage-upload-details">
                    <div class="zImage-inside">
                      <div class="d-flex pb-12"><img src="{{asset('assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
                      <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                    </div>
                    <label for="zImageUpload" class="form-label">{{__('Upload Image')}} <span class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="">
                        <input type="file" name="thumbnail" accept="image/*" onchange="previewFile(this)">
                    </div>
                  </div>
                </div>
              </div>

              <div class="pb-4 col-md-6">
                <div class="primary-form-group">
                  <div class="primary-form-group-wrap zImage-upload-details">
                    <div class="zImage-inside">
                      <div class="d-flex pb-12"><img src="{{asset('assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
                      <p class="fs-15 fw-500 lh-16 text-1b1c17">{{__('Drag & drop files here')}}</p>
                    </div>
                    <label for="zImageUpload" class="form-label">{{__('Ticket Image')}} <span class="text-mime-type">(jpg,jpeg,png)</span> <span class="text-danger">*</span></label>
                    <div class="upload-img-box">
                        <img src="">
                        <input type="file" name="ticket_image" accept="image/*" onchange="previewFile(this)">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="d-inline-flex py-13 px-26 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black mt-30 hover-bg-one border-0">{{__('Publish Now')}}</button>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection

@push('script')
    <script src="{{ asset('admin/js/event.js') }}"></script>
@endpush

