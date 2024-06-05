<div class="modal-header">
    <h5 class="modal-title">{{ __('Update') }}</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<style>
    .preview-image {
        max-width: 100%;
        height: auto;
        margin-bottom: 10px;
    }

    .preview-column {
        padding: 5px;
    }
</style>
<form action="{{route('admin.alumni.gallery.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="alumni_id" value="{{ $alumni->id }}">
    <div class="modal-body model-lg">
        <div class="max-w-840">
            <div class="row rg-25">
                @if($alumni->images)
                    @foreach($alumni->images as $image)
                        <div class="col-md-6">
                            <div class="primary-form-group">
                                <div class="primary-form-group-wrap">
                                    <label for="jobCreateTitle" class="form-label">{{__('Job Title')}} <span
                                            class="text-danger">*</span></label>
                                    <input type="text" name="title" class="primary-form-control"
                                           value="{{$alumni->first_name??''}}" id="title" placeholder="{{ __('Sr. UX Designer') }}" required />
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-md-6">
                        <div class="primary-form-group">
                            <div class="custom-file" style="text-align: left">
                                <input type="file" multiple name="images[]" id="customFileEg12" class="custom-file-input"
                                       accept=".jpg, .png, .jpeg, .gif, .bmp, .tif, .tiff|image/*">
                                <label class="custom-file-label" for="customFileEg12">upload</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <hr>
                        <div id="previewContainer" class="row"></div>
                    </div>
                    <button type="submit">Upload</button>
                @endif
            </div>
        </div>
    </div>
</form>
<script>
    function readURL(input) {
        if (input.files && input.files.length > 0) {
            var previewContainer = $('#previewContainer');
            previewContainer.empty(); // Clear previous previews

            for (var i = 0; i < input.files.length; i++) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    var imageSrc = e.target.result;
                    var imgElement = $('<img>').attr('src', imageSrc).addClass('preview-image');
                    var columnElement = $('<div>').addClass('col-md-6 preview-column').append(imgElement);
                    previewContainer.append(columnElement);
                }
                reader.readAsDataURL(input.files[i]);
            }
        }
    }

    $("#customFileEg12").change(function () {
        readURL(this);
    });
</script>
