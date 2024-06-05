@foreach ($posts as $post)
<div class="zPost-item p-25 bg-white bd-one bd-c-black-10 bd-ra-25 post-main-area">
    <input type="hidden" class="post-slug" value="{{ $post->slug }}">
    <!-- Header -->
    <div class="pb-22 d-flex justify-content-between align-items-center">

        <!-- User -->
        <div class="d-flex align-items-center cg-10">
            <div class="flex-shrink-0 w-45 h-45 bd-one bd-c-cdef84 rounded-circle overflow-hidden">
                <img onerror="this.src='{{asset('public/assets/images/no-image.jpg')}}'" src="{{ $post->created_by == 'admin' ? asset('public/storage/admin/' . $post->creator->image) : asset('public/storage/company/' . $post->creator->image) }}" class="w-100" alt="{{__('post')}}" />
            </div>
            <div class="">
                <h4 class="fs-16 fw-500 lh-20 text-1b1c17">{{ $post->created_by == 'admin' ? $post->creator->first_name .' '.$post->creator->last_name : $post->creator->name }}</h4>
                <p class="fs-12 fw-400 lh-15 text-707070">{{ \Carbon\Carbon::parse($post->created_at)->diffForHumans()}}</p>

            </div>
        </div>
        <!-- Edit - Delete -->
        @if($post->user_id == auth('admin')->id())
        <div class="dropdown">
            <button class="border-0 p-0 bg-transparent post-dropdown-one text-707070 dropdown-toggle" type="button"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-ellipsis-vertical"></i>
            </button>
            <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                <li>
                    <a class="align-items-center btn cg-8 d-flex border-0 edit-post-btn">
                        <div class="d-flex">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471"
                                    stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <circle cx="12" cy="8" r="4" stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                    stroke-linecap="round"></circle>
                            </svg>
                        </div>
                        <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Edit') }}</p>
                    </a>
                </li>
                <li>
                    <a class="align-items-center btn cg-8 d-flex border-0 delete-post-btn">
                        <div class="d-flex">
                            <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663"
                                    stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round">
                                </path>
                                <path d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625"
                                    stroke="#707070" stroke-opacity="0.7" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round"></path>
                            </svg>
                        </div>
                        <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Delete') }}</p>
                    </a>
                </li>
            </ul>
        </div>
        @endif
    </div>
    <!-- Body -->
    <div class="pb-25 bd-b-one bd-c-black-10 post-main-body post-main-body-{{ $post->slug }}">
        <p class="fs-14 fw-400 lh-24 text-707070">
            {!! nl2br($post->body) !!}
        </p>
        @if(count($post->media))
        @php
            $photoGalleryClass =  '';
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

            @if(in_array($media->extension ?? '', ['png', 'jpg', 'svg', 'jpeg', 'gif']))
                    <li>
                        <a href="{{ asset('public/storage/posts').'/'.$media->name }}" data-lightbox="post-gallery-{{ $post->slug }}" data-title="{{ $media->name }}">
                            <img src="{{ asset('public/storage/posts').'/'.$media->name }}" alt="Image">
                            @if($index == 2 && count($post->media) > 3)
                                <div class='morePhotos'>+{{ count($post->media) - 3 }} more</div>
                            @endif
                        </a>
                    </li>
            @elseif (in_array($media->extension ?? '', ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv']))
            <li>
                <a href="{{ asset('public/storage/posts').'/'.$media->name}}"
                    class="video">
                    <video
                        src="{{ asset('public/storage/posts').'/'.$media->name}}}"></video>
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
{{--    <!-- Footer -->--}}
    <div class="like-comment-area like-comment-area-{{ $post->slug }}">



         <!-- Comment Input -->
         <div class="mt-17 comment-input-box">
            <!-- Reply text -->
            <div class="d-flex align-items-center cg-15 pb-5 pl-40 d-none reply-note">
                <input type="hidden" class="reply-to-id-input">
                <p class="fs-12 fw-400 lh-20 text-707070 divider-one">{{ __('Replying to') }} <a class="fw-600 text-1b1c17 reply-to-name"></a></p>
                <button class="border-0 p-0 bg-transparent fs-12 fw-400 lh-20 text-707070 cancel-reply-to">{{ __('Cancel') }}</button>
            </div>

        </div>
    </div>
</div>
@endforeach

