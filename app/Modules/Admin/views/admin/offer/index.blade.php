@php
$type = 'oneFree';
if (request()->query('type') == 'voucher' || request()->query('type') == 'duration' || request()->query('type') == 'voucher-user-free' || request()->query('type') == 'voucher-free' || request()->query('type') == 'extra') {
    $type = request()->query('type');
}
$add = 'offers/create';
@endphp
@extends('admin.layout.index',[
'title' => _i('Offers'),
'subtitle' => _i('Offers'),
'activePageName' => _i('Offers'),
'activePageUrl' => "#",
// 'additionalPageName' => _i('Settings'),
// 'additionalPageUrl' => route('settings.index')
])
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>

    <div class="page-body">
        <div class="row">
            <div class="col-md-12">

                <a href="offers?type=oneFree" class="@if ($type == 'oneFree') btn btn-primary @endif">{{ _i('Buy N Get N Free') }} </a> |

                <a href="offers?type=duration" class="@if ($type == 'duration') btn btn-primary @endif">{{ _i('Duration') }} </a> |
                <a href="offers?type=extra" class="@if ($type == 'extra') btn btn-primary @endif">{{ _i('Extra') }} </a> |
                <a href="offers?type=voucher" class="@if ($type == 'voucher') btn btn-primary @endif">{{ _i('Vouchers') }} </a> |
                <a href="offers?type=voucher-user-free" class="@if ($type == 'voucher-user-free') btn btn-primary @endif">{{ _i('Voucher User Free') }}
                </a>
                |
                <a href="offers?type=voucher-free" class="@if ($type == 'voucher-free') btn btn-primary @endif">{{ _i('Marketing Vouchers') }} </a>



            </div>
        </div>


        <div class="card blog-page">
            <div class="card-header">
                <h5>@switch($type)
                        @case('oneFree')
                            {{ _i('Buy N Get N Free') }}
                            @php
                                $add = 'offers/create?type=oneFree';
                            @endphp
                        @break
                        @case('voucher')
                            {{ _i('Vouchers Offer') }}
                            @php
                                $add = 'offers/create?type=voucher';
                            @endphp

                        @break
                        @case('duration')
                            {{ _i('Duration') }}
                            @php
                                $add = 'offers/create?type=duration';
                            @endphp

                        @break
                        @case('extra')
                            {{ _i('Extra Offers') }}
                            @php
                                $add = 'offers/create?type=extra';
                            @endphp

                        @break
                        @case('voucher-user-free')
                            {{ _i('Voucher User Free') }}
                            @php
                                $add = 'offers/create?type=voucher-user-free';
                            @endphp

                        @break
                        @case('voucher-free')
                            {{ _i('Create Marketing Voucher') }}
                            @php
                                $add = 'offers/create?type=voucher-free';
                            @endphp

                        @break
                        @default
                            {{ _i('Buy N Get N Free') }}

                    @endswitch
                </h5>

                <a href="{{ $add }}" class="btn btn-primary"><i class="ti-plus"></i> </a>

            </div>

            <div class="card-block ">
                <table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
                    width="100%">
                    <thead>

                        <tr role="row">
                            <th>{{ _i('CreatedBy') }}</th>
                            <th>{{ _i('Title') }}</th>
                            <th>{{ _i('Used Time') }}</th>
                            <th>{{ _i('Status') }}</th>

                            {{-- <th>{{ _i('Free Products') }}</th> --}}
                            <th>{{ _i('From') }}</th>
                            <th>{{ _i('To') }}</th>
                            <th>{{ _i('action') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('js')
        <script type="text/javascript">
            var table;

            function init(url = "{{ route('admin.offer.index') }}?type=<?= $type ?>") {
                table = $('#order_data').DataTable({
                    "order": [],
                    "dom": "Blfrtip",
                    "buttons": [{
                            "extend": "print",
                            "className": "btn btn-primary",
                            "text": "<i class=\"ti-printer\"><\/i>"
                        },


                    ],
                    "responsive": true,
                    "processing": true,
                    "serverSide": true,
                    ajax: {
                        url: url,
                    },
                    columns: [{
                            data: 'created_at'
                        },
                        {
                            data: 'title'
                        },
                        {
                            data: 'usedTime'
                        },
                        {
                            data: 'status'
                        },
                        // {
                        //     data: 'freeproducts'
                        // },
                        {
                            data: 'start_date'
                        },
                        {
                            data: 'end_date'
                        },
                        {
                            data: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    drawCallback: function() {
                        // Multiple swithces
                        var elem = Array.prototype.slice.call(document.querySelectorAll('.js-switch2'));

                        elem.forEach(function(html) {
                            var switchery = new Switchery(html, {
                                color: '#1abc9c',
                                jackColor: '#fff'
                            });
                        });


                    },
                });
            }
            $(function() {
                init();
            });




            $('#order_data').on('click', '.btn-delete[data-url]', function(e) {
                e.preventDefault();
                var url = $(this).data('url');
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        method: '_DELETE',
                        submit: true
                    },
                    success: function(response) {

                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Offer deleted Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();

                    },
                    error: function(response) {

                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: '{{ _i('Can not deleted refrenced data') }}',
                            timeout: 2000,
                            killer: true
                        }).show();

                    },
                }).always(function(data) {
                    $('#order_data').DataTable().draw(false);
                });
            });

            //start switch button
            $('body').on('mousedown', '.switchery', function(e) {

                var check = $(this).siblings("input[type='checkbox']");

                if (!$(check).is(':checked')) {
                    var edit = $(check).data("edit");
                    if (edit == "1")
                        ok = confirm("{{ _i('Are you sure , after activating discount can not be edited  ?') }}");
                    else
                        ok = true;
                    if (ok) {
                        $(this).trigger("click");
                    }
                }

            });

            $('body').on('change', '.checkedIN', function(e) {
                var id = $(this).data('id');
                var url = "{{ url('admin/offers/updateActive') }}";
                var active = ($(this).is(":checked")) ? 1 : 0;
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: id,
                        active: active
                    },
                    success: function(response) {
                        if (response.status == "failed") {
                            new Noty({
                                type: 'error',
                                layout: 'topRight',
                                text: '{{ _i("Offer is not activated. An offer is already running") }}',
                                timeout: 2000,
                                killer: true
                            }).show();
                        }
                    }
                })
            });
            //end switch button
        </script>
    @endpush
    <style>
        .table {
            display: table !important;
        }

        .row {
            width: 100% !important;
        }

    </style>
@endsection
