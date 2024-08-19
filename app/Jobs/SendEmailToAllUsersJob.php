<?php

namespace App\Jobs;

use App\Mail\SendMessageToUsers;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailToAllUsersJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $messageContent;
    public $title;

    public function __construct($messageContent,$title)
    {
        $this->messageContent = $messageContent;
        $this->title = $title;

    }

    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            Mail::to($user->email)->send(new SendMessageToUsers($this->messageContent, $this->title));
        }
    }
}
