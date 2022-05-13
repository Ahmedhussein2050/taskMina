@php
$type = 'notApi';
if (request()->query('type') == 'notApi' || request()->query('type') == 'api') {
    $type = request()->query('type');
}

@endphp

@extends('admin.layout.index',
[
'title' => _i('Shipping'),
'subtitle' => _i('Shipping'),
'activePageName' => _i('Shipping'),
'activePageUrl' => route('shipping.index'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index') ,
])

@push('css')
	<style>
		.modal-header {
			background-color: #5cd5c4;
			border-color: #5cd5c4;
			color: #fff;
		}

	</style>
@endpush

@section('content')
    <div class="row">
        <div class="col-lg-12 ">
            <!-- Nav tabs -->
            {{-- <ul class="nav nav-tabs  tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'notApi' ? 'active' : '' }}"
                        href="{{ route('shipping.index') }}?type=notApi">{{ _i('Sipping Companies Without API') }}</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $type == 'api' ? 'active' : '' }}"
                        href="{{ route('shipping.api') }}?type=api">{{ _i('Sipping Companies Through API') }}</a>
                </li>

            </ul> --}}
            <!-- Tab panes -->
			{{-- shhipping Without Api --}}
            <div class="tab-content tabs card-block">
                <div class="tab-pane fade  {{ $type == 'notApi' ? 'show active' : '' }}" id="all" role="tabpanel"
                    aria-labelledby="movies-tab">
                    @include('admin.shipping.companies.shhiping_notApi', [
                        'type' => $type,
                    ])
                </div>
			{{-- shhipping With Api --}}
                <div class="tab-pane fade  {{ $type == 'api' ? 'show active' : '' }}" id="all" role="tabpanel"
                    aria-labelledby="movies-tab">
                    @include('admin.shipping.companies.shhiping_api', [
                        'type' => $type,
                    ])
                </div>

            </div>
        </div>

    </div>


    @include('admin.shipping.companies.translate')
@endsection
 @push('js')
    <script type="text/javascript">
        function status(obj, id) {
            var bol = $(obj).is(":checked");
			var route = '{{route('shipping' , 'id')}}';
			var	route = route.replace('id' ,id);
            $.ajax({
                url: route,
                type: "Post",
                data: {
                    status: bol,
                    _token: "{{ csrf_token() }}",
                },
                dataType: 'json',
                cache: false,
                success: function(response) {
                    if (response.status == 'ok') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "Saved Successfully",
                            timeout: 2000,
                            killer: true
                        }).show();
                        $('.modal.modal_edit').modal('hide');
                        //table.ajax.reload();
                    }
                }
            });
        }
    </script>
@endpush
