@extends('admin.layout.index',
[
'title' => _i('Edit Order'),
'subtitle' => _i('Edit Order'),
'activePageName' => _i('Edit Order'),
'activePageUrl' => '',
'additionalPageName' => _i('Orders'),
'additionalPageUrl' => route('admin.orders.index')
])

@push('css')
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        .dropdown-item {
            display: block;
            width: 100%;
            padding: .25rem 0 .25rem 1.5rem;
            clear: both;
            font-weight: 400;
            color: #212529;
            text-align: right;
            white-space: nowrap;
            background: 0 0;
            border: 0;
        }

        .type .dropdown-item {
            text-align: right;
        }

        .product-desc .bootstrap-select.show-tick .dropdown-menu li a span.text {
            margin-left: 34px;
        }

        .dropdown-menu {
            z-index: 9999;
        }

    </style>
@endpush

@section('content')
    @include('admin.orders.partial.info')
    <form action="{{ route('myfatoorah_admin') }}" target="_blank" method="POST" id="myfatoorah_form">
        @csrf
    </form>
    <form method="post" id="prod-form">
        @csrf
        @method('post')
        <input type="hidden" form="prod-form" name="order_id" value="{{ $order->id }}">
        <!--<input type="hidden" form="prod-form" name="user_id" value="{{ $order->user_id }}">-->
        <div class="row order-column">
            @include('admin.orders.includes.edit.orderuser')
            @include('admin.orders.includes.edit.shipping')
            @include('admin.orders.partial.payment')
            @include('admin.orders.includes.edit.ordertable', ['edit'])
        </div>
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _i('order Status') }}: #{{ $number }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" id="form-sub" data-parsley-validate="">
                    @csrf
                    @method('post')
                    <div class="modal-body">
                        <div class="container">
                            <div class="row form-group">
                                {!! Form::select('status_id', $status->pluck('title', 'id'), $status_id, ['name' => 'status_id', 'class' => 'form-control selectpicker', 'required' => '']) !!}
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
@endsection

@push('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
        $(function() {
            'use strict';
            $('.selectpicker').on('change', function(e) {
                $(this).next().next().addClass('show');
            });
            $('body').click(function() {
                $('.selectpicker').next().next().removeClass('show');
            })
        });

        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                $('#article_img').attr('src', e.target.result).width(250).height(250);
            };
            filereader.readAsDataURL(input.files[0]);
        }
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('body').on('submit', '#prod-form', function(e) {
                e.preventDefault();
                var orderNumber = $('.order-second-line').html();
                var totalprice = $('.total').html();
                var formData = new FormData(this);
                formData.append('ordernumber', orderNumber);
                formData.append('totalprice', totalprice);
                $.ajax({
                    url: "{{ route('update-Product') }}",
                    method: "post",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            Swal.fire({
                                position: 'top-end',
                                title: "{{ _i('done') }}",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                title: "{{ _i('You shoud complete data') }}",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                });
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
                                text: "{{ _i('Order status has been changed successfully !') }}",
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
    </script>
@endpush
