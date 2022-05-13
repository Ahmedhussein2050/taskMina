<?php

namespace App\Mail;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Modules\Admin\Models\MailingList\MailingTemplate;
// use App\Models\MailingTemplate;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerPassReseted extends Mailable
{
    use Queueable, SerializesModels;
	public $html;

    public $user_id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user_id )
    {
        $this->user_id = $user_id;
        // $this->store = Utility::getSmtpSettings();

        $this->template = MailingTemplate::
            where('category', 'customers')

            ->where('type', 'password_reseted')
            ->where('lang_id', Lang::getSelectedLangId())
            ->first();
	}

    /**
     * Build the message.
     *
     * @return $this
     */
	public function build()
	{
		$variables = (object) [];
		$this->template->body = Utility::convert_email_variables($this->template->body, $this->user_id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
            ->subject($this->template->subject)
            ->markdown(
				$this->html=(view('emails.user.customer_pass_reseted',
                [
                    'request' => $this->template
                ]
				)->render()));
	}
}
