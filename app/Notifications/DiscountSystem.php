<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountSystem extends Notification
{
    use Queueable;

    private $details;
	private $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($details, $code)
    {
		$this->details = $details;
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
        return ['database'];
    }


    public function toDatabase($notifiable)
    {
        return [
            'name' =>$this->details['message'],
			'code' =>$this->code
        ];
    }
}
