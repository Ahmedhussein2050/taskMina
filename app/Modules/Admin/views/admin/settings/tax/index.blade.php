@extends('admin.layout.index',
[
	'title' => _i('TAX'),
	'subtitle' => _i('TAX'),
	'activePageName' => _i('TAX'),
	'activePageUrl' => route('settings.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@section('content')
<div class="order-table">
	<div class="card">
		<div class="card-header">
			<h3 class="card-title">{{_i("VAT")}}</h3>
			<div class="heading-elements">
				<button data-toggle="modal" data-target="#taxtable" class="btn btn-tiffany" type="button" style="float: right;margin-top: -33px;"><i
					class="fa fa-plus"></i>{{_i("Add Tax")}}</button>
			</div>
			<div class="clearfix"></div>
		</div>
		<div class="card-body">
			<table class="table">
				<tr>
					<td><strong>{{_i("Establishment tax number")}}</strong></td>
					<td>
						<a href="#"data-toggle="modal" data-target="#taxtable2"><strong style="margin-right: -69px;margin-left: 32px;">{{_i("Designation")}}</strong></a>
					</td>
				</tr>
				<tr>
					<td><strong>{{_i("Calculating the tax on shipping services")}}</strong></td>
					<td>
						<div class="row form-group">
							<div class="col-md-8 d-flex justify-content-end">
								<input type="checkbox" form="form_store" class="js-switch" id="tax_on_shipping" name="tax_on_shipping" @if($setting->tax_on_shipping == 1) checked="" @endif data-switchery="true" style="display: none;">
							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td><strong>{{_i("Prices for products are tax-inclusive")}}</strong></td>
					<td>
						<div class="row form-group">
							<div class="col-md-8 d-flex justify-content-end">
								<input type="checkbox" form="form_store" class="js-switch" id="tax_on_product" name="tax_on_product" @if($setting->tax_on_product == 1) checked="" @endif data-switchery="true" style="display: none;">
							</div>
						</div>
					</td>
				</tr>
			</table>
		</div>
	</div>
	<div class="modal fade" ref="ordertable" id="taxtable" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{_i("Create the tax")}}</h4>
				</div>
				<div class="modal-body">
					<form action="{{ route('TaxStore') }}" method="post" data-parsley-validate="" id="tax_store">
						@csrf
						@method('POST')
						<div class="row">
							<div class="col-sm-12">
								<select  class="form-control  usingselect2" name="lang_id" style="width:100%">
									<option  selected disabled>{{_i('Choose Language')}}</option>
									@foreach($languages as $language)
									<option value="{{$language->id}}"> {{$language->title}}
									</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-12 mt-3">
								<select  class="form-control  usingselect2" name="country_id"   style="width:100%"  id="Country">
									<option  selected disabled>{{_i('Choose Country')}}</option>
									@foreach($countries as $country)
									<option value="{{$country->id}}"
									{{old('country_id') == $country->id ? 'selected' : ''}}> {{$country->title}}
									</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-12 mt-3">
								<input type="text"  class="form-control" name="name" id="name"
									placeholder="{{ _i('Tax Name') }}" minlength="2" required="">
								<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('name')}}</strong>
								</span>
							</div>
							<div class="col-sm-12 mt-3">
								<input type="text"  class="form-control" name="tax" id="tax"
									placeholder="{{ _i('Tax Value') }}" minlength="2" maxlength="3" required="">
								<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('name')}}</strong>
								</span>
							</div>
						</div>
						<input type="submit" class="btn btn-primary waves-effect waves-light mt-3" value="Submit">
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<!-- /.modal -->
	<div class="modal fade" ref="ordertable" id="taxtable2" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
					<h4 class="modal-title">{{_i("Establishment tax number")}}</h4>
				</div>
				<div class="modal-body">
					<div class="row">
						<form action="{{ route('TaxNumbStore',$setting->id) }}" method="post" data-parsley-validate=""
							id="taxnumb_store">
							@csrf
							@method('POST')
							<div class="col-sm-12 mt-3">
								<input type="text"  class="form-control" name="taxnumb" id="taxnumb"
									placeholder="{{ _i('Tax number') }}" minlength="2" maxlength="3056gg" required="">
								<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('taxnumb')}}</strong>
								</span>
							</div>
					</div>
					<input type="submit" class="btn btn-primary waves-effect waves-light ml-3 mt-3" value="Submit">
					</form>
				</div>
			</div>
			<!-- /.modal-content -->
		</div>
		<!-- /.modal-dialog -->
	</div>
	<div class="modal fade" ref="ordertable" id="edit" tabindex="-1" role="dialog">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">{{_i("Edit the tax")}}</h4>
				</div>
				<div class="modal-body">
					<form action="#" method="post" data-parsley-validate="" id="tax_update">
						@csrf
						@method('PATCH')
						<div class="row">
							<div class="col-sm-12">
								<select  class="form-control  usingselect2" name="country_id"   style="width:100%"  id="Country">
									<option  selected disabled>{{_i('Choose Country')}}</option>
									@foreach($countries as $country)
									<option value="{{$country->id}}">{{ $country->title }}
									</option>
									@endforeach
								</select>
							</div>
							<div class="col-sm-12 mt-3">
								<input type="text"  class="form-control" name="tax" id="tax" value=""
									placeholder="{{ _i('Tax Value') }}" minlength="2" maxlength="3" required="">
								<span class="text-danger invalid-feedback">
								<strong>{{$errors->first('name')}}</strong>
								</span>
							</div>
						</div>
						<input type="submit" class="btn btn-primary waves-effect waves-light mt-3" value="Submit">
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="modal fade modal_create" id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form  action="{{route('taxs.store_translation')}}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
							@csrf
							<input type="hidden" name="id" id="id_data" value="">
							<input type="hidden" name="lang_id" id="lang_id_data" value="" >
							<div class="box-body">
								<div class="form-group row">
									<label for="" class="col-sm-2 control-label "> {{_i('Title')}} </label>
									<div class="col-md-10">
										<input type="text"  placeholder="{{_i('name')}}" name="name"  value="" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required="" id="name" >
									</div>
								</div>
							</div>
							<!-- /.box-body -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
								<button type="submit" class="btn btn-primary" >{{_i('Save')}}</button>
							</div>
							<!-- /.box-footer -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{--  @if(!empty($taxs))  --}}
<div class="card" id="relode">
	<div class="card-header">
		<h5 class="card-title">
			{{_i('This all countries have tax')}}
		</h5>
	</div>
	<div class="card-block">
		<div id="example1_wrapper" class="dataTables_wrapper dt-bootstrap">
			<table id="tax-table" class="table table-hover text-center table table-bordered table-responsive"
				role="grid" style="width: 100% ;display: table !important;">
				<thead>
					<tr>
						<td class="text-left"> {{_i('id')}} </td>
						<td class="text-left"> {{_i('Name')}} </td>
						<td class="text-left"> {{_i('Country')}} </td>
						<td class="text-left"> {{_i('Tax')}} </td>
						<td class="text-right"> {{_i('Action')}} </td>
					</tr>
				</thead>
			</table>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	$('body').on('change', '#tax_on_shipping', function (e) {
		e.preventDefault();
		if($(this).is(":checked")){
			var vals = 1;
		}else{
			var vals = 0;
		}
		$.ajax({
			type: 'POST',
			url: '{{ route('updateTaxStatus')}}',
			data: {
				"_token": "{{ csrf_token() }}",
				"val": vals,
			},
			success: function(data) {
				console.log(data);
				new Noty({
					type: 'success',
					layout: 'topRight',
					text: "{{ _i('Updated Successfiiy')}}",
					timeout: 2000,
					killer: true
					}).show();
			},
			error : function(err) {
				console.log(err.responseText);
			},
		});
	});
	
	$('body').on('change', '#tax_on_product', function (e) {
		e.preventDefault();
		if($(this).is(":checked")){
			var vals = 1;
		}else{
			var vals = 0;
		}
		$.ajax({
			type: 'POST',
			url: '{{ route('updateTaxStatusnumb')}}',
			data: {
				"_token": "{{ csrf_token() }}",
				"val": vals,
			},
			success: function(data) {
				console.log(data);
				new Noty({
					type: 'success',
					layout: 'topRight',
					text: "{{ _i('Updated Successfiiy')}}",
					timeout: 2000,
					killer: true
					}).show();
			},
			error : function(err) {
				console.log(err.responseText);
			},
		});
	});
	
	$('body').on('submit', '#tax_store', function (e) {
		e.preventDefault();
		$.ajax({
			url: '{{route('TaxStore')}}',
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				console.log(response);
				if (response.status == 'success') {
					$('#taxtable').modal('hide');
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('This Tax Added Successfiiy')}}",
						timeout: 2000,
						killer: true
						}).show();
						var table = $('#tax-table').DataTable();
						table.ajax.reload();
				}
			},
		});
	})
	
	var id = '';
	$('body').on('click','.edit',function (e) {
		e.preventDefault();
		id = $(this).data('id');
		tax = $(this).data('tax');
		country = $(this).data('country');
		name = $(this).data('name');
		console.log(country);
		$('#edit #tax').val(tax);
		$('#edit #Country').val(country);
		$('#edit #name').val(name);
	});
	
	$('body').on('submit', '#tax_update', function (e) {
		e.preventDefault();
		$.ajax({
			url: '{{ url('admin/taxs') }}/' + id,
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache: false,
			contentType: false,
			processData: false,
			success: function (response) {
				console.log(response);
				if (response.status == 'success') {
					$('#taxtable').modal('hide');
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "{{ _i('Updated Successfully !')}}",
						timeout: 2000,
						killer: true
						}).show();
						var table = $('#tax-table').DataTable();
						table.ajax.reload();
				}
			},
		});
	})
	
	$(function () {
		$('#tax-table').DataTable({
		processing: true,
			serverSide: true,
			ajax: '{{route('alltaxs')}}',
			columns: [
				{data: 'id', name: 'id'},
				{data: 'name', name: 'name'},
				{data: 'title', name: 'title'},
				{data: 'tax', name: 'tax'},
				{data: 'action', name: 'action', orderable: true, searchable: true}
			]
		});
	});
	$('body').on('click', '.lang_ex', function (e) {
	    e.preventDefault();
	    var transRowId = $(this).data('id');
	    var lang_id = $(this).data('lang');
	    $.ajax({
	        url: '{{route('taxs.get_translation')}}',
	        method: "get",
	        "_token": "{{ csrf_token() }}",
	        data: {
	            'lang_id': lang_id,
	            'transRow': transRowId,
	        },
	        success: function (response) {
	            if (response.data == 'false'){
	                $('#langedit #name').val('');
	            } else{
	                $('#langedit #name').val(response.data.name);
	            }
	        }
	    });
	    $.ajax({
	        url: '{{route('admin.get.lang')}}',
	        method: "get",
	        data: {
	            lang_id: lang_id,
	        },
	        success: function (response) {
	            $('#header').empty();
	            $('#header').text('Translate to : ' + response);
	            $('#id_data').val(transRowId);
	            $('#lang_id_data').val(lang_id);
	        }
	    });
	    $('body').on('submit', '#lang_submit', function (e) {
	        e.preventDefault();
	        let url = $(this).attr('action');
	        $.ajax({
	            url: url,
	            method: "post",
	            "_token": "{{ csrf_token() }}",
	            data: new FormData(this),
	            dataType: 'json',
	            cache       : false,
	            contentType : false,
	            processData : false,
	            success: function (response) {
	                if (response.errors){
	                    $('#masages_model').empty();
	                    $.each(response.errors, function(index, value) {
	                        $('#masages_model').show();
	                        $('#masages_model').append(value + "<br>");
	                    });
	                }
	                if (response == 'SUCCESS'){
	                    new Noty({
	                        type: 'success',
	                        layout: 'topRight',
	                        text: "{{ _i('Translated Successfully')}}",
	                        timeout: 2000,
	                        killer: true
	                    }).show();
	                    $('.modal.modal_create').modal('hide');
	                   	var table = $('#tax-table').DataTable();
						table.ajax.reload();
	                }
	            },
	        });
	    });
	});
</script>
@endpush