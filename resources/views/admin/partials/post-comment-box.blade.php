@if(count($post->comments))
<div class="pt-18">
    <!-- Comment List & Reply -->
    <ul class="pb-0 postComments">
        @foreach ($post->comments as $comment)
        <li class="single-comment-block">
            <!-- Main comment -->
            <div class="d-flex align-items-start cg-10">
                <div class="flex-grow-1 d-flex align-items-start cg-8">
                    <!-- User image -->
                    <div class="flex-shrink-0 w-28 h-28 rounded-circle overflow-hidden bg-f9f9f9">
                        <img src="{{ asset(getFileUrl($comment->user->image)) }}" alt="{{ $comment->user->name }}" />
                    </div>
                    <!-- Comment text, Reply option -->
                    <div class="flex-grow-1 comment-data" data-user-name="{{ $comment->user->name }}" data-id="{{ $comment->id }}">
                        <!-- Comment text -->
                        <div class="p-13 bd-ra-15 bg-f9f9f9">
                            <h4 class="fs-14 fw-500 lh-17 text-black pb-5">{{ $comment->user->name }}</h4>
                            <p class="fs-12 fw-400 lh-20 text-707070">{!! nl2br($comment->body) !!}</p>
                        </div>
                        <!-- Reply button & time -->
                        <div class="d-flex align-items-center cg-15 pl-13 pt-4">
                            <button class="border-0 p-0 bg-transparent fs-12 fw-500 lh-20 text-707070 reply-btn">{{ __('Reply') }}</button>
                            <p class="fs-12 fw-500 lh-20 text-707070">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                </div>
                @if($comment->user_id == auth()->id())
                <!-- Edit - Delete -->
                <div class="dropdown">
                    <button
                        class="border-0 p-0 bg-transparent post-dropdown-one text-707070 dropdown-toggle"
                        type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                        <li>
                            <a data-id="{{ $comment->id }}" data-comment-body="{!! $comment->body !!}" class="align-items-center btn cg-8 d-flex border-0 comment-edit">
                                <div class="d-flex">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471"
                                            stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round">
                                        </path>
                                        <circle cx="12" cy="8" r="4" stroke="#707070" stroke-opacity="0.7"
                                            stroke-width="1.5" stroke-linecap="round"></circle>
                                    </svg>
                                </div>
                                <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Edit') }}</p>
                            </a>
                        </li>
                        <li>
                            <a data-id="{{ $comment->id }}" data-comment-body="{!! $comment->body !!}" class="align-items-center btn cg-8 d-flex border-0 comment-delete">
                                <div class="d-flex">
                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663"
                                            stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round">
                                        </path>
                                        <path
                                            d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625"
                                            stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round"></path>
                                    </svg>
                                </div>
                                <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Delete') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>

            @foreach ($comment->replies as $reply)
            <!-- Reply comment -->
            <div class="postCommentReply">
                <ul class="postCommentReplyList">
                    <li class="single-comment-block">
                        <div class="d-flex align-items-start cg-10">
                            <div class="flex-grow-1 d-flex align-items-start cg-8">
                                <!-- User image -->
                                <div
                                    class="flex-shrink-0 w-28 h-28 rounded-circle overflow-hidden bg-f9f9f9">
                                    <img src="{{ asset(getFileUrl($reply->user->image)) }}" class="w-100" alt="{{ $reply->user->name }}" />
                                </div>
                                <!-- Comment text, Reply option -->
                                <div class="flex-grow-1 comment-data" data-user-name="{{ $reply->user->name }}" data-id="{{ $comment->id }}">
                                    <!-- Comment text -->
                                    <div class="p-13 bd-ra-15 bg-f9f9f9">
                                        <h4 class="fs-14 fw-500 lh-17 text-black pb-5">{{ $reply->user->name }}</h4>
                                        <p class="fs-12 fw-400 lh-20 text-707070">{!! nl2br($reply->body) !!}</p>
                                    </div>
                                    <!-- Reply button & time -->
                                    <div class="d-flex align-items-center cg-15 pl-13 pt-4">
                                        <button
                                            class="border-0 p-0 bg-transparent fs-12 fw-500 lh-20 text-707070 reply-btn">{{ __('Reply') }}</button>
                                        <p class="fs-12 fw-500 lh-20 text-707070">{{ $reply->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                            </div>
                            @if($reply->user_id == auth()->id())
                            <!-- Edit - Delete -->
                            <div class="dropdown">
                                <button
                                    class="border-0 p-0 bg-transparent post-dropdown-one text-707070 dropdown-toggle"
                                    type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end dropdownItem-one">
                                    <li>
                                        <a data-id="{{ $reply->id }}" data-comment-body="{!! $reply->body !!}" class="align-items-center btn cg-8 d-flex border-0 comment-edit">
                                            <div class="d-flex">
                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M19.7274 20.4471C19.2716 19.1713 18.2672 18.0439 16.8701 17.2399C15.4729 16.4358 13.7611 16 12 16C10.2389 16 8.52706 16.4358 7.12991 17.2399C5.73276 18.0439 4.72839 19.1713 4.27259 20.4471"
                                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                                        stroke-linecap="round">
                                                    </path>
                                                    <circle cx="12" cy="8" r="4" stroke="#707070" stroke-opacity="0.7"
                                                        stroke-width="1.5" stroke-linecap="round"></circle>
                                                </svg>
                                            </div>
                                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Edit') }}</p>
                                        </a>
                                    </li>
                                    <li>
                                        <a data-id="{{ $reply->id }}" data-comment-body="{!! $reply->body !!}" class="align-items-center btn cg-8 d-flex border-0 comment-delete">
                                            <div class="d-flex">
                                                <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9.49935 17.8333C7.28921 17.8333 5.1696 16.9553 3.60679 15.3925C2.04399 13.8297 1.16602 11.7101 1.16602 9.49996C1.16602 7.28982 2.04399 5.17021 3.60679 3.6074C5.1696 2.0446 7.28921 1.16663 9.49935 1.16663"
                                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                                        stroke-linecap="round">
                                                    </path>
                                                    <path
                                                        d="M7.41602 9.5H17.8327M17.8327 9.5L14.7077 6.375M17.8327 9.5L14.7077 12.625"
                                                        stroke="#707070" stroke-opacity="0.7" stroke-width="1.5"
                                                        stroke-linecap="round" stroke-linejoin="round"></path>
                                                </svg>
                                            </div>
                                            <p class="fs-14 fw-500 lh-16 text-707070">{{ __('Delete') }}</p>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            @endif
                        </div>
                    </li>
                </ul>
            </div>
            @endforeach
        </li>
        @endforeach
    </ul>
</div>
@endif