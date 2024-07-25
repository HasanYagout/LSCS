<!-- resources/views/emails/job_post.blade.php -->
@component('mail::message')
    # New Job Post: {{ $jobPost->title }}



    Hello,

    We are excited to announce a new job opportunity at our company. Below are the details of the job post:

    @component('mail::button', ['url' => route('job_post.show', ['slug' => $jobPost->slug])])
        View Job Post
    @endcomponent

    We look forward to receiving your application.
    Thanks,<br>
    {{ config('app.name') }}
@endcomponent
