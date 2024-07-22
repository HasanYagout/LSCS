<?php

namespace App\Jobs;

use App\Mail\JobPostEmail;
use App\Mail\TestMail;
use App\Models\Alumni;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendJobPostEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $jobPost;

    /**
     * Create a new job instance.
     */
    public function __construct(JobPost $jobPost)
    {
       $this->jobPost = $jobPost;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
//        $users = User::where('status', 1)
//            ->whereIn('role_id', [1])
//            ->whereNotNull('email')
//            ->where('email', '!=', '')
//            ->get();
//
        $alumni = Alumni::whereNotNull('email')
            ->where('email', '!=', '')
            ->get();

//        $recipients = $users->merge($alumni);
        foreach ($alumni as $recipient) {
            try {
                Mail::to($recipient->email)->queue(new JobPostEmail($this->jobPost));
                Log::info('Email queued for ' . $recipient->email);

            } catch (\Exception $e) {
                // Log the error for debugging
                Log::error('Failed to queue email to ' . $recipient->email . ': ' . $e->getMessage());
            }
        }
    }
}
