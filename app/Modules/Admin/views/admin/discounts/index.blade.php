@php
$type = 'free';
$add = 'discounts/create';
if (request()->query('type') == 'private' || request()->query('type') == 'general') {
    $type = request()->query('type');
}
@endphp
@extends('admin.layout.index',[
'title' => _i('Free Discount Codes'),
'subtitle' => _i('Discount Codes'),
'activePageName' => _i('Discount Codes'),
'activePageUrl' => "#",
// 'additionalPageName' => _i('Settings'),
// 'additionalPageUrl' => route('settings.index')
] )


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
            {{-- <div class="col-md-12">

                <a href="discounts?type=free"
                    class="@if ($type == 'free') btn btn-primary @endif">{{ _i('Gift Type Discount Code') }}
                </a> |
                <a href="discounts?type=private"
                    class="@if ($type == 'private') btn btn-primary @endif">{{ _i('Private Discount Code') }} </a>
                |
                <a href="discounts?type=general"
                    class="@if ($type == 'general') btn btn-primary @endif">{{ _i('General Discount Code') }} </a>


            </div> --}}
        </div>


        <div class="card blog-page">
            <div class="card-header">
                <h5>
                    {{-- @switch($type)
                        @case('free')
                            {{ _i('Gift Type Discount Code') }}
                            @php
                                $add = 'discounts/create?type=free';
                            @endphp
                        @break

                        @case('private')
                            {{ _i('Private Discount Code') }}
                            @php
                                $add = 'discounts/create?type=private';
                            @endphp
                        @break

                        @case('general')
                            {{ _i('General Discount Code') }}
                            @php
                                $add = 'discounts/create?type=general';
                            @endphp
                        @break

                        @default --}}
                            {{ _i('General Discount Code') }}
                    {{-- @endswitch --}}
                </h5>
                <a href="{{ $add }}" class="btn btn-primary"><i class="ti-plus"></i> </a>


            </div>

            <div class="card-block ">
                <table class=" table table-bordered table-striped table-responsive text-center" id="order_data"
                    width="100%">
                    <thead>
                        {{-- <tr>
						<td colspan="7" class="text-right">
							{{_i("Free Discount Code")}}
							<a class="btn btn-primary"><i class="ti-plus"></i>{{'Add Free Discount Code'}} </a>
						</td>
					</tr> --}}
                        <tr role="row">
                            <th>{{ _i('CreatedBy') }}</th>
                            <th>{{ _i('Title') }}</th>
                            <th>{{ _i('Used Time') }}</th>
                            <th>{{ _i('Status') }}</th>

                            <th>{{ _i('Bonus') }}</th>
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
        @include('admin.layout.message')

        <script type="text/javascript">
            var table;

            table = $('#order_data').DataTable({
                "order": [
                    [0, 'desc']
                ],
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
                    // url: url,
                },
                columns: [

                    {

                        data: 'created_at'
                    },
                    {
                        data: 'title'
                    },
                    {
                        data: 'usedTime'
                    },
                    {
                        data: 'status',
                    },
                    {
                        data: 'Bouns'
                    },
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
            //}


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
                            text: "{{ _i('deleted Successfully') }}",
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
                var url = "{{ url('admin/discounts/updateActive') }}";
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
                        // console.log(response);
                        location.reload();
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
