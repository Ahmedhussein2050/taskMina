@php
$type = 'oneFree';
if (request()->query('type') == 'duration' || request()->query('type') == 'voucher' || request()->query('type') == 'voucher-free' || request()->query('type') == 'voucher-user-free' || request()->query('type') == 'extra') {
    $type = request()->query('type');
}
    $title = '';
    switch ($type) {
        case 'oneFree':
            # code...
            $title = _i('Create Buy N Get N Offer');
            break;
        case 'voucher':
            # code...
            $title = _i('Create Voucher Offer');
            break;
            case 'duration':
            # code...
            $title = _i('Create Duration  Offer');
            break;
            case 'extra':
            # code...
            $title = _i('Create Extra Offer');
            break;
			case 'voucher-user-free':
            # code...
            $title = _i('Create Gift Voucher');
            break;
			case 'voucher-free':
            # code...
            $title = _i('Create Marketing Voucher');
            break;

        default:
             $title =_i('Create Buy N Get N Offer');
            break;
}
@endphp
@extends('admin.layout.index',[
'title' => $title,
'subtitle' =>$title,
'activePageName' => $title,
'activePageUrl' => "#",
'additionalPageUrl' => route('admin.offer.index',["type"=> $type]) ,
'additionalPageName' => _i('Offers'),
])

@section('content')
    <div class="page-body">


<div class="card">
            <div class="card-block">
				<form method='post' action='{{ route('offers.store') }}' class='form-group'
				data-parsley-validate="">
				@csrf
				@switch($type)
					@case ('duration')
						@include("admin.offer.forms.duration")
					@break
					@case('oneFree')
						@include("admin.offer.forms.gift")
					@break
					@case('voucher')
						@include("admin.offer.forms.voucher")
					@break
                    @case('extra')
                        @include("admin.offer.forms.extra")
                    @break
					@case('voucher-user-free')
						@include("admin.offer.forms.voucher-user-free")

					@break
					@case('voucher-free')
						@include("admin.offer.forms.voucher-free")

					@break

					@default

				@endswitch
			</form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    @include('admin.layout.message')
    <script>
        $('.myselect').select2();
    </script>


@endpush
