<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMessageToUsers extends Mailable
{
    use Queueable, SerializesModels;

    public $messageContent;
    public $title;

    public function __construct($messageContent,$title)
    {
        $this->messageContent = $messageContent;
        $this->title = $title;

    }

    public function build()
    {
        return $this->subject($this->title)
                    ->view('')
                    ->with([
                        'messageContent' => $this->messageContent,
                    ]);
    }
}
