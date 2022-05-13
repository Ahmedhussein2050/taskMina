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

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;
	public $html;
	private $user, $request, $invoice;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $user, $request, $invoice)
    {
        $this->user = $user;
        $this->invoice = $invoice;
        $this->request = $request;
		$this->template = MailingTemplate::where('category', 'invoices')->where('type', 'send_invoice')->where('lang_id', getLang())->first();

		$this->store = Utility::getSmtpSettings();
	}

    /**
     * Build the message.
     *
     * @return $this
     */
	public function build()
	{
		$invoice_id = $this->invoice->id;
		$this->products =  products::select('products.id', 'title','invoice_products.total_price','invoice_products.quantity')
			->join('product_details', 'products.id', 'product_details.product_id')
			->join('invoice_products', 'products.id', 'invoice_products.product_id')
			->where('lang_id', getLang())
			->where('invoice_id', $invoice_id)

			->orderBy('id', 'desc')
			->get();

		$settings = get_settings();
		$settings_data = get_settings_data();
		$store = Store::find($settings->store_id);
		$store_url = env("APP_URL");

		$images = DefaultImage::first();
		$logo = asset("uploads/default_images/" . $images->header);

		$variables = (object) [];

		$this->template->body = convert_email_variables($this->template->body, $this->user->id, $variables);
		$this->template->subject = convert_email_variables($this->template->subject, $this->user->id, $variables);

		$username = env('MAIL_FROM',"no-reply@soinksa.com");
		$sender_name = env('MAIL_FROM_NAME',"no-reply@soinksa.com");


		//($this->template,$this->store );

		return $this
            ->from($address = $username, $name = $sender_name)
			->subject($this->template->subject)
			->markdown(
				$this->html=(view('emails.user.invoice_created',
				[
					'request' => $this->template,
					'products' => $this->products,
					'invoice' => $this->invoice,
					'store_url' => $store_url,
					'logo' => $logo,
					'store_name' => $settings_data->title
				]
				)->render()));
	}
}
