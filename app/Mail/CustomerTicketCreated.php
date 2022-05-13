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

class CustomerTicketCreated extends Mailable
{
	use Queueable, SerializesModels;
	public $html;
	private $user;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct( $user )
	{
		$this->user = $user;
		$this->template = MailingTemplate::where('category', 'tickets')->where('type', 'new_ticket_for_customer')->where('lang_id', getLang())->first();
		$this->store = Utility::getSmtpSettings();
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$variables = (object) [];

		$this->template->body = convert_email_variables($this->template->body, $this->user->id, $variables);
		$this->template->subject = convert_email_variables($this->template->subject, $this->user->id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.customer_ticket_created',
				[
					'body' => $this->template->body,
				]
				)->render()));
	}
}
