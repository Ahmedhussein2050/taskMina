<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountMail extends Notification
{
    use Queueable;

    private $mail;
	private $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($mail, $code)
    {
        $this->mail = $mail;
		$this->code = $code;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }


	public function toMail($notifiable)
    {
        return (new MailMessage)
				->line('The introduction to the notification.')
				->line('your code is :'.$this->mail)
				->action('Notification Action', url('/'))
				->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [

         ];
    }
}
