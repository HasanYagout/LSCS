@extends('layouts.app')
@push('title')
    {{$title}}
@endpush

@section('content')

    <div class="p-30" >
        <div class="">
            <h4 class="fs-24 fw-500 lh-34 text-black pb-16">{{$title}}</h4>
            <div class="bg-white bd-half bd-c-ebedf0 bd-ra-25 p-30">
                <form id="storyForm"  enctype="multipart/form-data">
                    @csrf
                    <div class="max-w-840">
                        <div class="pb-30"></div>
                        <div class="row rg-25">
                            <div class="col-12">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="title" class="form-label">{{__('Title')}} <span class="text-danger">*</span></label>
                                        <input type="text" class="primary-form-control" id="title" name="title" placeholder="{{ __('Title') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap">
                                        <label for="body" class="form-label">{{__('Description')}} <span class="text-danger">*</span></label>
                                        <textarea name="body" class="primary-form-control min-h-180 summernoteOne" id="body" placeholder="{{ __('Write description...') }}" spellcheck="false"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="pb-4 col-md-6 ">
                                <div class="primary-form-group">
                                    <div class="primary-form-group-wrap zImage-upload-details">
                                        <div class="zImage-inside">
                                            <div class="d-flex pb-12"><img src="{{asset('public/assets/images/icon/upload-img-1.svg')}}" alt="" /></div>
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
                        </div>

                        <button type="submit" class="d-inline-flex py-13 px-26 bd-ra-12 bg-cdef84 fs-15 fw-500 lh-25 text-black mt-30 hover-bg-one border-0">{{__('Publish Now')}}</button>                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#storyForm').on('submit', function (e) {
                e.preventDefault(); // prevent the form from submitting the traditional way

                var formData = new FormData(this);

                $.ajax({
                    type: 'POST',
                    url: '{{route('admin.stories.store')}}',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        console.log(response);
                        if (response.success) {
                            toastr.success(response.message);
                            setTimeout(function () {
                                window.location.href = "{{ route('admin.stories.my-story') }}";
                            }, 2000); // Redirect after 2 seconds
                        } else {
                            toastr.error(response.message);
                        }
                    },
                    error: function (xhr) {
                        var errors = xhr.responseJSON.errors;
                        if (errors) {
                            Object.values(errors).forEach(error => {
                                toastr.error(error[0], 'Error');
                            });
                        } else {
                            toastr.error('An unexpected error occurred.', 'Error');
                        }
                    }
                });
            });
        });
    </script>
@endpush
