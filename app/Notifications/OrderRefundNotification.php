<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderRefundNotification extends Notification
{
    use Queueable;
    private $orderRefundData ;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderRefundData)
    {
        $this->orderRefundData =  $orderRefundData ;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
//    public function toMail($notifiable)
//    {
//        return (new MailMessage)
//            ->name($this->orderData['name'])
//            ->line($this->orderData['body'])
//            ->action($this->orderData['orderText'], $this->offerData['orderUrl'])
//            ->line($this->orderData['thanks']);
//    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'order_id' =>  $this->orderRefundData['order_id']  ,
            'name' => $this->orderRefundData['name'] ,
            'orderText' => $this->orderRefundData['orderText']  ,
            'order_url' => $this->orderRefundData['order_url']
        ];
    }
}
