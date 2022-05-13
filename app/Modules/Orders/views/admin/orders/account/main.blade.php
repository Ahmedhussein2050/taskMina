@php
$user = auth()->user();
// dd($exp[5]);

if ($order->taxes->isNotEmpty()) {
	$taxes = $order->taxes->first();
} else {
	$taxes = null;
}
$vat_total = 0;
$payment = $payment ?? null;
$shipping = $shipping ?? null;
//  dd($order->orderProducts[1]->product->product_photos);
@endphp
<div class="text-center" style="background: #6f30a0; color: #fff;">{{ _i('Client Information') }}
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
	<thead>
		<tr>
			<th class="">{{ _i('Payment method') }}</th>
			<th>{{_i("Transaction Number")}}</th>

			<th class="">{{ _i('Phone Number') }}</th>
			<th class="">{{ _i('Client Name') }}</th>

		</tr>
	</thead>
	<tbody>

		<tr>
			<td class="">
				<img src="{{ asset($order->transaction && $order->transaction->gateway ? $order->transaction->gateway->image : '') }}" height="60" alt="{{$order->transaction && $order->transaction->gateway ? $order->transaction->gateway->image : '' }}">
				{{ $order->transaction && $order->transaction->gateway ? $order->transaction->gateway->name : $payment->name ?? '' }}
			</td>
			<td>{{$order->transaction ? $order->transaction->payment_id : ''}}</td>
			<td class="">{{ $user->phone }}</td>
			<td class="">{{ $user->name }} {{ $user->lastname }}</td>

		</tr>

	</tbody>
</table>

<table border="0" cellspacing="0" cellpadding="0" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
	<thead>

		@if ($shipping != null)
			<tr>

				<th class="text-center">{{ _i('address') }}</th>
				<th class="text-center">{{ _i('street') }}</th>
				<th class="text-center">{{ _i('Neighborhood') }}</th>

			</tr>
		@endif

	</thead>
	<tbody>

		@if ($shipping != null)
			<tr>

				<td class="text-center">{{ $shipping->address ?? '' }}</td>
				<td class="text-center">{{ $shipping->street ?? '' }} </td>
				<td class="text-center">{{ $shipping->Neighborhood ?? '' }} </td>

			</tr>
		@endif
	</tbody>
</table>

<div class="text-center" style="background: #6f30a0; color: #fff;">{{ _i('Order Details') }}
</div>

@include('.admin.orders.account.order-table')


<div class="thanks text-center" style="color: #6f30a0;">❤ {{ _i('Thank you for your shopping') }} ❤
</div>
<div class="row">
	<div class="col-sm-8">
		<div class="thanks" style="color: #6f30a0;">{{ _i('Terms and Conditions Apply') }}
		</div>
	</div>
	<div class="col-sm-4">
		<div class="row">
			<div class="col-sm-6">
				<div class="row">
					<div class="col-sm-4">
						<img src="{{ asset('uploads/twitter.svg') }}" data-holder-rendered="true"
							class="img-fluid" />
					</div>
					<div class="col-sm-4">
						<img src="{{ asset('uploads/snapchat.svg') }}" data-holder-rendered="true"
							class="img-fluid" />
					</div>
					<div class="col-sm-4">
						<img src="{{ asset('uploads/instagram.svg') }}" data-holder-rendered="true"
							class="img-fluid" />
					</div>
				</div>
			</div>
			<div class="col-sm-6">
				SOIN.KSA
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2">
				<img src="{{ asset('uploads/mail.svg') }}" data-holder-rendered="true"
					class="img-fluid" />
			</div>
			<div class="col-sm-10">
				info@soinksa.com
			</div>
		</div>
	</div>
</div>
