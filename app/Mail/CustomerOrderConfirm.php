<?php

namespace App\Mail;

use App\Store;
use Carbon\Carbon;
use App\Bll\Utility;
use App\Currency;
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
use CodeItNow\BarcodeBundle\Utils\QrCode;


class CustomerOrderConfirm extends Mailable
{
    use Queueable, SerializesModels;
	public $html;

	private $user, $request, $order_id, $order, $shipping, $shipping_option;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $request ,$order_id, $qr_code ,$qr_code_type ,$currency,$payment)
    {
        $this->user = $user;
        $this->qr_code = $qr_code;
        $this->qr_code_type = $qr_code_type;
        $this->currency = $currency;
        $this->payment = $payment;
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
		$this->products =  products::select('products.id', 'title','order_products.custom_fields','order_products.price','count','order_id')
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

		$this->template->body = convert_email_variables($this->template->body, $this->user->id, $variables);
		$this->template->subject = convert_email_variables($this->template->subject, $this->user->id, $variables);

		$username = env('MAIL_FROM');
		$sender_name = env('MAIL_FROM_NAME');


		$this->html=(view('web.v1.account.print',[
 			'products' => $this->products,
			'order' => $this->order,
			'shipping' => $this->shipping,
			'qr_code_type' => $this->qr_code_type,
			'qr_code' => $this->qr_code,
			'user' =>$this->user,
			'currency' => $this->currency,
			'payment' => $this->payment,
		])->render());
		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('web.v1.account.print',
				[
 					'products' => $this->products,
					'shipping' => $this->shipping,
					'order' => $this->order,
					'qr_code_type' => $this->qr_code_type,
					'qr_code' => $this->qr_code,
					'user' =>$this->user,
					'currency' => $this->currency,
					'payment' => $this->payment,


				]
				)->render()));
	}
}
