@extends('admin.layout.index',
[
	'title' => _i('Discount Codes'),
	'subtitle' => _i('Discount Codes'),
	'activePageName' => _i('Discount Codes'),
	'activePageUrl' => route('discount_code.index'),
	'additionalPageName' => '',
	'additionalPageUrl' => '' ,
])

@section('content')

	@if ($errors->all())
		<div class="alert alert-danger">
			<ul>
				@foreach($errors->all() as $error)
					<li>{{$error}}</li>
				@endforeach
			</ul>
		</div>
	@endif

	<!-- Page-body start -->
	<div class="page-body">
		<!-- Blog-card start -->
		<div class="card blog-page" id="blog">
			<div class="card-block">
				@include('admin.layout.message')
				{!! $dataTable->table([
					'class'=> 'table table-bordered table-striped dataTable text-center'
				],true) !!}
			</div>
		</div>
	</div>
	@include('admin.discount_code.model' , ['categories' => $categories , 'products' => $products, 'users' => $users])
	@push('js')
		{!! $dataTable->scripts() !!}
		<script>
			$('.percentage').on("click", function () {
				$('.amount').prop("checked", false);
				$('.item').prop("checked", false);
			});
			$('.amount').on("click", function () {
				$('.percentage').prop("checked", false);
				$('.item').prop("checked", false);
			});
			$('.item').on("click", function () {
				$('.amount').prop("checked", false);
				$('.percentage').prop("checked", false);
			});
			$(function () {
				$('.create').attr('data-toggle','modal').attr('data-target','.modal_create')
			});
			$(function () {
				$('body').on('submit','#form_create',function (e) {
					e.preventDefault();
					var table = $('.dataTable').DataTable();
					var type = 'type';
					var formData = new FormData(this);
					$('#form_create').find(':checkbox:checked, :radio:checked').each(function () {
						formData.append('type', $(this).val());
					});
					$.ajax({
						url:'{{ route('discount_code.store') }}',
						method: "post",
						data: formData,
						dataType: 'json',
						cache: false,
						processData: false,
						contentType: false,
						success:function (res) {
							console.log(res);
							if(res[0] == false) {
								$.each(res.errors, function(key, value){
									$('.alert-danger').show();
									$('.alert-danger').append('<p>'+value+'</p>');
								});
							} else {
								$('.modal.modal_create').modal('hide');
								table.ajax.reload();
								new Noty({
									type: 'success',
									layout: 'topRight',
									text: "{{ _i('Added Successfully')}}",
									timeout: 2000,
									killer: true
								}).show();
							}
						},error: function(jqXHR, textStatus, errorThrown) {
							console.log(jqXHR.responseText);
						}
					})
				});
				var id = '';
				$(".edit").unbind('click');
				$('body').on('click','.edit',function (e) {
					var title = $(this).data('title');
					var code = $(this).data('code');
					var discount = $(this).data('discount');
					var count = $(this).data('count');
					var type = $(this).data('type');
					var expire_date = $(this).data('expire_date');
					id = $(this).data('id');
					$('.title').val(title);
					$('.code').val(code);
					$('.discount').val(discount);
					$('.expire_date').val(expire_date);
					if(type == "perc") {
						$('.percentage').prop("checked", true);
					}else if(type == "fixed"){
						$('.amount').prop("checked", true);
					}else {
						$('.item').prop("checked", true);
					}
					$('.count').val(count);
					if($(this).data('type_item') == "product")
					{
						if($(this).data('include_all') == 1)
						{
							console.log($(this).data('include_all'));
							var type_product = $(this).data('product-all');
							$('.type_product').val(type_product);
						}else{
							@foreach($products as $pro)
							var proId_{{$pro->id}}= $(this).data('product-{{$pro->id}}');
							$('.type_product').val(proId_{{$pro->id}});
							var itemsProduct = [$('.type_product').val()];
							$('.type_product').val([itemsProduct]).change();
							$('.selectpicker').selectpicker('refresh');
							@endforeach
						}
					}
				});
				$(".save").unbind('click');
				$('body').on('submit','#form_edit',function (e) {
					e.preventDefault();
					var table = $('.dataTable').DataTable();
					$.ajax({
						url: '{{ url('admin/settings/discount_code') }}/' + id,
						method: "post",
						data: new FormData(this),
						dataType: 'json',
						cache       : false,
						contentType : false,
						processData : false,
						success: function (res) {
							if(res[0] == false) {
								$.each(res.errors, function(key, value){
									$('.alert-danger').show();
									$('.alert-danger').append('<p>'+value+'</p>');
								});
							} else {
								$('.modal.edit_modal').modal('hide');
								table.ajax.reload();
								new Noty({
									type: 'success',
									layout: 'topRight',
									text: "{{ _i('Updated Successfully')}}",
									timeout: 2000,
									killer: true
								}).show();
							}
						}
					});
				});
			});
			$('body').on('click','.edit',function (e) {
				e.preventDefault();
				rowId = $(this).data('id');
				console.log(rowId);
				$.ajax({
					url: '{{ route('discount_codes.get_types') }}',
					method: "get",
					data:{discountId:rowId},
					success: function (res) {
						console.log(res.data_category);
						console.log(res.data_product);
						if(res.data_category != null){
							$('.type_category').val(res.data_category);
							$('.type_category').selectpicker('refresh');
						}
						if(res.data_product != null){
							$('.type_product').val(res.data_product);
							$('.type_product').selectpicker('refresh');
						}
						if(res.data_userGroup != null){
							$('.type_userGroup').val(res.data_userGroup);
							$('.type_userGroup').selectpicker('refresh');
						}
					}
				});
			});
		</script>
	@endpush
@endsection