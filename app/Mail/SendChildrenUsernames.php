<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendChildrenUsernames extends Mailable
{
    use Queueable, SerializesModels;

    public $children;
    public $parents;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($children, $parents)
    {
        $this->children = $children;
        $this->parents = $parents;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('NGS Kidsclub Usernames')->view('emails.send_usernames');
    }
}
