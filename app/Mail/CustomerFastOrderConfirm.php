<?php

namespace App\Mail;

use App\Store;
use Carbon\Carbon;
use App\Bll\Utility;
use App\DefaultImage;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use App\Models\product\orders;
use App\Models\MailingTemplate;
use App\Models\product\products;
use App\Models\product\Shipping;
use Illuminate\Queue\SerializesModels;
use App\Models\Shipping\Shipping_option;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomerFastOrderConfirm extends Mailable
{
    use Queueable, SerializesModels;
	public $html;

	private $user, $request, $order_id, $order, $shipping, $shipping_option;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user_name, $request ,$order_id)
    {
        $this->user_name = $user_name;
        $this->order_id = $order_id;
        $this->request = $request;
		$this->template = MailingTemplate::where('category', 'orders')->where('type','confirm')->where('lang_id', getLang())->first();
		$this->store = Utility::getSmtpSettings();
	}

    /**
     * Build the message.
     *
     * @return $this
     */
	public function build()
	{
		$order_id = $this->order_id;
		$this->products =  products::select('products.id', 'title','order_products.price', 'order_products.custom_fields', 'count','order_id')
			->join('product_details', 'products.id', 'product_details.product_id')
			->join('order_products', 'products.id', 'order_products.product_id')
			->where('lang_id', getLang())
			->where('order_id', $order_id)
			->orderBy('id', 'desc')
			->get();
		$this->order = orders::find($order_id);
		$this->shipping = Shipping::where('order_id', $order_id)->first();
		$this->shipping_option = Shipping_option::find($this->order->shipping_option_id);

		$settings = get_settings();
		$settings_data = get_settings_data();
		$store = Store::find($settings->store_id);
		$store_url = env("APP_URL");

		$images = DefaultImage::first();
		$logo = asset("uploads/default_images/" . $images->header);

		$variables = (object) [];

		$this->template->body = convert_email_fast_variables($this->template->body, $this->user_name, $variables);
		$this->template->subject = convert_email_fast_variables($this->template->subject, $this->user_name, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.customer_order_confirm',
				[
					'request' => $this->template,
					'products' => $this->products,
					'order' => $this->order,
					'shipping' => $this->shipping,
					'shipping_option' => $this->shipping_option,
					'delivery_date' => Carbon::now()->addDays($this->shipping_option->delay ?? 0),
					'store_url' => $store_url,
					'logo' => $logo,
					'store_name' => $settings_data->title
				]
				)->render()));
	}
}
