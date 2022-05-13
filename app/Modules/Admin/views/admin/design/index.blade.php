@extends('admin.layout.index',[
	'title' => _i('Store Design'),
	'subtitle' => _i('Store Design'),
	'activePageName' => _i('Store Design'),
	'activePageUrl' => '',
] )
@section('content')
	@push('css')
		<style>
			.tab-content.mnu__options {
				margin-bottom: 10px!important;
				display: block;
				border: 1px solid #eee;
				border-radius: 10px !important;
				-webkit-box-pack: start;
				-ms-flex-pack: start;
				justify-content: flex-start;
				position: relative;
				padding: 40px!important;
			}
			.mnu__options .fields-cont {
				justify-content: space-between;
				flex-wrap: wrap;
				padding: 20px;
				border-radius: 3px;
				border: 1px solid hsla(0,0%,94%,.8);
				background-color: hsla(0,0%,94%,.2);
			}
			.btn_add_product_menu {
				margin-top: 15px;
				margin-bottom:-10px;
			}
			.tab-content.mnu__options_edit{
				margin-top:10px;
				padding: 20px!important
			}
			.alert-default label{
				color: #212529;
			}
		</style>
	@endpush
	<div class=" user-profile">
		<div class="page-body">
			<!--profile cover end-->

<!--------------------------------- section 2 => design options ---------------------------------->
			<div class="row">
				<div class="col-sm-12 ">
					<div class="card">
						<div class="card-header">
							<h5>{{ _i('Design Options') }}</h5>
							<div class="card-header-right"></div>
						</div>
						<div class="card-block">
							<div class="card-body  ">
								<form action="{{route('admin.design.saveOptions')}}" method="POST">
									@csrf
									 @include('admin.design.partial')
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--------------------------------- section 2 => Main menu links ---------------------------------->
			@include('admin.design.custom_list')
		</div>
		<!-- Page-body end -->
	</div>
@endsection
@push('js')
<script>
	$('body').on('submit','.template_id',function (e) {
		e.preventDefault();
		let url = $(this).attr('action');
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		var form =$(this);
		$.ajax({
			url: url,
			method: "post",
			data: new FormData(this),
		   // dataType: 'json',
			type: 'POST',
			datatype: 'JSON',
			cache       : false,
			contentType : false,
			processData : false,
			success: function (response) {
				$('[data-enable]').hide()
				$('<i class="icofont icofont-check-circled text-primary" data-enable=""></i> <span data-enable=""  class="text-primary"><?=_i("Enabled")?></span>').insertAfter($(form).find("button"));
				var f=$("iframe").first()
				var currSrc = $(f).attr("src");
				$(f).attr("src", currSrc);
				Swal.fire({
					//position: 'top-end',
					icon: 'success',
					title: "{{ _i('Modifications saved')}}",
					showConfirmButton: false,
					timer: 1000
				});
			},
		});
	});
	$('#main_menu').on('change', function () {
		var main_menu = $(this).val();
		var menu = document.getElementById("show_main_menu");
		if(main_menu == "custom_list")
		{
			menu.style.display = "block";
		}else{
			menu.style.display = "none";
		}
	});
 /// custom_list
	function showLinkdiv() {
		var x = document.getElementById("mnu__options");
		if (x.style.display === "none") {
			x.style.display = "block";
		} else {
			x.style.display = "none";
		}
	}
	$('body').on('change' , '.custom_list' , function(){
		var list_type = $(this).val();
		// selected url type
		if (list_type == "product"){
			$('.section_product').show();
			$('.section_category').hide();
			$('.section_page').hide();
			$('.section_link').hide();
		}
		else if (list_type == "category"){
			$('.section_category').show();
			$('.section_product').hide();
			$('.section_page').hide();
			$('.section_link').hide();
		}
		else if (list_type == "pages"){
			$('.section_page').show();
			$('.section_category').hide();
			$('.section_product').hide();
			$('.section_link').hide();
		}else{
			$('.section_link').show();
			$('.section_page').hide();
			$('.section_category').hide();
			$('.section_product').hide();
		}
	});
	$('body').on('change' , '.product_custom_list' , function(){
		var productId = $(this).val();
		var product_name= $(this).find(':selected').attr('data-product');
	   // alert(product_name)
	});
	$('body').on('submit','.save_link',function (e){
		e.preventDefault();
		var link_type = $('.custom_list').val();
		$.ajax({
			url:'{{ route('admin.design.saveMenuLink') }}',
			//data: new FormData(this),
			data: new FormData(this),
			type:'POST',
			dataType: 'json',
			contentType: false,
			processData: false,
			success:function (res) {
				if(res) {
					$('.mnu__options').hide();
					if(link_type == "product"){
						var name= $('.product_custom_list').find(':selected').attr('data-product');
					}else if(link_type == "category"){
						var name= $('.category_custom_list').find(':selected').attr('data-category');
					}else if(link_type == "pages"){
						var name= $('.page_custom_list').find(':selected').attr('data-page');
					}else if(link_type == "link"){
						var name= $('.link_custom_list').val();
					}
					$('.get_links').append('<div class="form-group row div_delete" style="margin-top:-10px;"> <div class="col-sm-12"><div class="alert alert-default small">' +
						'<button type="button" class="close btn-icon" data-dismiss="alert" aria-label="Close" style="color: red; float: left">' +
						'<i class="icofont icofont-ui-delete btn-small " onclick="delFilter('+res.id+')" ></i> </button>' +
						' <strong> '+name+' </strong>' +
						' </div>  </div>  </div>');
				}
			}
		})
	});
	function delFilter(id) {
		// var rowId = id;
		//console.log(id);
		console.log('here');
		$.ajax({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			type: "POST",
			url: "{{ route('admin.design.deleteCustomOption') }}",
			data: { rowId: id},
			success: function (res) {
				//alert('here');
				if(res == true)
				$(this).closest('.div_delete').remove();
			}
		});
	}
	$('body').on('click','.deleteRow',function (){
		var rowID = $(this).attr('data-deleteRow');
		delFilter(rowID);
		$(this).parent().parent().parent().parent().remove();
	});
	function showAddLinkdiv() {
		//$(this).closest('.mnu__options_edit').style.display = "block";
		//var x = document.getElementById("mnu__options_edit");
		//var x = $(this).closest('.div_delete.mnu__options_edit');
		$(this).parent().toggleClass('showMenu');
		// console.log(x);
		// if (x.style.display == "none") {
		//     x.style.display = "block";
		//     $('.design_value').css("color", "#5dd5c4");
		// } else {
		//     x.style.display = "none";
		//     $('.design_value').css("color", "#bdc3c7");
		// }
	}
	/// $(this).find(':selected').attr('data-id')
</script>
	<script>
		$('.close').on('click', function () {
			$(this).parent().toggleClass('showMenu');
		});
	</script>
@endpush
@push('css')
	<style>
		.showMenu .mnu__options_edit{
			display: block !important;
		}
		.showMenu .design_value{
			color: #5dd5c4 !important;
		}
	</style>
@endpush
