<?php

namespace App\Mail;

use App\Bll\Utility;
use App\DefaultImage;
use App\Models\MailingTemplate;
use App\Store;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class CustomerVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
	public $html;


		private $user, $request, $template;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $request )
    {
        $this->user = $user;
        $this->template = MailingTemplate::where('category', 'customers')->where('type', 'welcome')->where('lang_id',getLang())->first();
		$this->store = Utility::getSmtpSettings();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
		$settings = get_settings();
		$settings_data = get_settings_data();
		$store = Store::find($settings->store_id);
		$store_url = env("APP_URL");

		$images = DefaultImage::first();
		$logo = asset("uploads/default_images/" . $images->header);

		$this->template->subject = str_replace('{store_name}', $settings_data->title, $this->template->subject);
		$this->template->subject = str_replace('{user_name}', $this->user->name, $this->template->subject);
		$this->template->subject = str_replace('{user_id}', $this->user->id, $this->template->subject);

		$this->template->body = str_replace('{store_name}', $settings_data->title, $this->template->body);
		$this->template->body = str_replace('{store_url}', $store_url, $this->template->body);
		$this->template->body = str_replace('{store_logo}', $logo, $this->template->body);
		$this->template->body = str_replace('{user_name}', $this->user->name, $this->template->body);
		$this->template->body = str_replace('{user_id}', $this->user->id, $this->template->body);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.customer_verify_email',
				[
					'request' => $this->template
				]
				)->render()));
    }
}
