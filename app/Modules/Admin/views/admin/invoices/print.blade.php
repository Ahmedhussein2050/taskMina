<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
<style type="text/css">
#invoice{
	padding: 30px;
}

.invoice {
	position: relative;
	background-color: #FFF;
	min-height: 680px;
	padding: 15px
}

.invoice header {
	padding: 10px 0;
	margin-bottom: 20px;
	border-bottom: 1px solid #3989c6
}

.invoice .company-details {
	text-align: right
}

.invoice .company-details .name {
	margin-top: 0;
	margin-bottom: 0
}

.invoice .contacts {
	margin-bottom: 20px
}

.invoice .invoice-to {
	text-align: left
}

.invoice .invoice-to .to {
	margin-top: 0;
	margin-bottom: 0
}

.invoice .invoice-details {
	text-align: right
}

.invoice .invoice-details .invoice-id {
	margin-top: 0;
	color: #3989c6
}

.invoice main {
	padding-bottom: 50px
}

.invoice main .thanks {
	margin-top: -100px;
	font-size: 2em;
	margin-bottom: 50px
}

.invoice main .notices {
	padding-left: 6px;
	border-left: 6px solid #3989c6
}

.invoice main .notices .notice {
	font-size: 1.2em
}

.invoice table {
	width: 100%;
	border-collapse: collapse;
	border-spacing: 0;
	margin-bottom: 20px
}

.invoice table td,.invoice table th {
	padding: 15px;
	background: #eee;
	border-bottom: 1px solid #fff
}

.invoice table th {
	white-space: nowrap;
	font-weight: 400;
	font-size: 16px
}

.invoice table td h3 {
	margin: 0;
	font-weight: 400;
	color: #3989c6;
	font-size: 1.2em
}

.invoice table .qty,.invoice table .total,.invoice table .unit {
	text-align: right;
	font-size: 1.2em
}

.invoice table .no {
	color: #fff;
	font-size: 1.6em;
	background: #3989c6
}

.invoice table .unit {
	background: #ddd
}

.invoice table .total {
	background: #3989c6;
	color: #fff
}

.invoice table tbody tr:last-child td {
	border: none
}

.invoice table tfoot td {
	background: 0 0;
	border-bottom: none;
	white-space: nowrap;
	text-align: right;
	padding: 10px 20px;
	font-size: 1.2em;
	border-top: 1px solid #aaa
}

.invoice table tfoot tr:first-child td {
	border-top: none
}

.invoice table tfoot tr:last-child td {
	color: #3989c6;
	font-size: 1.4em;
	border-top: 1px solid #3989c6
}

.invoice table tfoot tr td:first-child {
	border: none
}

.invoice footer {
	width: 100%;
	text-align: center;
	color: #777;
	border-top: 1px solid #aaa;
	padding: 8px 0
}

@media print {
	.invoice {
		font-size: 11px!important;
		overflow: hidden!important;
	}

	.invoice footer {
		position: absolute;
		bottom: 10px;
		page-break-after: always;
	}

	.invoice>div:last-child {
		page-break-before: always;
	}
}
</style>
<!DOCTYPE html>
<html>
<head>
	<title>{{ _i('Invoice #') }} {{$invoice->no}}</title>
</head>
<body>
<div id="invoice">
	<div class="invoice overflow-auto">
		<div style="min-width: 600px">
			<header>
				<div class="row">
					<div class="col">
						@php
					//$setting = App\Models\Settings\Setting::first();
				//	dd($setting) ;
					@endphp
						<a target="_blank" href="{{ route('admin.home')}}>
							<img src="{{ asset('uploads/settings/site_settings/' . $setting->logo) }}" data-holder-rendered="true" />
						</a>
					</div>
					<div class='col text-center'><img src="data:'{{$qr_code_type}}';base64, {{$qr_code}}" /></div>
					<div class="col company-details">
						<h2 class="name">
							<a target="_blank" href="{{route('home', app()->getLocale())}}">
							{{$setting->title}}
							</a>
						</h2>
						<div>{{$setting->address}}</div>
						<div>{{$setting->phone1}}</div>
						<div>{{$setting->email}}</div>
					</div>
				</div>
			</header>
			<main>
				<div class="row contacts">
					<div class="col invoice-to">
						<div class="text-gray-light">INVOICE TO:</div>
						@if($user != NULL)
						<h2 class="to">{{$user->name}} {{$user->lastname}}</h2>
						<div class="address">{{$user->address}}</div>
						<div class="email"><a href="mailto:{{$user->email}}">{{$user->email}}</a></div>
						@endif
					</div>
					<div class="col invoice-details">
						<h1 class="invoice-id">INVOICE {{$invoice->no}}</h1>
						<div class="date">Date of Invoice: {{$invoice->date}}</div>
						<div class="date">Due Date: {{$invoice->due_date}}</div>
					</div>
				</div>
				<table border="0" cellspacing="0" cellpadding="0">
					<thead>
						<tr>
							<th>#</th>
							<th class="text-left">{{ _i('Product Name') }}</th>
							<th class="text-right">{{ _i('Price') }}</th>
							<th class="text-right">{{ _i('Quantity') }}</th>
							<th class="text-right">{{ _i('Total') }}</th>
						</tr>
					</thead>
					<tbody>
						@foreach($invoice->products AS $product)
						<tr>
							<td class="no">{{$product->product_id}}</td>
							<td class="text-left">
								<h3>
									<a target="_blank" href="#">
									{{$product->translation->title}}
									</a>
								</h3>
							</td>
							<td class="unit">{{$product->price}} {{$currency->code}}</td>
							<td class="qty">{{$product->quantity}}</td>
							<td class="total">{{$product->total_price}} {{$currency->code}}</td>
						</tr>
						@endforeach
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2"></td>
							<td colspan="2">SUBTOTAL</td>
							<td>{{$invoice->total}} {{$currency->code}}</td>
						</tr>
						<tr>
							<td colspan="2"></td>
							<td colspan="2">GRAND TOTAL</td>
							<td>{{$invoice->total}} {{$currency->code}}</td>
						</tr>
					</tfoot>
				</table>
				<div class="thanks">Thank you!</div>
			</main>
			<footer>
				Invoice was created on a computer and is valid without the signature and seal.
			</footer>
		</div>
	</div>
</div>
<script type="text/javascript">
window.onload = function() { window.print(); }
</script>
</body>
</html>
