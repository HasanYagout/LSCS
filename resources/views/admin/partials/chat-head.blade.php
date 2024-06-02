<div class="message-user-img">
    <img src="{{ asset(getFileUrl($user->image)) }}" alt="{{ $user->name }}" />
    @if(isOnline($user->last_seen))
    <p class="online user-online-{{ $user->id }}"></p>
    @else
    <p class="offline user-online-{{ $user->id }}"></p>
    @endif
</div>
<div class="message-user-text">
    <p class="title">{{ $user->name }}</p>
    @if(isOnline($user->last_seen))
    <p class="status user-online-text-{{ $user->id }}" data-online="{{ __('Online') }}">{{ __('Online') }}</p>
    @else
    <p class="status user-online-text-{{ $user->id }}" data-offline="{{ __('Offline') }}">{{ __('Offline') }}</p>
    @endif
</div>