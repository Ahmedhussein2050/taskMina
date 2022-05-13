@extends('admin.layout.index',
[
'title' => _i('Show Order'),
'subtitle' => _i('Show Order'),
'activePageName' => _i('Show Order'),
'activePageUrl' => '',
'additionalPageName' => _i('Orders'),
'additionalPageUrl' => route('admin.orders.index')
])

@section('content')
    @push('css')
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        <style>
            .dropdown-menu {
                z-index: 9999;
            }

        </style>
    @endpush
@section('content')
    <div class="">
        @include('admin.orders.partial.info')
    </div>

    <div class="row order-column">
        <div class="col-md-4">
            <div class="card user">
                <div class="card-header">
                    <h5>{{ _i('Client') }}</h5>
                </div>
                <div class="card-footer userIcon ">
                    <img src="@if ($order->user && $order->user->image != null) {{ asset('uploads/users/' . $order->user->id . '/' . $order->user->image) }}@else {{ asset('default_images/avatar_male.png') }} @endif"
                        border="0" style="max-width:80px; max-height:50px;" class="img-responsive img-rounded">
                    <div class="card-block-big text-center " style="display: inline-block; margin-top:-50px;">
                        <?php
                        $number = $order->user ? $order->user->phone : $order->phone;
                        $masked = str_pad(substr($number, -4), strlen($number), '*', STR_PAD_LEFT);
                        ?>
                        <span> {{ $order->user ? $order->user->name : $order->name }}</span>
                        <p>{{ $order->user ? $order->user->email : $order->email }}</p>
                        <p>{{ $masked }}</p>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="notification">
                            <span> <i class="icofont icofont-notification"></i> {{ _i('Notification') }} </span>
                        </a>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="sms">
                            <span> <i class="icofont icofont-ui-messaging"></i> {{ _i('Text message') }} </span>
                        </a>
                        <br>
                        <a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#sendGroup"
                            data-type="email">
                            <span> <i class="icofont icofont-ui-message"></i> {{ _i('Email') }} </span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card user">
                <div class="card-header">
                    <h5>{{ _i('Shipping Information') }} </h5>
                </div>
                <div class="card-footer userIcon ">
                    <div class="card-block-big text-center">
                        @php
                            $company = null;
                            if ($order->shipping_option != null) {
                                $company = App\Modules\Orders\Models\Shipping\ShippingCompaniesData::where('shipping_company_id', $order->shipping_option->company_id)
                                    ->where('lang_id', \App\Bll\Lang::getSelectedLangId())
                                    ->first();
                            }
                        @endphp
                        @if ($company != null)
                            <p><span>{{ _i('Company') }} : </span>{{ $company->title }} </p>
                            <p><span>{{ _i('Delay') }} : </span>{{ $order->shipping_option->delay }}
                                <span>{{ _i('Day') }} </span>
                            </p>
                            <p><span>{{ _i('Cost') }} : </span>{{ $order->shipping_option->cost }} </p>

                            @if ($order->shipping)
                                <p><span>{{ _i('Country') }} :
                                    </span>{{ $order->shipping ? ($order->shipping->country ? $order->shipping->country->data->first()->title : '') : '' }}
                                </p>
                                <p><span>{{ _i('Governorate') }} :
                                    </span>{{ $order->shipping ? ($order->shipping->city ? $order->shipping->city->data->title : '') : '' }}
                                </p>
                                <p><span>{{ _i('Region') }} :
                                    </span>{{ $order->shipping->region ?: '' }}</p>

                                <p><span>{{ _i('Street') }} : </span>{{ $order->shipping->street ?? '' }}</p>
                                <p><span>{{ _i('El Gada') }} : </span>{{ $order->shipping->address ?? '' }}</p>
                                <p><span>{{ _i('Home number') }} : </span>{{ $order->shipping->Neighborhood ?? '' }}
                                </p>
                                <p><span>{{ _i('note') }} :
                                        {{ $order->shipping->note ?? '' }}
                                    </span></p>
                            @endif
                        @else
                            @php
                                $address = $order
                                    ->addresses()
                                    ->orderBy('id', 'DESC')
                                    ->first();
                            @endphp
                            @if ($order->user_id == 0 && $address)
                                {{-- {{dd($address)}} --}}
                                <p><span>{{ _i('Country') }} :
                                        {{ \App\Models\countries::find($address->country_id)? \App\Models\countries::find($address->country_id)->data->title: '' }}
                                    </span></p>
                                <p><span>{{ _i('Governorate') }} :
                                        {{ \App\Models\cities::find($address->city_id) ? \App\Models\cities::find($address->city_id)->data->title : '' }}
                                    </span></p>
                                <p><span>{{ _i('Region') }} :
                                        {{ \App\Site\Region::find($address->region_id) &&
                                        \App\Site\Region::find($address->region_id)->data()->first()
                                            ? \App\Site\Region::find($address->region_id)->data()->first()->title
                                            : '' }}
                                    </span></p>
                                <p><span>{{ _i('Street') }} :
                                        {{ $address->street }}
                                    </span></p>
                                <p><span>{{ _i('El Gada') }} :
                                        {{ $address->address }}
                                    </span></p>
                                <p><span>{{ _i('Home Number') }} :
                                        {{ $address->Neighborhood }}
                                    </span></p>
                                <p><span>{{ _i('Block') }} :
                                        {{ $address->block }}
                                    </span></p>
                                <p><span>{{ _i('note') }} :
                                        {{ $address->note }}
                                    </span></p>
                            @endif
                        @endif

                    </div>
                </div>
            </div>
        </div>

        @include('admin.orders.partial.payment')

        @include('admin.orders.includes.edit.ordertable', [
            'products' => $order->orderProducts,
        ])



    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $number }}#{{ _i('order Status') }}</h5>
                    <button type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form method="post" id="form-sub" data-parsley-validate="">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="container">

                            <div class="row form-group">
                                <select name="status_id" class="form-control selectpicker status">
                                    @foreach ($status as $sta)
                                        <option value="{{ $sta->code }}" data-code="{{ $sta->code }}"
                                            @if ( $order->status == $sta->code) selected @endif>{{ $sta->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="row form-group balancee" style="display: none">
                                <input type="number" name="balance" value="" class="form-control"
                                    placeholder="{{ _i('enter balance added to client') }}">
                            </div>
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <div class="row form-group">
                                <textarea name="comments" class="form-control" placeholder="{{ _i('note by client') }}"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ _i('Save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('admin.orders.show_includes.send_modal')

@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $("#color-pic").colorpicker();
        })

        $(function() {
            'use strict'
            $('.selectpicker').on('change', function(e) {
                $(this).next().next().addClass('show');
            })
            $('body').click(function() {
                $('.selectpicker').next().next().removeClass('show');
            })
        })
        $(function() {
            $('body').on('submit', '#form-sub', function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('review-order') }}",
                    method: "post",
                    data: new FormData(this),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,

                    success: function(response) {
                        if (response.status == 'ok') {
                            $("#btn_status").text($("select[name='status_id'] option:selected")
                                .text());
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Added is Successfly') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $modal = $('#exampleModal');
                            $modal.find('form')[0].reset();
                        }
                        if (response.status == 'false') {
                            new Noty({
                                type: 'success',
                                layout: 'topRight',
                                text: "{{ _i('Order Was Rejected Or Canceled') }}",
                                timeout: 2000,
                                killer: true
                            }).show();
                            $modal = $('#exampleModal');
                            $modal.find('form')[0].reset();
                        }
                    },
                });
            });
        })

        $('.status').on('change', function(e) {
            var type = $(this).find(':selected').data('code');
            console.log(type)
            if (type == 'complete_refund') {
                $('.balancee').show();
            }else{
                $('.balancee').hide();
            }
        })
    </script>
@endpush
