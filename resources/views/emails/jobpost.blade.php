<!-- resources/views/emails/job_post.blade.php -->
@component('mail::message')
    # New Job Post: {{ $jobPost->title }}

    ![Logo]({{ $message->embed(asset('assets/images/no-image.jpg')) }})

    ## Job Description
    {{ $jobPost->description }}

    @component('mail::button', ['url' => $jobPost->url])
        View Job Post
    @endcomponent

    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
