@php
    $type = 'oneFree';
    if (request()->query('type') == "notAll" || request()->query('type') == "new" || request()->query('type') == "favorite" || request()->query('type') == "Low_Stock" || request()->query('type') == "Refund") {
        $type = request()->query('type');
    }

@endphp

@extends('admin.layout.index',[
'title' => _i('Notifications'),
'subtitle' => _i('Notifications'),
'activePageName' => '',
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/notifications') ,
'additionalPageName' => _i('Notifications'),
] )

@section('content')

    <div class="row">
        <div class="col-sm-12">

            <ul class="nav nav-tabs" id="myTab" role="tablist">
				@if(auth()->user()->can('Orders'))
                <li class="nav-item">
                    <a class="nav-link {{ ($type == "notAll") ? 'active' : '' }} btn btn-primary"  href="notificationsAll?type=notAll">{{ _i('All Notifications') }}
                        {{ $notAll->total() }}</a>
                </li>
				@else
					<li class="nav-item">
						<a class="nav-link {{ ($type == "notAll") ? 'active' : '' }} btn btn-primary"  href="notificationsAll?type=notAll">{{ _i('All Notifications') }}
							{{ $notAllwithoutorder->total() }}</a>
					</li>
				@endif
				@can('Orders')
                <li class="nav-item">
                    <a class="nav-link {{ ($type == "new") ? 'active' : '' }} btn btn-primary"  href="notificationsAll?type=new">{{ _i('New Orders') }} {{ $notNew->total() }}</a>
                </li>
				@endcan
					<li class="nav-item">
                    <a class="nav-link {{ ($type == "favorite") ? 'active' : '' }} btn btn-primary"  href="notificationsAll?type=favorite" >{{ _i('Product Favorite') }}
                        {{ $notFav->total() }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($type == "Low_Stock") ? 'active' : '' }} btn btn-primary" href="notificationsAll?type=Low_Stock">{{ _i('Low Stock') }}
                        {{ $notStock->total() }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ ($type == "Refund") ? 'active' : '' }} btn btn-primary" href="notificationsAll?type=Refund">{{ _i('Orders Refund') }}
                        {{ $notRefund->total() }}</a>
                </li>
            </ul>


            <!-- To Do List in Modal card start -->
            <div class="card-block">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade  {{ ($type == "notAll") ? 'show active' : '' }}" id="all" role="tabpanel" aria-labelledby="movies-tab">

                        @include("admin.notificationsAll.include.all",['type' => $type])
                    </div>
                    <div class="tab-pane fade {{ ($type == "new") ? 'show active' : '' }}" id="new" role="tabpanel" aria-labelledby="scheduled-movies-tab">

                        @include("admin.notificationsAll.include.new",['type' => $type])
                    </div>
                    <div class="tab-pane fade {{ ($type == "favorite") ? 'show active' : ''}}" id="favorite" role="tabpanel" aria-labelledby="scheduled-movies-tab">

                        @include("admin.notificationsAll.include.fav",['type' => $type])
                    </div>
                    <div class="tab-pane fade {{ ($type == "Low_Stock") ? 'show active' : '' }}" id="Low_Stock" role="tabpanel" aria-labelledby="scheduled-movies-tab">

                        @include("admin.notificationsAll.include.stock",['type' => $type])
                    </div>
                    <div class="tab-pane fade {{ ($type == "Refund") ? 'show active' : '' }}" id="Refund" role="tabpanel" aria-labelledby="group-movies-tab">

                        @include("admin.notificationsAll.include.refund",['type' => $type])

                    </div>
                </div>
            </div>
            <!-- To Do List in Modal card end -->
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
    <script type="text/javascript">



        {{--$(document).on('click', '.delete_todo[data-remote]', function(e) {--}}
            {{--e.preventDefault();--}}
            {{--$.ajaxSetup({--}}
                {{--headers: {--}}
                    {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                {{--}--}}
            {{--});--}}
            {{--var url = $(this).data('remote');--}}
            {{--var id = $(this).data('id');--}}
            {{--console.log(url)--}}
            {{--$.ajax({--}}
                {{--url: url,--}}
                {{--type: 'DELETE',--}}
                {{--dataType: 'json',--}}
                {{--data: {--}}
                    {{--method: '_DELETE',--}}
                    {{--submit: true--}}
                {{--},--}}
                {{--success: function(res) {--}}
                    {{--$('.delete_' + id).remove();--}}
                    {{--if (res == 'success') {--}}
                        {{--new Noty({--}}
                            {{--type: 'success',--}}
                            {{--layout: 'topRight',--}}
                            {{--text: "{{ _i('Deleted successfully') }}",--}}
                            {{--timeout: 3000,--}}
                            {{--killer: true--}}
                        {{--}).show();--}}

                    {{--}--}}
                {{--}--}}
            {{--})--}}


        {{--});--}}


        $(document).on('click', 'input[name="ckeckedAll"]:checked', function() {

            var id = $(this).val();
            let token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: "{{ route('notificationAll.read') }}",
                data: {
                    '_token': token,
                    'id': id
                },
                success: function(data) {
                    if (data == 'success') {
                        $(".all_" + id).addClass("done-task");
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('read successfully') }}",
                            timeout: 3000,
                            killer: true
                        }).show();
                    }
                }
            });
        });
    </script>

@endpush
