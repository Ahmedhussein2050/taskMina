<?php

namespace App\Bll;


use Exception;
use SendGrid\Mail\MimeType;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail as FacadesMail;

class Mail
{
	public static function send($email, $template)
	{
		// try {
		// 	FacadesMail::to($email)->send($template);
		// } catch (\Exception $e) {
		// 	error_log($e->getMessage());
		// }

		// Mail Chimp - Live Production
		// static::mailChimp($email, $template);

		// Send Grid - Test Environment
		static::sendGrid($email, $template);
	}

	private function sendGrid ($email, $template)
	{

		$html = $template->build()->html;
		$m = new \SendGrid\Mail\Mail();
       // dd(Config::get('mail.mail-from'));
		$m->setFrom(Config::get('mail.mail-from'), "Mashora App");
		$m->setSubject($template->subject);
		$m->addTo($email, $email);
		$m->addContent(MimeType::HTML, $html);
		$sendgrid = new \SendGrid(Config::get('mail.mail-token'));
		try {
			$response = $sendgrid->send($m);
			// print $response->statusCode() . "\n";
			// print_r($response->headers());
			// print $response->body() . "\n";
		} catch (\Exception $e) {
			$err = 'Caught exception: ' . $e->getMessage() . "\n";
			error_log($err);
		}
	}

	private static function mailChimp ($email, $template)
	{
		$mail = new MailChimp();
		$test = "Skilya.kuwait@gmail.com";
		$mail->AddTo($email, $email);
		$mail->send($template->subject, $template);
	}
}
