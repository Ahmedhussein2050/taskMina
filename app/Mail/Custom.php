<?php

namespace App\Mail;

use App\Bll\Utility;
use App\Models\MailingTemplate;
use App\Models\Settings\StoreSmtp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Custom extends Mailable
{
	public $html;

	use Queueable, SerializesModels;
	private $email;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $email )
    {
		$this->email = $email;
		$this->store =StoreSmtp::first();

    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$template = '';
		if( $this->email->template == NULL )
		{
			$subject = $this->email->subject;
			$body = $this->email->message;
		}
		else
		{
			$template = MailingTemplate::where('id', $this->email->template)->where('lang_id', 2)->first();
			$subject = $template->subject;
			$body = $template->body;
		}

		if($this->store==null)
		return $this
			->subject($subject)
			->markdown(
				$this->html=(view('emails.admin.custom',
				[
					'body' => $body
				]
				)->render()));

		$transport = (new \Swift_SmtpTransport($this->store->smtp_host, $this->store->smtp_port))
		// ->setEncryption('ssl')
		->setUsername($this->store->smtp_username)
		->setPassword($this->store->smtp_password);


		return $this
            ->from($address = $this->store->smtp_username, $name = $this->store->smtp_sender_name)
			->subject($subject)
			->markdown(
				$this->html=(view('emails.admin.custom',
				[
					'body' => $body
				]
				)->render()));

    }
}
