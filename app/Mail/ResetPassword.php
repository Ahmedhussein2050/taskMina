<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPassword extends Mailable
{
    use Queueable, SerializesModels;

	private $code;


	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct($code)
	{
		$this->code = $code ;
	}
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown($this->html=(view('emails.admin.send_code' , ['code' => $this->code])->render()));
    }
}
