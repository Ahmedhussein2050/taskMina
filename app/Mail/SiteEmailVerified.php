<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Site\Admin\MailingTemplate;

class SiteEmailVerified extends Mailable
{
    use Queueable, SerializesModels;

    private $user, $store;
	public $html;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user , $store)
    {
        $this->user = $user;
        $this->store = $store;
        $this->template = MailingTemplate::
            where('category', 'customers')
            ->where('type','welcome')
            ->where('lang_id', getLang())
            ->first();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $settings = \App\Setting::first();
        $settings_data = \App\Models\Settings\SettingsData::where('settings_data.lang_id', getLang())->first();

        $this->template->body = str_replace(
            [
                '{site_name}',
                '{store_domain}',
                '{user_name}',
                '{store_name}',
                '{store_admin}'
            ],
            [
                $settings_data->title,
                env("APP_URL"),
                $this->user->email,
                $settings_data->title,
               env("APP_URL").'/admin',

            ],
            $this->template->body
        );

        $this->template->subject = str_replace(
            [
                '{site_name}'
            ],
            [
                $settings_data->title,
            ],
            $this->template->subject
        );


        return $this
            ->from(env('MAIL_FROM'), env('MAIL_FROM_NAME'))
            ->subject($this->template->subject)
            ->markdown(
                $this->html=(view('emails.site.site_email_verified',
                [
                    'body' => $this->template->body
                ]
				)->render()));
    }
}
