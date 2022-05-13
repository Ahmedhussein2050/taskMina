@extends('admin.layout.index',
[
	'title' => _i('Sliders'),
	'subtitle' => _i('Sliders'),
	'activePageName' => _i('Sliders'),
	'activePageUrl' => route('slider.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-sm-12 mb-3">
			<span class="pull-left">
			<button class="btn btn-primary create add-permissiont" type="button" data-toggle="modal"
				data-target="#modal-default">
			<span><i class="ti-plus"></i> {{_i('create new Slider')}} </span>
			</button>
			</span>
		</div>
		<div class="col-sm-12">
			<!-- Zero config.table start -->
			<div class="card">
				<div class="card-header">
					<h5>{{_i('All Sliders')}}</h5>
					<div class="card-header-right">
						<i class="icofont icofont-rounded-down"></i>
						<i class="icofont icofont-refresh"></i>
						<i class="icofont icofont-close-circled"></i>
					</div>
				</div>
				<div class="card-block">
					<div class="dt-responsive table-responsive text-center">
						<table id="slider_table" class="table table-bordered table-striped dataTable text-center">
							<thead>
								<tr role="row">
									<th class="text-center"> {{_i('ID')}}</th>
									<th class="text-center"> {{_i('Title')}}</th>
									<th class="text-center"> {{_i('Image')}}</th>
									<th class="text-center"> {{_i('Status')}}</th>
									<th class="text-center"> {{_i('Create Time')}}</th>
									<th class="text-center"> {{_i('Controll')}}</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@include('admin.settings.sliders.create')
@include('admin.settings.sliders.edit')
@include('admin.settings.sliders.trans')
@endsection
@push('js')
<script  type="text/javascript">
	var table;
	$(function () {
	    table = $('#slider_table').DataTable({
	        processing: true,
	        serverSide: true,
	        ajax: '{{url('admin/settings/sliders')}}',
	        columns: [
	            {data: 'id'},
	            {data: 'name'},
	            {data: 'image'},
	            {data: 'published'},
	            {data: 'created_at'},
	            {data: 'action', name: 'action', orderable: true, searchable: true}
	        ]
	    });
	});
	
	$('body').on('click','.lang_ex',function (e) {
	    e.preventDefault();
	    var id = $(this).data('id');
	    var lang_id = $(this).data('lang');	
	    $.ajax({
	        url: '{{ url('admin/settings/sliders/get/lang/value') }}',
	        method: "get",
	        data: {
	            lang_id: lang_id,
	            id: id,
	        },
	        success: function (response) {
	            if (response.data == 'false'){
	                $('#titletrans').val('');
	                $('#description_trans').val('');
	            }else{
	                $('#titletrans').val(response.data.name);
	                $('#description_trans').val(response.data.description);
	            }
	        }
	    });
	    $.ajax({
	        url: "{{ url('admin/get/lang') }}",
	        method: "get",
	        data: {
	            {{--_token: '{{ csrf_token() }}',--}}
	            lang_id: lang_id,
	        },
	        success: function (response) {
	            $('#langedit #header').empty();
	            $('#langedit #header').text('Translate to : '+response);
	
	            $('#id_data').val(id);
	            $('#lang_id_data').val(lang_id);
	        }
	    });
	});
	
	$('body').on('submit','#lang_submit',function (e) {
	    e.preventDefault();
	    let url = $(this).attr('action');
	    $.ajax({
	        url: url,
	        method: "post",
	        data: new FormData(this),
	        dataType: 'json',
	        cache       : false,
	        contentType : false,
	        processData : false,
	        success: function (response) {
	            console.log(response);
	            if (response.errors){
	                $('#masages_model').empty();
	                $.each(response.errors, function( index, value ) {
	                    $('#masages_model').show();
	                    $('#masages_model').append(value + "<br>");
	                });
	            }
	            if (response == 'SUCCESS'){
	                new Noty({
	                    type: 'warning',
	                    layout: 'topRight',
	                    text: "{{ _i('Translated Successfully')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                $('.modal.modal_trans').modal('hide');
	                table.ajax.reload();
	            }
	        },
	    });
	});
	$('body').on('submit','#delform',function (e) {
	    e.preventDefault();
	    var url = $(this).attr('action');
	    // alert(url);
	    $.ajax({
	        url: url,
	        method: "delete",
	        data: {
	            _token: '{{ csrf_token() }}',
	        },
	        success: function (response) {
	            // console.log(response);
	            if (response.data === true){
	                new Noty({
	                    type: 'error',
	                    layout: 'topRight',
	                    text: "{{ _i('Deleted Successfully')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                table.ajax.reload();
	            }
	        }
	    });
	})
</script>
@endpush