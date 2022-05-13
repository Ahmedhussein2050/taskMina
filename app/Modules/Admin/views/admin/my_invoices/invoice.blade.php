<!DOCTYPE html>
<html lang="ar" dir="rtl" style="font-family: sans-serif; -ms-text-size-adjust: 100%; -webkit-text-size-adjust: 100%; font-size: 10px;-webkit-tap-highlight-color: transparent;">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>{{ _i('Invoice') }} #{{$transaction->payment_id}}</title>
		<link href="{{ asset('css/print.css') }}" rel="stylesheet" type="text/css">
		<style type="text/css">
			@page  {
			size: auto;   /* auto is the initial value */
			margin: 0;  /* this affects the margin in the printer settings */
			}
			@media  print {
			img,
			tr {
			page-break-inside: avoid
			}
			*,
			:after,
			:before {
			background: 0 0 !important;
			color: #000 !important;
			box-shadow: none !important;
			text-shadow: none !important
			}
			thead {
			display: table-header-group
			}
			img {
			max-width: 100% !important
			}
			p {
			orphans: 3;
			widows: 3
			}
			.table {
			border-collapse: collapse !important
			}
			.table td,
			.table th {
			background-color: #fff !important
			}
			.price-before {
			text-decoration: line-through;
			color: #bbb;
			padding: 0 0 0 8px;
			}
			.page
			{
			page-break-before: always;
			}
			.header, .header-space,
			.footer, .footer-space {
			height: 30px;
			}
			.footer-space, .header-space
			{
			display: none;
			}
			.header-space {
			height: 50px;
			}
			.header {
			position: fixed;
			bottom: 25px;
			right: 50px;
			display:block !important;
			}
			.footer {
			position: fixed;
			bottom: 0;
			}
			.header-right {
			width: 50%
			}
			.header-left {
			width: 25%
			}
			.header-middle {
			width: 25%;
			}
			}
			*,
			:after,
			:before {
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box
			}
			.panel-body:after,
			.panel-body:before,
			.row:after,
			.row:before {
			content: " ";
			display: table
			}
			.panel-body:after,
			.row:after {
			clear: both
			}
			.price-before {
			text-decoration: line-through;
			color: #bbb;
			padding: 0 0 0 8px;
			}
			.page
			{
			page-break-before: always;
			}
			@page  :first .header
			{
			display: none !important;
			}
			table { page-break-inside:auto }
			tr    { page-break-inside:avoid; page-break-after:auto }
			thead { display:table-header-group }
			tfoot { display:table-footer-group }
		</style>
	</head>
	<script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js" data-cf-settings="cbc6a4618785802bdcfcd2bd-|49"></script>
	<body style="margin: 0; background-color: #fff; font-size: 15px; color: #444; font-family: Roboto, Helvetica Neue, Helvetica, Arial, sans-serif; line-height: 1.5384616; direction: rtl" onload="window.print()">
		<div class="page-container">
			<div style="position: relative;height: 100%;overflow: auto;">
				<div style="padding-bottom: 0;">
					<div style="padding: 15px 0 10px;text-align: center !important;">
						<img src="{{$images->header}}" height="60" alt="" style="display: block; margin: 0 auto; vertical-align: middle;">
						<h3 style="display: block; margin: 10px auto 0; color: #444; font-size: 17px !important; line-height: 1.5384616; font-weight: bold;">{{ $site_settings->title }}</h3>
						<h6 style="direction:ltr; color:#999; display: block; margin: 0 auto; font-size: 15px !important; line-height: 1.5384616; font-weight: normal;">{{env("APP_URL")}}</h6>
					</div>
					<div style="padding: 9px 20px 0 20px;min-height: 500px;">
						<div class="panel" style=" background-color: #fff; border: 1px solid transparent; margin-bottom: 50px; -webkit-box-shadow: none; box-shadow: none; border-color: #ddd; border-radius: 4px; color: #444; border-top-leftradius: 4px; border-top-right-radius: 4px;">
							<div class="panel-heading" style="padding: 1px 20px; border-bottom: 1px solid transparent; border-top-leftradius: 2px; border-top-right-radius: 2px; border-color: #ddd;height:50px">
								<div class="row" style="margin-right: -10px;margin-left: -10px;">
									<div style="float: right; position: relative; min-height: 1px; padding-right: 10px; padding-left: 10px; width: 50%;">
										<h5 style="font-family: inherit; font-weight: 400; line-height: 1.5384616; color: inherit; margin-top: 10px; margin-bottom: 10px; font-size: 17px; text-transform: uppercase;"> {{ _i('Receipt') }} #{{ $transaction->id }}</h5>
									</div>
									<div style="float: right; position: relative; min-height: 1px; padding-right: 10px; padding-left: 10px; width: 50%;">
										<ul style="margin-top: 10px; text-align: left; padding-right: 0; list-style: none; margin-bottom: 10px;">
											<li style="margin-bottom: 15px;"><span> {{ $transaction->created_at }} </span></li>
										</ul>
									</div>
								</div>
							</div>
							<div class="panel-body" style="padding: 10px;height:230px">
								<div class="row" style="margin-right: -10px;margin-left: -10px;">
									<div style="margin-bottom:0 !important; float: right; position: relative; min-height: 1px; padding-right: 10px; padding-left: 10px; width: 75%; color: #59524c;">
										<span style="color: #999;">{{ _i('Invoice to') }}</span>
										<ul style="padding-right: 0; list-style: none; margin-top: 0; margin-bottom: 10px;">
											<li style="margin-bottom: 15px;">
												<h5 style="font-family: inherit; font-weight: 400; line-height: 1.5384616; color: inherit; margin-top: 10px; margin-bottom: 10px; font-size: 17px;text-align:right">
													{{ $user->name }}
												</h5>
											</li>
											<li style="direction: ltr; text-align: right;margin-bottom: 5px;">
												{{ $user->phone ?? '' }}
											</li>
										</ul>
									</div>
									<div style="float: right; width: 25%; position: relative; min-height: 1px; padding-right: 10px; padding-left: 10px; color: #59524c;">
										<span style="color: #999;">{{ _i('Payment details') }}</span>
										<ul style="padding-right: 0; list-style: none; margin-top: 0; margin-bottom: 10px;text-align:right">
											<li style="margin-bottom: 15px;">
												<h5 style="font-family: inherit; font-weight: 400; line-height: 1.5384616; color: inherit; margin-top: 10px; margin-bottom: 10px; font-size: 17px;">
													{{ _i('Price') }}:
													<span style="text-align: left">{{ convert_numbers_to_arabic($transaction->price) }} {{ get_default_currency()->code }}</span>
												</h5>
											</li>
											<li style="margin-bottom: 15px;"> {{ _i('Payment method') }}:
												<span>
													{{ $transaction->payment_method }}
												</span>
											</li>
										</ul>
									</div>
									<div style="float: right; width: 25%; position: relative; min-height: 1px; padding-right: 10px; padding-left: 10px; color: #59524c;">
									</div>
								</div>
							</div>
							<div class="table-responsive" style="overflow-x: auto; min-height: .01%; border: 0; margin-bottom: 0;">
								<table class="table" style="border-collapse: collapse; border-spacing: 0; background-color: transparent; width: 100%; max-width: 100%; border-top: 1px solid #ddd;">
									<thead>
										<tr style="border-top-width: 0px; border-top-style: double; border-top-color: #ddd;">
											<th style="background-color: #fcfcfc !important; border: none; color: #888; font-size: 14px; padding: 10px 20px; line-height: 1.5384616; vertical-align: top; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; text-align: right;"> {{ _i('Package') }}</th>
											<th style="background-color: #fcfcfc !important; border: none; color: #888; font-size: 14px; padding: 10px 20px; line-height: 1.5384616; vertical-align: top; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; text-align: right; text-align: left">{{ _i('Price') }}</th>
											<th style="background-color: #fcfcfc !important; border: none; color: #888; font-size: 14px; padding: 10px 20px; line-height: 1.5384616; vertical-align: top; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; text-align: right; text-align: left">{{ _i('Total') }}</th>
										</tr>
									</thead>
									<tbody style="border-top: 1px solid #ddd;">
										<tr>
											<td style="padding: 10px 20px; line-height: 1.5384616; vertical-align: top; text-align: right; font-weight: bold">
												{{ $package->title }}
											</td>
											<td style="padding: 10px 20px; line-height: 1.5384616; vertical-align: top;  text-align: left">
												{{convert_numbers_to_arabic($transaction->price)}} {{ get_default_currency()->code }}
											</td>
											<td style="padding: 10px 20px; line-height: 1.5384616; vertical-align: top; text-align: left">
												<span>
													{{convert_numbers_to_arabic($transaction->price)}} {{ get_default_currency()->code }}
												</span>
											</td>
										</tr>
										<tr>
											<td style="padding: 10px 20px; line-height: 1.5384616; vertical-align: center; border-top: 1px solid #ddd; background-color: #f8f8f8;">
												{{ _i('Total') }}
											</td>
											<td style="color: #2196F3; text-align: left; padding: 10px 20px; line-height: 1.5384616; vertical-align: center; border-top: 1px solid #ddd; background-color: #f8f8f8;" colspan="3">
												<h5 style=" font-family: inherit; font-weight: 400; line-height: 1.5384616; color: inherit; margin-top: 10px; margin-bottom: 10px; font-size: 17px;">
													{{ convert_numbers_to_arabic($transaction->price) }} {{ get_default_currency()->code }}
												</h5>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<p style="color: #999;text-align: center;margin: 0 0 10px;"> شكراً لشرائك من المتجر. نتمنى لك يوماً رائعاً ! </p>
					</div>
				</div>
			</div>
		</div>
	</body>

</html>
