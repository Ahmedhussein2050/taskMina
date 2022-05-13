<?php

namespace App\Mail;

use App\Bll\Utility;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminSendCouponToUser extends Mailable
{
	public $html;
    use Queueable, SerializesModels;

	private $user, $request, $store;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $request )
    {
        $this->user = $user;
        $this->request = $request;
		$this->store = Utility::getSmtpSettings();
	}

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$transport = (new \Swift_SmtpTransport($this->store->smtp_host, $this->store->smtp_port))
		// ->setEncryption('ssl')
		->setUsername($this->store->smtp_username)
		->setPassword($this->store->smtp_password);

      	return $this
            ->from($address = $this->store->smtp_username, $name = $this->store->smtp_sender_name)
			->subject($this->request->subject)
			->markdown(
				$this->html=(view('emails.admin.send_coupon_to_user',
				[
					'request' => $this->request
				]
				)->render()));
    }
}
