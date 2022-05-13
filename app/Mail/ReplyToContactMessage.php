<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ReplyToContactMessage extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    private $reply;
    public function __construct($reply)
    {
        $this->reply = $reply;
    }

    public function build()
    {
        return  $this->markdown($this->html=(view('emails.reply_to_contact', ['reply' => $this->reply])->render()));
    }
}


