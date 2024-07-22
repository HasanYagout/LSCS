<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $jobPost;

    public function __construct($jobPost)
    {
        $this->jobPost = $jobPost;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail',
        );
    }

    public function build()
    {
        return $this->subject('New Job Post: ' . $this->jobPost->title)
            ->view('emails.job_post_notification')
            ->with('jobPost', $this->jobPost);
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.test',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

