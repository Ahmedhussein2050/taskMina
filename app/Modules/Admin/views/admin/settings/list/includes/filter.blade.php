<ul class="top-level-menu">
    <li>
        <a href="#" class="first_link">{{ _i('Options') }}</a>
        <ul class="second-level-menu">
            <li>
                <a href="#" data-toggle="modal" data-target="#sendSms"><i class="ti-email"></i> {{ _i('Send Sms') }}</a>
            </li>
            <li>
                <a href="{{ route('customers.edit', $user->id) }}"><i class="ti-pencil-alt"></i> {{ _i('Edit Customer') }}</a>
            </li>
            <li>
                <a href="#">{{ _i('Block Customer') }}</a>
            </li>
            <li>
                <a href="{{ route('customers.destroy', $user->id) }}" data-remote="{{ route('customers.destroy', $user->id) }}" class='delete-customer-btn'><i class="ti-trash"></i> {{ _i('Delete Customer') }}</a>
            </li>
        </ul>
    </li>
</ul>
@include('admin.userOrders.includes.modal')
@push('css')
    <style>
        .first_link:after {
            content: "\e64b";
            font-family: themify;
            margin-left: 10px;
        }
        .third-level-menu {
            position: absolute;
            top: 0;
            left: -250px;
            width: 150px;
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
        }
        .third-level-menu > li {
            height: 30px;
            width: 250px;
            background: #5dd5c4;
        }
        .third-level-menu > li:hover {
            background: #CCCCCC;
        }
        .second-level-menu {
            position: absolute;
            top: 30px;
            right: 0;
            width: 150px;
            list-style: none;
            padding: 0;
            margin: 0;
            display: none;
        }
        .second-level-menu > li {
            position: relative;
            height: 30px;
            background: #5dd5c4;
        }
        .second-level-menu > li:hover {
            background: #CCCCCC;
        }
        .top-level-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            width: ;
        }
        .top-level-menu > li {
            position: relative;
            float: left;
            height: 30px;
            width: 100px;
            margin-right: 15px;
            background: #5dd5c4;
            border-radius: 50px;
        }
        .top-level-menu > li:hover {
            background: #CCCCCC;
        }
        .top-level-menu li:hover > ul {
            display: inline-block;
            z-index: 99999;
        }
        .top-level-menu a
        {
            font: bold 14px Arial, Helvetica, sans-serif;
            color: #FFFFFF;
            text-decoration: none;
            padding: 0 0 0 10px;
            display: block;
            line-height: 30px;
        }
        .top-level-menu a:hover {
            color: #000000;
        }
    </style>
@endpush
@push('js')
<script>
    $(document).ready(function () {
        $('body').on('click', '.delete-customer-btn', function (e) { 
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var url = $(this).data('remote');
            $.ajax({
                url: url,
                type: 'DELETE',
                dataType: 'json',
                data: {method: '_DELETE', submit: true},
                success: function (response) {
                    if (response == true) {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Deleted Successfully')}}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        setTimeout(function () {
                            window.location.href = "{{ route('customers.index') }}";
                        }, 1000);
                    }
                }
            });
        });
    });
</script>
@endpush