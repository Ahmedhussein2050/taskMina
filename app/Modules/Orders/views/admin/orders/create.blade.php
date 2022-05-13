@extends('admin.layout.index',[
    'title' => _i('Orders'),
    'subtitle' => _i('Orders'),
    'activePageName' => _i('Orders'),
    'activePageUrl' => route('admin.orders.index'),
    'additionalPageName' => _i('Settings'),
    'additionalPageUrl' => route('settings.index')
] )
@section('content')
    @push('css')
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <style>
            .product-desc .dropdown-item {
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
            body .modal {
                z-index: 80000;
            }
            body .swal2-container {
                z-index: 999999999;
            }
        </style>
    @endpush
    @push("js")
        <script>
            $(function () {
                'use strict'
                $('.selectpicker').on('change', function (e) {
                    $(this).next().next().addClass('show');
                })
                $('body').click(function () {
                    $('.selectpicker').next().next().removeClass('show');
                })
            })
        </script>
    @endpush

    <div class="orderList">
        <div class="card order-info-panel">
            <div class="card-body text-center row">
                <div class="col-sm-4">
                    <span class="order-top-line">
                        {{_i("Order No")}}
                    </span>
                    <div class="order-second-line">
                        {{$number}}
                    </div>
                </div>
                <div class="col-sm-4">
                    <span class="order-top-line">
                        {{_i("Date")}}
                    </span>
                    <div class="order-second-line">
                        {{\Carbon\Carbon::now()->format('d/m/Y')}}
                    </div>
                </div>
                <div class="col-sm-4">
                    <span class="order-top-line">
                        {{_i("Order Status")}}
                    </span>
                    <div class="order-second-line">
                        {{_i("New")}}
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('myfatoorah_admin') }}" target="_blank" method="POST" id="myfatoorah_form">
            @csrf
        </form>
        <form method="post" id="prod-form">
            @csrf
            @method('post')
            <div class="row order-column">
                @include('admin.orders.includes.orderuser')
                @include('admin.orders.includes.shipping')
                @include('admin.orders.includes.payment')
                @include('admin.orders.includes.ordertable')
            </div>
        </form>
    </div>

@endsection

@push('js')
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script>
		function calculate() {
			var payment_id = $('.payment_id').val();
			var price = 0;
			var cod__cost = 0;
			$('.Subtotal').each(function ($index) {
				price += parseFloat($(this).html().replace(/,/g, ''));
			});
			$('.total__befor').html($.number(price, 3));
			var total = parseFloat($('.total__befor').html().replace(/,/g, ''));
			var Shipping__cost = parseFloat($('.Shipping__cost').html());
			if( isNaN( Shipping__cost ) )
			{
				Shipping__cost = 0;
			}
			if( payment_id == 16 )
			{
				cod__cost = parseFloat($('.cod__cost').html());
				if( isNaN( cod__cost ) )
				{
					cod__cost = 0;
				}
				$('.cod_row').removeAttr('hidden');
			}
			else
			{
				$('.cod_row').attr('hidden', true);
			}
			if( isNaN( cod__cost ) )
			{
				cod__cost = 0;
			}
			console.log(Shipping__cost, cod__cost, total);
			$('.total').html($.number(total + Shipping__cost + cod__cost, 3));
		}
        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                $('#article_img').attr('src', e.target.result).width(250).height(250);
            };
            filereader.readAsDataURL(input.files[0]);
        }

        function saveall() {
            if (shipping_option_id == 'not_existed') {
                Swal.fire({
                    title: 'تنبيه',
                    text: "المنطقة التى قمت بإختيارها لا يوجد بها شحن",
                    type: 'warning',
                });
                return;
            }
            axios.post('../admin/saveallorders', {
                //order: this.getorder,
                user: this.user,
                address: this.address,
                street: this.street,
                neighborhood: this.neighborhood,
                shippingOption: this.shipping_option_id,
                product: this.SavedProducts,
                ordernumber: {!! $number !!},
                totalprice: this.totalprice,
                cityId: this.cityId,
                country: this.country,
                //shippingOption: this.shippingOption,
                //payment: this.payment
                payment: this.paymentId
            }).then(function (data) {
                //_this.order = data.data;
                Swal.fire({
                    position: 'top-end',
                    title: "{{_i('done')}}",
                    showConfirmButton: false,
                    timer: 3000
                });
                //_this.ordervisible = false;
                // window.location.href = '../admin/orders/all';
            });

        }

        $(function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('body').on('submit', '#prod-form', function (e) {
                e.preventDefault();
                $('#prod-form').find('button[type="submit"]').attr("disabled", true);
                var orderNumber = $('.order-second-line').html();
                var totalprice = $('.total').html();
                var formData = new FormData(this);
                formData.append('ordernumber', orderNumber);
                formData.append('totalprice', totalprice);
                $.ajax({
                    url: "{{route('save-new-Product')}}",
                    method: "post",
                    data: formData,
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (response) {
                        if (response.status == 'success') {
                            $('#prod-form').find('button[type="submit"]').attr("disabled", false);
                            Swal.fire({
                                position: 'top-end',
                                title: "{{_i('done')}}",
                                showConfirmButton: false,
                                timer: 3000
                            });
                            window.location.reload();
                        } else {
                            $('#prod-form').find('button[type="submit"]').attr("disabled", false);
                            Swal.fire({
                                position: 'top-end',
                                title: "{{_i('You shoud complete data')}}",
                                showConfirmButton: false,
                                timer: 3000
                            });
                        }
                    },
                });
            })
        })
    </script>
@endpush
