<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $content;
    public $subject;

    public function __construct($content, $subject)
    {
        $this->content = $content;
        $this->subject = $subject;
    }

    public function build()
    {
        return $this->subject($this->subject)
        ->view('notifications::JobAlert')
        ->with([
                        'content' => $this->content,
                    ]);
    }
}
