<?php

namespace App\Mail;

use App\Bll\Utility;
use App\Models\MailingTemplate;
use App\Models\product\orders;
use App\Models\product\products;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerOrderStatusChanged extends Mailable
{
	use Queueable, SerializesModels;
	public $html;

	private $user, $request, $order_no;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct( $user, $order_no )
	{
		$this->user = $user;
		$this->order_no = $order_no;
		$this->template = MailingTemplate::where('category', 'orders')
			->where('type', 'status_changed')->where('lang_id', getLang())->first();
		$this->store = Utility::getSmtpSettings();
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$order_no = $this->order_no ;
		$variables = (object) ['order_no' => $order_no];

		$this->template->body = convert_email_variables($this->template->body, $this->user->id, $variables);
		$this->template->subject = convert_email_variables($this->template->subject, $this->user->id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.customer_order_status_changed',
				[
					'body' => $this->template->body,
				]
				)->render()));
	}
}
