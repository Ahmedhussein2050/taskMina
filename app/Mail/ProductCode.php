<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ProductCode extends Mailable
{
    use Queueable, SerializesModels;
	private $user, $request, $order_id, $order, $shipping, $shipping_option;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $request ,$order_id)
    {
        $this->user = $user ;
        $this->request = $request ;
        $this->order_id = $order_id ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('view.emails.user.product_code');
    }
}
