@component('mail::message')

<div class="message">
    {!! getEmailTemplate('Forgot Password', 'body', $link) !!}
</div>

@endcomponent

