<!-- Body -->
<div class="pb-25 bd-b-one bd-c-black-10 post-main-body post-main-body-{{ $post->slug }}">
    <p class="fs-14 fw-400 lh-24 text-707070">
        {!! nl2br($post->body) !!}
    </p>
    @if(count($post->media))
    @php
    $photoGalleryClass = '';
    if(count($post->media) == 1){
    $photoGalleryClass = 'postPhotoItems-one';
    }elseif(count($post->media) == 2){
    $photoGalleryClass = 'postPhotoItems-two';
    }elseif(count($post->media) == 3){
    $photoGalleryClass = 'postPhotoItems-three';
    }elseif(count($post->media) > 3){
    $photoGalleryClass = 'postPhotoItems-multi';
    }
    @endphp
    <ul class="postPhotoItems gallery {{ $photoGalleryClass }}">
        @foreach ($post->media as $index => $media)
        @if(in_array($media->file_manager->extension ?? '', ['png', 'jpg', 'svg', 'jpeg', 'gif']))
        <li>
            <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"><img
                    src="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"
                    alt="{{ $media->file_manager->original_name }}" />
                @if($index == 2 && count($post->media) > 3)
                <div class='morePhotos'>+{{ count($post->media)-$index }}</div>
                @endif
            </a>
        </li>
        @elseif (in_array($media->file_manager->extension ?? '', ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv']))
        <li>
            <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"
                class="video">
                <video
                    src="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"></video>
                <button class="vidPly-btn"><img src="{{ asset('assets/images/icon/play-btn.svg')}}" /></button>
                @if($index == 2 && count($post->media) > 3)
                <div class='morePhotos'>+{{ count($post->media)-$index }}</div>
                @endif
            </a>
        </li>
        @endif
        @endforeach
    </ul>
    @endif
</div>