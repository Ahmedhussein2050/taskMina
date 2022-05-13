<?php

namespace App\Mail;

use App\Bll\Lang;
use App\Bll\Utility;
 use App\Modules\Admin\Models\MailingList\MailingTemplate ;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerForgotPass extends Mailable
{
    use Queueable, SerializesModels;
	public $html;

    public $user_id, $token;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user_id, $token )
    {

        $this->user_id = $user_id;
        $this->token = $token;
        // $this->store = Utility::getSmtpSettings();

        $this->template = MailingTemplate::
            where('category', 'customers')

            ->where('type','forget_password')
           // ->where('lang_id', Lang::getSelectedLangId())
            ->first();

	}

    /**
     * Build the message.
     *
     * @return $this
     */
	public function build()
	{

		$variables = (object) ['forgot_url' => route('reset.password.token' , $this->token)];

		$this->template->body =  Utility::convert_email_variables($this->template->body, $this->user_id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
            ->subject($this->template->subject)
            ->markdown(
                $this->html=(view('portal.user.reset_password',
                [
                    'body' => $this->template->body
                ]
				)->render()));
	}
}
