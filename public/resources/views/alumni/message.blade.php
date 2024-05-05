@extends('layouts.app')
@push('title')
{{ $title }}
@endpush
@section('content')
<div class="p-30">
    <!-- Start -->
    <div class="content-chat">
        <!-- Left -->
        <div class="content-chat-user">
            <!-- Title -->
            <div class="head-chat">
                <h4 class="title">{{ __('Chat') }}</h4>
            </div>
            <!-- Search -->
            <div class="search-two">
                <input type="text" id="chat-search-field" placeholder="{{ __('Search People') }}" />
                <button type="button" class="icon"><img src="{{ asset('assets/images/icon/search-1.svg') }}" alt="" /></button>
            </div>
            <!-- User list -->
            <div class="list-search-user-chat" id="chat-user">
                @include('alumni.partials.chat-user-list')
            </div>
        </div>
        <!-- Right -->
        <div class="content-chat-message-user-wrap">
            <!-- Single Use Message -->
            @foreach ($users as $user)
            @php
                if(request()->get('receiver_id') == $user->id){
                    $isActive = 'active';
                }elseif(request()->get('receiver_id') == NULL &&  $loop->first){
                    $isActive = 'active';
                }else{
                    $isActive = '';
                }
            @endphp
            <div class="content-chat-message-user {{ $isActive }}" data-id={{ $user->id }}>
                <!-- Head -->
                <div class="head-chat-message-user" id="chat-head-{{ $user->id }}">
                    @include('alumni.partials.chat-head')
                </div>
                <!-- Body -->
                <div class="body-chat-message-user" id="chat-body-{{ $user->id }}">
                    
                </div>
            </div>
            @endforeach
            <!-- Footer -->
            <div class="footer-chat-message-user border-0">
                <!-- Attachment preview -->
                <div id="files-area">
                    <span id="filesList">
                        <span id="files-names"></span>
                    </span>
                </div>
                <!-- input - buttons -->
                <form action="{{ route('chats.send_message') }}" enctype="multipart/form-data" id="send-form" data-handler="sendResponse" method="POST">
                    @csrf
                    <div class="footer-inputs d-flex justify-content-between g-10">
                        <input type="hidden" name="receiver_id" id="form-receiver-id" value="">
                        <div class="message-user-send">
                            <input type="text" name="message" class="send-message" placeholder="{{ __('Type your message here') }}..." />
                        </div>
                        <button type="button" class="atta-btn">
                            <label for="mAttachment"><img src="{{ asset('assets/images/icon/attachment.svg')}}" alt="" /></label>
                            <input type="file" name="file[]" id="mAttachment" accept=".png,.jpg,.svg,.jpeg,.gif,.mp4,.mov,.avi,.mkv,.webm,.flv" class="d-none" multiple />
                        </button>
                        <button type="submit" class="send-btn">
                            <img src="{{ asset('assets/images/icon/send.svg')}}" alt="" />
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="pusherEnable" value="{{ getOption('pusher_status', 0) }}">
<input type="hidden" id="pusherKey" value="{{ getOption('pusher_app_key') }}">
<input type="hidden" id="pusherCluster" value="{{ getOption('pusher_cluster') }}">
<input type="hidden" id="single-user-chat-route" value="{{ route('chats.single_user_chat') }}">
@endsection

@push('script')
    <script src="{{ asset('common/js/pusher.min.js') }}"></script>
    <script src="{{ asset('alumni/js/chat.js') }}?ver={{ env('VERSION' ,0) }}"></script>
@endpush
