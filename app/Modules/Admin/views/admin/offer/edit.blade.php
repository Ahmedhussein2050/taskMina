@php
$disabled = $offer->allow_edit == '1' ? '' : 'disabled';
    $type = 'oneFree';
    if ($offercategory->code == 'duration' || $offercategory->code == 'extra' || $offercategory->code == 'voucher' || $offercategory->code == 'voucher-free' || $offercategory->code == 'voucher-user-free') {
        $type = $offercategory->code;
    }
        $title = '';
        switch ($type) {
            case 'oneFree':
                # code...
                $title = _i('Edit Gift Offer Code');
                break;
            case 'voucher':
                # code...
                $title = _i('Edit voucher');
                break;
                case 'duration':
                # code...
                $title = _i('Edit duration');
                break;
                case 'extra':
                # code...
                $title = _i('Edit extra');
                break;
                case 'voucher-free':
                # code...
                $title = _i('Edit Marketing Voucher');
                break;
                case 'voucher-user-free':
                # code...
                $title = _i('Edit Voucher-User-Free');
                break;

            default:
                 $title = _i('Edit Gift Offer Code');
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
                <div class="row m-b-30">
                    <div class="col-lg-12 col-xl-12">

                        <!-- Nav tabs -->
                        <!-- Tab panes -->
                        <form method='post' action='{{ route('offers.update',$offer->id) }}' class='form-group'
                            data-parsley-validate="">
                            @csrf
                            @switch($type)
                                @case ('duration')
                                    @include("admin.offer.edit.editDuration")
                                @break
                                @case('oneFree')
                                    @include("admin.offer.edit.editGift")
                                @break
                                @case('voucher')
                                    @include("admin.offer.edit.editVoucher")
                                @break
                                @case('extra')
                                    @include("admin.offer.edit.editExtra")
                                @break
                                @case('voucher-free')
                                    @include("admin.offer.edit.edit-Voucher-free")
                                @break
                                @case('voucher-user-free')
                                    @include("admin.offer.edit.edit-voucher-user-free")
                                @break

                                @default

                            @endswitch
                        </form>

                    </div>
                </div>
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
