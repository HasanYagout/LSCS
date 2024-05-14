@foreach ($chats as $chat)
@if($chat->sender_id != auth()->id())
<div class="message-user-left">
    <div class="message-user-left-text">
        <div class="text">
            @if(count($chat->media))
            @php
            $photoGalleryClass = '';
            if(count($chat->media) == 1){
                $photoGalleryClass = 'messagePhoto-one';
            }elseif(count($chat->media) == 2){
                $photoGalleryClass = 'messagePhoto-two';
            }elseif(count($chat->media) == 3){
                $photoGalleryClass = 'messagePhoto-three';
            }elseif(count($chat->media) > 3){
                $photoGalleryClass = 'messagePhoto-multi';
            }
            @endphp

            @if($chat->message != NULL && $chat->message != '')
            <p>{!! nl2br($chat->message) !!}</p>
            @endif

            <ul class="messagePhoto postPhotoItems {{ $photoGalleryClass }} gallery pb-6">
                @foreach ($chat->media as $index => $media)
                @if(in_array($media->file_manager->extension ?? '', ['png', 'jpg', 'svg', 'jpeg', 'gif']))
                <li>
                    <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"><img
                        src="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"
                        alt="{{ $media->file_manager->original_name }}" />
                    @if($index == 2 && count($chat->media) > 3)
                    <div class='morePhotos'>+{{ count($chat->media)-$index }}</div>
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
            
            @elseif(0)

            @foreach ($chat->media as $index => $media)
            @if(in_array($media->file_manager->extension ?? '', ['pdf', 'zip']))
            <div class="file pb-6">
                <div class="d-flex align-items-center cg-16">
                    <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}" target="__blank"
                        class="flex-shrink-0 w-45 h-45 rounded-circle d-flex justify-content-center align-items-center bg-1b1c17">
                        <img src="{{ asset('assets/images/icon/file.svg') }}" alt="" />
                    </a>
                    <div class="">
                        <p class="fs-16 fw-500 lh-20 text-1b1c17">{{ $media->file_manager->original_name }}</p>
                        <span class="fs-13 fw-400 lh-16 text-1b1c17">{{ humanFileSize($media->file_manager->size, 'MB') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach 
            @else
            <p>{!! nl2br($chat->message) !!}</p>
            @endif

            <div class="time-read">
                <span class="time">{{ $chat->created_at->diffForHumans() }}</span>
                <div class="d-flex fill-green">
                    <svg width="17" height="11" viewBox="0 0 17 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.6121 1.96514C11.8728 1.64327 11.8232 1.17099 11.5014 0.910273C11.1795 0.649555 10.7072 0.699128 10.4465 1.021L4.48888 8.37597L2.05787 5.96099C1.76401 5.66906 1.28914 5.67063 0.997217 5.96449C0.705293 6.25835 0.706863 6.73322 1.00072 7.02515L4.02062 10.0251C4.1711 10.1746 4.37783 10.2534 4.58963 10.242C4.80143 10.2305 4.99848 10.13 5.13199 9.96514L11.6121 1.96514ZM16.5944 1.98618C16.8667 1.67407 16.8345 1.2003 16.5224 0.927974C16.2103 0.655653 15.7365 0.687909 15.4642 1.00002L9.00668 8.40105L8.55438 7.95757C8.25861 7.66758 7.78376 7.67226 7.49377 7.96802C7.20377 8.26379 7.20845 8.73864 7.50422 9.02863L8.52411 10.0286C8.67155 10.1732 8.87205 10.2506 9.07837 10.2425C9.28469 10.2345 9.47858 10.1418 9.61432 9.98619L16.5944 1.98618Z"
                            fill="#1B1C17" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="message-user-right">
    <div class="message-user-right-text">
        <div class="text">
            @if(count($chat->media))
            @php
            $photoGalleryClass = '';
            if(count($chat->media) == 1){
                $photoGalleryClass = 'messagePhoto-one';
            }elseif(count($chat->media) == 2){
                $photoGalleryClass = 'messagePhoto-two';
            }elseif(count($chat->media) == 3){
                $photoGalleryClass = 'messagePhoto-three';
            }elseif(count($chat->media) > 3){
                $photoGalleryClass = 'messagePhoto-multi';
            }
            @endphp

            @if($chat->message != NULL && $chat->message != '')
            <p>{!! nl2br($chat->message) !!}</p>
            @endif

            <ul class="messagePhoto postPhotoItems {{ $photoGalleryClass }} gallery pb-6">
                @foreach ($chat->media as $index => $media)
                @if(in_array($media->file_manager->extension ?? '', ['png', 'jpg', 'svg', 'jpeg', 'gif']))
                <li>
                    <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"><img
                        src="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}"
                        alt="{{ $media->file_manager->original_name }}" />
                    @if($index == 2 && count($chat->media) > 3)
                    <div class='morePhotos'>+{{ count($chat->media)-$index }}</div>
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
            
            @elseif(0)

            @foreach ($chat->media as $index => $media)
            @if(in_array($media->file_manager->extension ?? '', ['pdf', 'zip']))
            <div class="file pb-6">
                <div class="d-flex align-items-center cg-16">
                    <a href="{{ asset(getFile($media->file_manager->path ?? '', $media->file_manager->storage_type)) }}" target="__blank"
                        class="flex-shrink-0 w-45 h-45 rounded-circle d-flex justify-content-center align-items-center bg-1b1c17">
                        <img src="{{ asset('assets/images/icon/file.svg') }}" alt="" />
                    </a>
                    <div class="">
                        <p class="fs-16 fw-500 lh-20 text-1b1c17">{{ $media->file_manager->original_name }}</p>
                        <span class="fs-13 fw-400 lh-16 text-1b1c17">{{ humanFileSize($media->file_manager->size, 'MB') }}</span>
                    </div>
                </div>
            </div>
            @endif
            @endforeach 
            @else
            <p>{!! nl2br($chat->message) !!}</p>
            @endif

            <div class="time-read">
                <span class="time">{{ $chat->created_at->diffForHumans() }}</span>
                <div class="d-flex {{ $chat->is_seen ? 'fill-green' : '' }}">
                    <svg width="17" height="11" viewBox="0 0 17 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M11.6121 1.96514C11.8728 1.64327 11.8232 1.17099 11.5014 0.910273C11.1795 0.649555 10.7072 0.699128 10.4465 1.021L4.48888 8.37597L2.05787 5.96099C1.76401 5.66906 1.28914 5.67063 0.997217 5.96449C0.705293 6.25835 0.706863 6.73322 1.00072 7.02515L4.02062 10.0251C4.1711 10.1746 4.37783 10.2534 4.58963 10.242C4.80143 10.2305 4.99848 10.13 5.13199 9.96514L11.6121 1.96514ZM16.5944 1.98618C16.8667 1.67407 16.8345 1.2003 16.5224 0.927974C16.2103 0.655653 15.7365 0.687909 15.4642 1.00002L9.00668 8.40105L8.55438 7.95757C8.25861 7.66758 7.78376 7.67226 7.49377 7.96802C7.20377 8.26379 7.20845 8.73864 7.50422 9.02863L8.52411 10.0286C8.67155 10.1732 8.87205 10.2506 9.07837 10.2425C9.28469 10.2345 9.47858 10.1418 9.61432 9.98619L16.5944 1.98618Z"
                            fill="#1B1C17" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endforeach