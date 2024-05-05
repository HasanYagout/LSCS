@component('mail::message')

<div class="message">
    {!! getEmailTemplate('Email Verify', 'body', $link) !!}
</div>

@endcomponent

