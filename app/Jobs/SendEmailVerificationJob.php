<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailVerificationMail;

class SendEmailVerificationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;
    protected $verificationToken;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($email, $verificationToken)
    {
        $this->email = $email;
        $this->verificationToken = $verificationToken;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
                \Log::info("Sending verification email to {$this->email}");

        Mail::to($this->email)->send(new EmailVerificationMail($this->verificationToken));
    }
}
