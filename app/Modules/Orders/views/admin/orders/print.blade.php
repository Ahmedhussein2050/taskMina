
@include('.admin.orders.account.print')

{{--<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">--}}
{{--<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>--}}
{{--<style type="text/css">--}}
{{--#invoice{--}}
	{{--padding: 30px;--}}
{{--}--}}

{{--.invoice {--}}
	{{--position: relative;--}}
	{{--background-color: #FFF;--}}
	{{--min-height: 680px;--}}
	{{--padding: 15px--}}
{{--}--}}

{{--.invoice header {--}}
	{{--padding: 10px 0;--}}
	{{--margin-bottom: 20px;--}}
{{--}--}}

{{--.invoice .company-details {--}}
	{{--text-align: right--}}
{{--}--}}

{{--.invoice .company-details .name {--}}
	{{--margin-top: 0;--}}
	{{--margin-bottom: 0--}}
{{--}--}}

{{--.invoice .contacts {--}}
	{{--margin-bottom: 20px--}}
{{--}--}}

{{--.invoice .invoice-to {--}}
	{{--text-align: left--}}
{{--}--}}

{{--.invoice .invoice-to .to {--}}
	{{--margin-top: 0;--}}
	{{--margin-bottom: 0--}}
{{--}--}}

{{--.invoice .invoice-details {--}}
	{{--text-align: right--}}
{{--}--}}

{{--.invoice .invoice-details .invoice-id {--}}
	{{--margin-top: 0;--}}
	{{--color: #3989c6--}}
{{--}--}}

{{--.invoice main {--}}
	{{--padding-bottom: 0px--}}
{{--}--}}

{{--.thanks {--}}
	{{--margin-top: -100px;--}}
	{{--font-size: 2em;--}}
	{{--margin-bottom: 50px;--}}
	{{--text-align: center;--}}
{{--}--}}

{{--.invoice main .notices {--}}
	{{--padding-left: 6px;--}}
	{{--border-left: 6px solid #3989c6--}}
{{--}--}}

{{--.invoice main .notices .notice {--}}
	{{--font-size: 1.2em--}}
{{--}--}}

{{--.invoice table {--}}
	{{--width: 100%;--}}
	{{--border-collapse: collapse;--}}
	{{--border-spacing: 0;--}}
	{{--margin-bottom: 20px--}}
{{--}--}}

{{--.invoice table td,.invoice table th {--}}
	{{--padding: 15px;--}}
	{{--background: #eee;--}}
	{{--border-bottom: 1px solid #fff--}}
{{--}--}}

{{--.invoice table th {--}}
	{{--white-space: nowrap;--}}
	{{--font-weight: 400;--}}
	{{--font-size: 16px--}}
{{--}--}}

{{--.invoice table td h3 {--}}
	{{--margin: 0;--}}
	{{--font-weight: 400;--}}
	{{--color: #3989c6;--}}
	{{--font-size: 1.2em--}}
{{--}--}}

{{--.invoice table .qty,.invoice table .total,.invoice table .unit {--}}
	{{--text-align: right;--}}
	{{--font-size: 1.2em--}}
{{--}--}}

{{--.invoice table .no {--}}
	{{--color: #fff;--}}
	{{--font-size: 1.6em;--}}
	{{--background: #3989c6--}}
{{--}--}}

{{--.invoice table .unit {--}}
	{{--background: #ddd--}}
{{--}--}}

{{--.invoice table .total {--}}
	{{--background: #3989c6;--}}
	{{--color: #fff--}}
{{--}--}}

{{--.invoice table tbody tr:last-child td {--}}
	{{--border: none--}}
{{--}--}}

{{--.invoice table tfoot td {--}}
	{{--background: 0 0;--}}
	{{--border-bottom: none;--}}
	{{--white-space: nowrap;--}}
	{{--text-align: right;--}}
	{{--padding: 10px 20px;--}}
	{{--font-size: 1.2em;--}}
	{{--border-top: 1px solid #aaa--}}
{{--}--}}

{{--.invoice table tfoot tr:first-child td {--}}
	{{--border-top: none--}}
{{--}--}}

{{--.invoice table tfoot tr:last-child td {--}}
	{{--color: #3989c6;--}}
	{{--font-size: 1.4em;--}}
	{{--border-top: 1px solid #3989c6--}}
{{--}--}}

{{--.invoice table tfoot tr td:first-child {--}}
	{{--border: none--}}
{{--}--}}

{{--.invoice footer {--}}
	{{--width: 100%;--}}
	{{--text-align: center;--}}
	{{--color: #777;--}}
	{{--border-top: 1px solid #aaa;--}}
	{{--padding: 8px 0--}}
{{--}--}}

{{--@media print {--}}
	{{--.invoice {--}}
		{{--font-size: 11px!important;--}}
		{{--overflow: hidden!important;--}}
	{{--}--}}

	{{--.invoice footer {--}}
		{{--position: absolute;--}}
		{{--bottom: 10px;--}}
		{{--page-break-after: always;--}}
	{{--}--}}

	{{--.invoice>div:last-child {--}}
		{{--/*page-break-before: always;*/--}}
	{{--}--}}
{{--}--}}
{{--</style>--}}
{{--<!DOCTYPE html>--}}
{{--<html>--}}
{{--<head>--}}
	{{--<title>{{ _i('Invoice #') }} {{$order->no}}</title>--}}
{{--</head>--}}
{{--<body dir="{{getLang() == 1 ? 'ltr' : 'rtl'}}">--}}
{{--<div id="invoice">--}}
	{{--<div class="invoice overflow-auto">--}}
		{{--<div style="min-width: 600px">--}}
			{{--<header>--}}
				{{--<div class="row">--}}
					{{--<div class="col">--}}
						{{--<a target="_blank" href="#" class="float-right">--}}

							{{--<img src="{{get_default_images()->header}}" data-holder-rendered="true" style="width: 150px;height:150px;"/>--}}

						{{--</a>--}}
					{{--</div>--}}
					{{--<div class='col text-center'><img src="data:'{{$qr_code_type}}';base64, {{$qr_code}}" class="float-left"/></div>--}}
				{{--</div>--}}
			{{--</header>--}}

			{{--<div class="col company-details">--}}

				{{--<div class="order_details">--}}
					{{--<ul class="list-unstyled">--}}
						{{--<li>--}}
							{{--{{_i('Invoice number')}}: {{$order->ordernumber}}--}}
						{{--</li>--}}
						{{--<li>--}}
							{{--{{_i('Shipping number')}}: {{$order->ordernumber}}--}}
						{{--</li>--}}
						{{--<li>--}}
							{{--{{_i('Vat number')}}: {{$order->ordernumber}}--}}
						{{--</li>--}}
					{{--</ul>--}}
				{{--</div>--}}

				{{--<h2 class="name" style="text-align: center">--}}
					{{--{{$setting->title}}--}}
				{{--</h2>--}}

				{{--<div class="user_information" style="margin-top: 30px;">--}}
					{{--<h4 style="text-align: center;">{{_i('Customer Information')}}</h4>--}}

					{{--<div style="display: flex;text-align:center;margin-top:20px;">--}}
						{{--<div style="flex: 1 1 auto">--}}
							{{--<p>{{_i('Customer name')}}</p>--}}
							{{--<p>{{$user->name}} {{$user->lastname}}</p>--}}
						{{--</div>--}}
						{{--<div style="flex: 1 1 auto">--}}
							{{--<p>{{_i('Phone number')}}</p>--}}
							{{--<p>{{$user->phone}}</p>--}}
						{{--</div>--}}
						{{--<div style="flex: 1 1 auto">--}}
							{{--<p>{{_i('Payment Method')}}</p>--}}
							 {{--<p>{{$paymentGate}}</p>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
			{{--</div>--}}
			{{--<main style="">--}}
				{{--<div class="row contacts">--}}
					{{--<h4 style="margin: 30px 0;display:block;text-align:center;width:100%">--}}
						{{--{{_i('Invoice information')}}--}}
					{{--</h4>--}}
				{{--<table border="0" cellspacing="0" cellpadding="0">--}}
					{{--<thead>--}}
						{{--<tr>--}}
							{{--<th>#</th>--}}
							{{--<th class="text-left">{{ _i('Product Name') }}</th>--}}
							{{--<th class="text-right">{{ _i('Quantity') }}</th>--}}
							{{--<th class="text-right">{{ _i('Price') }}</th>--}}
							{{--<th class="text-right">{{ _i('Total') }}</th>--}}
						{{--</tr>--}}
					{{--</thead>--}}
					{{--<tbody>--}}

						{{--@php--}}
							{{--$subtotal = 0;--}}
						{{--@endphp--}}

						{{--@foreach($order->orderProducts as $key => $product)--}}
						{{--<tr>--}}
							{{--<td class="no">{{$key+1}}</td>--}}
							{{--<td class="text-left">--}}
								{{--<h3>--}}
									{{--<a target="_blank" href="{{route('home_product.show',[app()->getLocale(),$product->product_id])}}">--}}
									{{--{{$product->product->translation->title}}--}}
									{{--</a>--}}
								{{--</h3>--}}
							{{--</td>--}}
							{{--<td class="qty">{{$product->count}}</td>--}}
							{{--<td class="unit">{{apply_discount_code_on_price($product->price, $product->discount, 'perc')['price']}} {{ $transactions->currency }}</td>--}}

							{{-- <td class="qty">{{$order->shipping_cost??0}}</td>--}}
							{{--<td class="qty">{{$order->tax_cost??0}}</td> --}}

							{{--<td class="total">{{apply_discount_code_on_price($product->price, $product->discount, 'perc')['price'] * $product->count}} {{$transactions->currency }}</td>--}}
						{{--</tr>--}}

							{{--@php--}}
								{{--$subtotal += apply_discount_code_on_price($product->price, $product->discount, 'perc')['price'] * $product->count;--}}
							{{--@endphp--}}
						{{--@endforeach--}}


					{{--</tbody>--}}
					{{--<tfoot>--}}
						{{--<tr>--}}
							{{--<td colspan="2"></td>--}}
							{{--<td colspan="2">{{_i('Tax')}}</td>--}}
							{{--<td>{{$order->tax_percent}}%</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td colspan="2"></td>--}}
							{{--<td colspan="2">{{_i('Tax (SAR)')}}</td>--}}
							{{--<td>{{$order->tax_cost}} {{$transactions->currency }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td colspan="2"></td>--}}
							{{--<td colspan="2">{{_i('Shipping Cost')}}</td>--}}
							{{--<td>{{$order->shipping_cost}} {{$transactions->currency }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td colspan="2"></td>--}}
							{{--<td colspan="2">SUBTOTAL</td>--}}
							{{--<td>{{$subtotal}} {{$transactions->currency }}</td>--}}
						{{--</tr>--}}
						{{--<tr>--}}
							{{--<td colspan="2"></td>--}}
							{{--<td colspan="2">GRAND TOTAL</td>--}}
							{{--<td>{{$order->total}} {{$currency->code}}</td>--}}
						{{--</tr>--}}
					{{--</tfoot>--}}
				{{--</table>--}}


			{{--</main>--}}
			{{--<div class="thanks" style="font-size: 15px;margin-top:0">{{_i('Thank you for shopping on Soin')}}!</div>--}}

			{{--<footer>--}}
				{{--{{_i('Invoice was created on a computer and is valid without the signature and seal.')}}--}}
			{{--</footer>--}}
		{{--</div>--}}
	{{--</div>--}}
{{--</div>--}}
{{--<script type="text/javascript">--}}
{{--window.onload = function() { window.print(); }--}}
{{--</script>--}}
{{--</body>--}}
{{--</html>--}}
