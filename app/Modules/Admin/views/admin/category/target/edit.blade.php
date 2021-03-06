@extends('admin.layout.index',
[
	'title' => _i('Edit Offer'),
	'subtitle' => _i('Edit Offer'),
	'activePageName' => _i('Edit Offer'),
	'activePageUrl' => route('abandoned_carts.index'),
	'additionalPageName' => _i('Offers'),
	'additionalPageUrl' => route('offers.index') ,
])

@section('content')
	<div class="page-body">
		<form  action="{{ route('offers.update', $discount->id)}}" method="post" class="form-horizontal" data-parsley-validate="" >
			@csrf
			@method('PATCH')
			<div class="row">
				<!------------------------------------- Offer details ----------------------------->
				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5> {{ _i('Offer Details') }} </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>

						<div class="card-block">
							<div class="card-body card-block">
								<!---- offer name ----->
								<div class="form-group row">
									<div class="col-sm-10">
										<div class="input-group">
											<input type="text" class="form-control" name="offer_name" placeholder="{{_i('Offer Name')}}" value="{{$discount_data->title}}" required="">
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-ticket"></i>
										</span>
										</div>
									</div>
								</div>
								<!----==========================  end date ==========================--->
								<div class="form-group row">
									<div class="col-sm-10">
										<div class="input-group">
											<input type="date" id="date" name="expire_date" class="form-control" value="{{$discount->expire_date}}" data-inputmask="'alias': 'mm/dd/yyyy'" data-mask="" placeholder="{{_i('Expire Date')}}" >
											<span class="input-group-addon" id="basic-addon5">
												<i class="icofont icofont-calendar"></i>
											</span>
										</div>
										<small  class="form-text text-muted" style="margin-top:-15px;">{{_i('Please select expire date offer')}}</small>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5> {{ _i('If the client buy') }} </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block">
								<div class="form-group row">
									<div class="col-sm-6">
										<div class="input-group">
											<select class="form-control" name="discount_code_item_type" id="discount_code_item_type" required="" >
												<option selected disabled>{{_i('Select the option')}}</option>
												<option value="product" {{$discount_items[0]['type'] == "product" ? "selected" : ""}}>{{_i('Selected products')}}</option>
												<option value="category" {{$discount_items[0]['type'] == "category" ? "selected" : ""}}>{{_i('Selected categories')}}</option>
											</select>
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-jersey"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-4">
										<div class="input-group">
											<select class="form-control" name="items_count" required="">
												<option selected disabled>{{_i('Quantity ')}}</option>
												@for($i = 1 ; $i <= 100 ; $i++)
													<option value="{{$i}}" {{$discount->items_count == $i ? "selected":""}}>{{$i}}</option>
												@endfor
											</select>
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-basket"></i>
										</span>
										</div>
									</div>
								</div>

								<div id="items_category" @if($discount_items[0]['type'] == "category") style="display: block" @else  style="display: none"  @endif>
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="input-group">
												<select class="form-control selectpicker" multiple="multiple" name="buyCategories[]">
													<option selected disabled>{{_i('Select categories')}}</option>
													<option value="all_category" @if($discount_items[0]['include_all'] == 1) selected @endif>{{_i('All Categories')}}</option>
													@foreach($categories as $cat)
														<option value="{{$cat->id}}"
														@foreach($discount_items_category as $saved_item) @if($cat->id == $saved_item['item_id']) selected  @endif @endforeach
														>{{$cat->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>

								<div id="items_product" @if($discount_items[0]['type'] == "product") style="display: block" @else  style="display: none"  @endif>
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="input-group">
												<select class="form-control selectpicker" multiple="multiple" name="buyProducts[]">
													<option selected disabled>{{_i('Select Products')}}</option>
													<option value="all_product" @if($discount_items[0]['include_all'] == 1) selected @endif>{{_i('All Products')}}</option>
													@foreach($products as $product)
														<option value="{{$product->prod_id}}"
													   @foreach($discount_items_product as $saved_item) @if($product->prod_id == $saved_item['item_id']) selected  @endif @endforeach
														>{{$product->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-12">
					<div class="card">
						<div class="card-header">
							<h5> {{ _i('Obtains') }} </h5>
							<div class="card-header-right">
								<i class="icofont icofont-rounded-down"></i>
							</div>
						</div>
						<div class="card-block">
							<div class="card-body card-block">
								<div class="form-group row">
									<div class="col-sm-6">
										<div class="input-group">
											<select class="form-control" name="discount_type" id="discount_type"  required="">
												<option selected disabled>{{_i('Discount Type')}}</option>
												<option value="perc" class="discount_type_perc" {{$discount['type'] == "perc" ? "selected":""}}>{{_i('Discount by Percentage')}}</option>
												<option value="item" class="discount_type_item" {{$discount['type'] == "item" ? "selected":""}}>{{_i('Free Product')}}</option>
											</select>
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-navigation-menu"></i>
										</span>
										</div>
									</div>
									<div class="col-sm-4 discount">
										<div class="input-group ">
											<input type="number" class="form-control " name="discount"  value="{{$discount['discount']}}" max="100" min="1" placeholder="{{_i('discount percentage')}}" >
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-sale-discount"></i>
										</span>
										</div>
									</div>
								</div>
								<div class="form-group row">
									<div class="col-sm-10">
										<div class="input-group">
											<select class="form-control " name="model_type" id="model_type">
												<option selected disabled>{{_i('Select the option')}}</option>
												<option value="products" {{$discount_target[0]['model_type'] == "products" ? "selected":""}}>{{_i('Selected products')}}</option>
												<option value="category" {{$discount_target[0]['model_type'] == "category" ? "selected":""}}>{{_i('Selected categories')}}</option>
											</select>
											<span class="input-group-addon" id="basic-addon5">
											<i class="icofont icofont-jersey"></i>
										</span>
										</div>
									</div>
								</div>
								<div id="section_category" @if($discount_target[0]['model_type'] == "category") style="display: block" @else  style="display: none"  @endif>
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="input-group">
												<select class="form-control selectpicker" multiple="multiple" name="optainCategories[]">
													<option selected disabled>{{_i('Select categories')}}</option>
													@foreach($categories as $cat)
														<option value="{{$cat->id}}"
														@foreach($discount_target_category as $saved_item) @if($cat->id == $saved_item['item_id']) selected  @endif @endforeach
														>
															{{$cat->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
								<div id="section_product" @if($discount_target[0]['model_type'] == "products") style="display: block" @else  style="display: none"  @endif>
									<div class="form-group row">
										<div class="col-sm-10">
											<div class="input-group">
												<select class="form-control selectpicker" multiple="multiple" name="optainProducts[]">
													<option selected disabled>{{_i('Select Products')}}</option>
													@foreach($products as $product)
														<option value="{{$product->prod_id}}"
														@foreach($discount_target_product as $saved_item) @if($product->prod_id == $saved_item['item_id']) selected  @endif @endforeach
														>{{$product->title}}</option>
													@endforeach
												</select>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class=" col-sm-12 text-center " >
					<button type="submit"  class="btn btn-primary  btn-round col-sm-10">{{_i('Save')}}</button>
				</div>
			</div>
		</form>
	</div>
@endsection
@push('js')
	<script>
		//section 2 => if client buy
		$('body').on('change' , '#discount_code_item_type' , function(){ // if selected option change
			var discountItemType = $(this).val();
			console.log($(this).val());

			if (discountItemType == "product"){
				$('#items_category').hide();
				$('#items_product').show();
			}
			else{
				$('#items_category').show();
				$('#items_product').hide();
			}
		});

		// section 3 => optains
		$("#discount_type").val("perc"); // put option selected

		$('body').on('change' , '#discount_type' , function(){ // if selected option change
			var discountType = $(this).val();
			//console.log($(this).val());

			if (discountType == "perc")
				$('.discount').css('display','block');
			else
				$('.discount').css('display','none');
		});

		//show_sections
		$('body').on('change' , '#model_type' , function(){
			var modelType = $(this).val();

			if (modelType == "products"){
				$('#section_category').hide();
				$('#section_product').show();
			}
			else{
				$('#section_category').show();
				$('#section_product').hide();
			}
		});

		$('body').on('change' , '#mod_type' , function(){ // if selected option change
			var modelType = $(this).val();
			//console.log($(this).val());
			//var html ='';
			if (modelType == "products"){
				//$('#section_product').css('display','block');
				//$('#section_product').show();

				var html ='';
				html +='<div class="form-group row"> <div class="col-sm-10"> <div class="input-group">';
				html +='<select class="form-control " id="show_product" multiple="multiple" name="optainProducts[]">';
				html +='<option selected disabled>{{_i('Select Products')}}</option>';
				@foreach($products as $product)
					html +='<option value="{{$product->prod_id}}">{{$product->title}}</option>';
				@endforeach
					html +='</select> </div> </div> </div>';
				$('#section_product').prepend(html);
				$('#show_product').addClass("selectpicker");
				$('#show_product').selectpicker('refresh');
				$('#section_category').css('display','none');
				//('#section_category').hide();
			}
			else{
				$('#section_category').css('display','block');
				// $('#section_category').show();

				var html_cat ='';
				html_cat +='<div class="form-group row"> <div class="col-sm-10"> <div class="input-group">';
				html_cat +='<select class="form-control " id="show_category" multiple="multiple" name="optainCategories[]">';
				html_cat +='<option selected disabled>{{_i('Select categories')}}</option>';
				@foreach($categories as $cat)
					html_cat +='<option value="{{$cat->id}}">{{$cat->title}}</option>';
				@endforeach
					html_cat +='</select> </div> </div> </div>';
				$('#section_category').prepend(html_cat);
				$('#show_category').addClass("selectpicker");
				$('#show_category').selectpicker('refresh');
				// $('#section_product').css('display','none');
				$('#section_product').hide();

			}
		});

		//show_sections
		$('body').on('change' , '#mod_type' , function(){
			var modelType = $(this).val();
			if (modelType == "products"){

				// $('#section_category').empty();
				$('#section_product').prepend('<div class="form-group row"> <div class="col-sm-10"> <div class="input-group">'+
					'<select class="form-control " id="show_product" multiple="multiple" name="optainProducts[]">'+
					'<option selected disabled>{{_i('Select Products')}}</option>'
						@foreach($products as $product)
					+'<option value="{{$product->prod_id}}">{{$product->title}}</option>'+
						@endforeach
							'</select> </div> </div> </div>');
				//$('#show_product').addClass("selectpicker");
				//$('#show_product').selectpicker('refresh');
			}
			else{
				// $('#section_product').empty();
				$('#section_category').prepend('<div class="form-group row"> <div class="col-sm-10"> <div class="input-group">'+
					'<select class="form-control " id="show_category" multiple="multiple" name="optainCategories[]">'+
					'<option selected disabled>{{_i('Select categories')}}</option>'
						@foreach($categories as $cat)
					+'<option value="{{$cat->id}}">{{$cat->title}}</option>'+
						@endforeach
							'</select> </div> </div> </div>');
				//$('#show_category').addClass("selectpicker");
				// $('#show_category').selectpicker('refresh');
			}
		});
	</script>
@endpush