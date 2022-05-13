@extends('admin.layout.index',[
	'title' => _i('Affiliate Settings'),
	'activePageName' => _i('Affiliate Settings'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
<form method="post" action='{{route('affiliate_settings.store')}}' id='save_settings'>
@csrf
<div class="box-body">
	<div class="row">
		<div class="col-sm-12">
			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active btn btn-primary" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">{{ _i('Main Settings') }}</a>
				</li>
				<li class="nav-item">
					<a class="nav-link btn btn-primary" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ _i('Withdrawal Methods') }}</a>
				</li>
			</ul>
			<div class="tab-content" id="myTabContent">
				<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
					<div class="card">
						<div class="card-header">
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="form-group row" >
								<label class="col-sm-2 col-form-label" for="checkbox">
									{{_i('Commission Type')}}
								</label>
								<div class="checkbox-fade fade-in-primary col-sm-6">
									<label class='mr-5'>
										<input type="radio" id="checkbox" name="commission_type" value="percentage" @if($affiliate_settings->commission_type == 'percentage') checked @endif>
										{{ _i('Percentage') }}
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
										</span>
									</label>
									<label>
										<input type="radio" id="checkbox" name="commission_type" value="amount" @if($affiliate_settings->commission_type == 'amount') checked @endif>
										{{ _i('Amount') }}
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
										</span>
									</label>
								</div>
							</div>
							<div class="form-group row">
								<label for="name" class="col-sm-2 col-form-label"> {{_i('Commission Value')}} <span style="color: #F00;">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="commission_value" class='form-control' value='{{$affiliate_settings->commission_value}}'>
								</div>
							</div>

							<div class="form-group row" >
								<label class="col-sm-2 col-form-label" for="checkbox2">
									{{_i('Pend Amount')}}
								</label>
								<div class="checkbox-fade fade-in-primary col-sm-6">
									<label class='mr-5'>
										<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="1" @if($affiliate_settings->pend_amount == 1) checked @endif>
										{{ _i('Yes') }}
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
										</span>
									</label>
									<label>
										<input type="radio" class='pend-amount' id="checkbox2" name="pend_amount" value="0" @if($affiliate_settings->pend_amount == 0) checked @endif>
										{{ _i('No') }}
										<span class="cr">
											<i class="cr-icon icofont icofont-ui-check txt-primary"></i>
										</span>
									</label>
								</div>
							</div>
							<div class="form-group row @if($affiliate_settings->pend_amount == 0) d-none @endif is-d-none">
								<label for="name" class="col-sm-2 col-form-label"> {{_i('Pend Period')}} <span style="color: #F00;">*</span></label>
								<div class="col-sm-10">
									<input type="text" name="pend_period" class='form-control' value='{{$affiliate_settings->pend_period}}'>
								</div>
							</div>
							<div class="form-group row">
								<div class="col-sm-offset-2 col-sm-2">
									<button type="submit" class="btn btn-primary pull-leftt">{{ _i('Save') }}</button>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{-- </form> --}}
				<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
					<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
						<div class="card">
							<div class="card-header">
								<h5><a class='btn btn-primary' data-toggle="modal" data-target="#modal_create">{{ _i('Create New Withdrawal Method') }}</a></h5>
								<div class="card-header-right">
									<i class="icofont icofont-rounded-down"></i>
								</div>
							</div>
							<div class="card-block">
								<div class="dt-responsive table-responsive text-center">
									<table id="dataTable" class="table table-bordered table-striped dataTable text-center" style='width: 100%'>
										<thead>
											<tr role="row">
												<th class="sorting"> {{_i('Name')}}</th>
												<th class="sorting"> {{_i('Image')}}</th>
												<th class="sorting"> {{_i('Status')}}</th>
												<th class="sorting"> {{_i('Created At')}}</th>
												<th class="sorting"> {{_i('Controll')}}</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</form>
@push('css')
@endpush
@include('admin.affiliate.create')
@include('admin.affiliate.edit')
@include('admin.affiliate.trans')
@endsection
@push('js')
<script>
	$(function () {
		$('.pend-amount').change(function(){
			var _val = $(this).val();
			if( _val == 1)
			{
				$('.is-d-none').removeClass('d-none');
			}
			else
			{
				$('.is-d-none').addClass('d-none');
			}
		})
	});

	$('body').on('submit','#save_settings',function (e) {
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
	                    type: 'success',
	                    layout: 'topRight',
	                    text: "{{ _i('Updated Successfully !')}}",
	                    timeout: 2000,
	                    killer: true
	                }).show();
	                $('.modal.modal_trans').modal('hide');
	                table.ajax.reload();
	            }
	        },
	    });
	});

	var table;
	$(function () {
	    table = $('#dataTable').DataTable({
			processing: true,
			serverSide: true,
			ajax: '{{route('withdrawal_method.index')}}',
			columns: [
				{data: 'name', name: 'name'},
				{data: 'image', name: 'image'},
				{data: 'published', name: 'published'},
				{data: 'created_at', name: 'created_at'},
				{data: 'action', name: 'action', orderable: true, searchable: true}
			]
		});
	});
	$('body').on('click','.lang_ex',function (e) {
	    e.preventDefault();
	    var id = $(this).data('id');
	    var lang_id = $(this).data('lang');
	    $.ajax({
	        url: '{{ url('admin/affiliate/settings/methods/get/lang/value') }}',
	        method: "get",
	        data: {
	            lang_id: lang_id,
	            id: id,
	        },
	        success: function (response) {
	            if (response.data == 'false'){
	                $('#name').val('');
	            }else{
	                $('#name').val(response.data.name);
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
