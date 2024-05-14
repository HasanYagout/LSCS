<!-- Header -->
<div class="pb-22 d-flex justify-content-between align-items-center">
    <!-- User -->
    <div class="d-flex align-items-center cg-10">
        <div class="flex-shrink-0 w-45 h-45 bd-one bd-c-cdef84 rounded-circle overflow-hidden"><img src="{{ asset(getFileUrl($post->author->image)) }}" alt="{{ $post->author->name }}" /></div>
        <div class="">
            <h4 class="fs-16 fw-500 lh-20 text-1b1c17">{{ $post->author->name }}</h4>
            <p class="fs-12 fw-400 lh-15 text-707070">{{ $post->created_at->diffForHumans() }}</p>
        </div>
    </div>
</div>
<!-- Body -->
<div class="pb-18 bd-b-one bd-c-black-10">
    <input type="hidden" name="slug" value="{{ $post->slug }}">
    <textarea class="form-control postInput" name="body" placeholder="{{ __('What’s on your mind?') }}">{!! $post->body !!}</textarea>
</div>
<!-- Footer -->
<div class="">
    <div class="pt-18">
        <!-- Attachment preview -->
        <div id="files-area" class="pb-10">
            <span id="filesList2">
                <span id="files-names2">
                    @foreach ($post->media as $item)
                    <span class="file-block"><span class="file-icon"><i class="fa-solid fa-file"></i></span>
                        <input type="hidden" name="oldFiles[]" value="{{ $item->id }}">
                        <p class="name">{{ $item->file_manager->original_name }}</p>
                        <span class="file-delete"><i class="fa-solid fa-xmark"></i></span>
                    </span>
                    @endforeach
                </span>
            </span>
        </div>
        <!-- Add image/video -->
        <div class="d-flex align-items-center cg-15 pb-30">
            <p class="fs-16 lh-18 fw-500 text-707070">{{ __('Add to your post') }}:</p>
            <div class="d-flex align-items-center cg-10">
                <div class="align-items-center cg-10 d-flex flex-shrink-0">
                    <label for="mAttachment3"><img src="{{ asset('assets/images/icon/post-photo.svg')}}" alt="" /></label>
                    <input type="file" name="file[]" accept=".png,.jpg,.svg,.jpeg,.gif,.mp4,.mov,.avi,.mkv,.webm,.flv" id="mAttachment3" class="d-none" multiple />
                    <label for="mAttachment3"><img src="{{ asset('assets/images/icon/post-video.svg')}}" alt="" /></label>
                </div>
            </div>
        </div>
        <!-- Button -->
        <button type="submit"
            class="border-0 py-10 px-26 bd-ra-12 bg-cdef84 hover-bg-one w-100 d-flex justify-content-center align-items-center">{{ __('Update Post') }}</button>
    </div>
</div>