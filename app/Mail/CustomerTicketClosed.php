<?php

namespace App\Mail;

use App\Bll\Utility;
use App\Models\MailingTemplate;
use App\ticket;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerTicketClosed extends Mailable
{
	use Queueable, SerializesModels;
	public $html;
	private $user, $ticket_id, $agent_id;
	/**
	 * Create a new message instance.
	 *
	 * @return void
	 */
	public function __construct( $user, $ticket )
	{
		$this->user = $user;
		$this->ticket_id = $ticket;
		$obTicket = ticket::query()->find($ticket);
		$this->agent_id = $obTicket->agent_id;
		$this->template = MailingTemplate::where('category', 'tickets')->where('type', 'closed')->where('lang_id', getLang())->first();
		$this->store = Utility::getSmtpSettings();
	}

	/**
	 * Build the message.
	 *
	 * @return $this
	 */
	public function build()
	{
		$variables = (object) ['ticket_id' => $this->ticket_id];

		$front_user = User::query()->where('id', $this->agent_id)->first();
		$this->template->body = convert_email_variables($this->template->body, $front_user?$front_user->id: '', $variables);
		$this->template->subject = convert_email_variables($this->template->subject, $this->user->id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.customer_ticket_closed',
				[
					'body' => $this->template->body,
				]
				)->render()));
	}
}
