@extends('admin.layout.index',[
	'title' => _i('Category Design'),
	'subtitle' => _i('Category Design'),
	'activePageName' => _i('Category Design'),
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
							<h5>{{ _i('Uploading attachments') }}</h5>
							<div class="card-header-right"></div>
						</div>
						<div class="card-block">
							<div class="card-body  ">
								<form action="{{route('category.update.feature')}}" method="POST" enctype="multipart/form-data">
									@csrf
									<input type="number" name="category_id" value="{{$category->id}}" hidden>
									<div class="row">
										<h3 class='mb-4'>{{ _i('Category') }}</h3>
										<div class="col-md-12">
                                            <div class="form-group">
                                                <label for="exampleInputOrder1">{{ _i('File:') }}</label>
                                                <input type="hidden" name="category" id="service-attach-id">
                                                <input type="file" class="form-control modal-title" name='file'>
                                            </div>
										</div>
									</div>
									<div class="box-footer">
										<button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
									</div>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--------------------------------- section 2 => Main menu links ---------------------------------->
{{--			@include('admin.design.custom_list')--}}
		</div>
		<!-- Page-body end -->
	</div>
@endsection
@push('js')

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
