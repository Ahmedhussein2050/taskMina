<?php

namespace App\Mail;

use App\Models\MailingTemplate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserOrder extends Mailable
{
    use Queueable, SerializesModels;
	public $html;
    private $msg;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($msg)
    {
		$this->msg  = $msg;

		$this->template = MailingTemplate::
		where('category', 'customers')
			->where('type','userOrderEmail')
			->where('lang_id', getLang())
			->first();

    //dd($this->template);
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

		$this->template->body = str_replace(
			[

				'{msg}',
				'{store_name}',

			],
			[
				$this->msg,
				'soinksa',
			],
			$this->template->body
		);



		return $this

			->markdown(
				$this->html=(view('emails.user.order',
				[
					'body' => $this->template->body,
					'msg' => $this->msg,
				]
				)->render()));

    }
}
