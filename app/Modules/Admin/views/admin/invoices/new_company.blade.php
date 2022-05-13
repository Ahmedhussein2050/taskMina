<div class="modal fade modal_create" id="new_campany" tabindex="-1">
   <div class="modal-dialog" role="document">
	  <div class="modal-content">
		 <div class="modal-header" >
			<h5 class="modal-title">{{_i('Campaign Conditions')}}</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: white;">
			<span aria-hidden="true">&times;</span>
			</button>
		 </div>
		 <form class="save_shipping_company" method="POST" action="{{url('admin/save_shipping_company')}}" enctype="multipart/form-data" data-parsley-validate="">
			@csrf
			<input type="hidden" name="free_shipping" value="0">
			<div class="modal-body p-b-0">
			   <div class="form-group row ">
				  <div class="col-sm-12">
					 <div class="input-group ">
						<input class="form-control " name="company_name" placeholder="{{_i('Company Name')}}" required="">
						<span class="input-group-addon input-group-addon-small" id="basic-addon5">
						<i class="fa fa-industry"></i>
						</span>
					 </div>
					 <div class="input-group ">
						<input type="file" name="logo"  accept="image/*">
					 </div>
					 <textarea class="form-control" name="description" placeholder="{{_i('Company description')}}"></textarea>
				  </div>
			   </div>
			   <div class="section_shipping_price_add">
			   </div>
			   <div class="form-group row ">
				  <div class="col-sm-12">
					 <button type="button" class="btn btn-inverse add_shipping_price" ><i class="fa fa-plus"></i> {{_i('Add Shipping Price')}}</button>
				  </div>
			   </div>
			</div>
			<div class="modal-footer">
			   <button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
			   <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
			</div>
		 </form>
	  </div>
   </div>
</div>
@push('js')
<script>
   $('body').on('change','.delivery_method', function () {
	   var selectedMethod = $(this).children("option:selected").val();
	   if(selectedMethod == 'available'){
		   //alert("You have selected the country - " + selectedMethod);
		  // var html='';
		  // html += ' <div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
		  // html += ' <input type="number" class="form-control " name="cash_delivery_commission[]" placeholder="{{_i('Cash delivery commission')}}">';
		  // html += ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-money"></i> </span> ';
		  // html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button> ';
		   //html += ' </div> </div> </div> ';

		  // $(this).closest('.single_shipping_price').find('.cach_commission').append(html);

		   $(this).closest('.single_shipping_price').find('.cach_commission').show();

	   }else{
		  // $(this).closest('.single_shipping_price').find('.cach_commission').empty();
		   $(this).closest('.single_shipping_price').find('.cach_commission').hide();
	   }
	   //alert("You have selected the country - " + selectedMethod);
   });

   $('body').on('change','.pricing_type', function () {
	   var selectedType = $(this).children("option:selected").val();
	   if(selectedType == 'by_weight'){
		   $(this).closest('.single_shipping_price').find('.pricing_type_by_weight').show();
		   $(this).closest('.single_shipping_price').find('.pricing_type_fixed').hide();

		   // $(this).closest('.single_shipping_price').find($('input[name="no_kg"]').prop('required',true));
		   // $(this).closest('.single_shipping_price').find($('input[name="cost_no_kg"]').prop('required',true));
		   // $(this).closest('.single_shipping_price').find($('input[name="cost_increase"]').prop('required',true));
		   // $(this).closest('.single_shipping_price').find($('input[name="kg_increase"]').prop('required',true));

		   $(this).closest('.single_shipping_price').find($('.no_kg').prop('required',true));
		   $(this).closest('.single_shipping_price').find($('.cost_no_kg').prop('required',true));
		   $(this).closest('.single_shipping_price').find($('.cost_increase').prop('required',true));
		   $(this).closest('.single_shipping_price').find($('.kg_increase').prop('required',true));
		   $(this).closest('.single_shipping_price').find($('.cost').prop('required',false));

	   }else{
		   $(this).closest('.single_shipping_price').find('.pricing_type_fixed').show();
		   $(this).closest('.single_shipping_price').find('.pricing_type_by_weight').hide();

		   $(this).closest('.single_shipping_price').find($('.cost').prop('required',true));
		   $(this).closest('.single_shipping_price').find($('.no_kg').prop('required',false));
		   $(this).closest('.single_shipping_price').find($('.cost_no_kg').prop('required',false));
		   $(this).closest('.single_shipping_price').find($('.cost_increase').prop('required',false));
		   $(this).closest('.single_shipping_price').find($('.kg_increase').prop('required',false));
	   }
	   //alert("You have selected the country - " + selectedMethod);
   });

   $('body').on('click','.add_shipping_price', function () {

	   var section_shipping_price_add="section_shipping_price_add";
	   var html='';
	   html += ' <div class="single_shipping_price">';

	   html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
	   html += '<select class="form-control country_id" name="country_id[]" required="" >';
	   html += '<option selected disabled  >{{_i('Choose Country')}}</option>';
	   html += '<option  value="all" >{{_i('All Countries')}}</option>';
	   @foreach($countries as $country)
		   html += '<option value="{{$country->id}}" >{{$country->title}}</option>';
	   @endforeach
		   html += '</select>';
	   html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map"></i></span>';
	   html += '</div> </div> </div>';

	   //<!--------------------------- cities--------------------->
	   html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
	   // html += '<select class="form-control selectpicker city_id" multiple="multiple" name="city_id[]" >';
	   html += '<select class="form-control  city_id js-example-basic-multiple"  multiple="multiple" name="city_id[]"   required="">';
	   html += '<option  value="all">{{_i('All Cities')}}</option>';
	   html += '</select>';
	   html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-map-alt"></i></span>';
	   html += '</div> </div> </div>';

	   //<!--------------------------- pricing type --------------------->
	   html += '<div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
	   html += '<select class="form-control  pricing_type"  name="pricing_type[]" >';
	   html += '<option selected value="fixed">{{_i('Pricing Type : Fixed')}}</option>';
	   html += '<option  value="by_weight">{{_i('Pricing Type : By Weight')}}</option>';
	   html += '</select>';
	   html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-wallet"></i></span>';
	   html += '</div> </div> </div>';

   //<!--------------------------------------------------------- shipping cost --------------------->
   //<!----------------------- if Pricing Type : By Weight ----------------->
	   html += '<div class="pricing_type_by_weight" style="display: none" >';
	   html += '<div class="form-group row "><div class="col-sm-12"><label  > {{_i('Cost')}}</label></div>';
	   html += ' <div class="col-sm-6"><div class="input-group ">';
	   html += ' <input class="form-control no_kg" type="number"  name="no_kg[]" placeholder="{{_i('The first kilogram')}}">';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('KG')}}</button>';
	   html += ' </div> </div>';
	   html += ' <div class="col-sm-6"><div class="input-group ">';
	   html += ' <input class="form-control cost_no_kg" type="number"  name="cost_no_kg[]" placeholder="{{_i('Shipping Cost')}}">';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button>';
	   html += ' </div> </div> </div>';
	   //<!-------------- Cost of the increase ---------->
	   html += ' <div class="form-group row "><div class="col-sm-12"><label  > {{_i('Cost of the increase')}}</label></div>';
	   html += ' <div class="col-sm-6"><div class="input-group ">';
	   html += ' <input class="form-control cost_increase " type="number"  name="cost_increase[]" placeholder="{{_i('Cost of the increase')}}">';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button>';
	   html += ' </div> </div>';
	   html += ' <div class="col-sm-6"><div class="input-group ">';
	   html += ' <input class="form-control kg_increase" type="number"  name="kg_increase[]" placeholder="{{_i('Cost by weight')}}">';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('KG')}}</button>';
	   html += ' </div> </div> </div> </div>';

   //<!--------------------------- if Pricing Type : Fixed --------------------->
	   html += ' <div class="pricing_type_fixed"><div class="form-group row "><div class="col-sm-12"><div class="input-group ">';
	   html += ' <input class="form-control cost" type="number"  name="cost[]" placeholder="{{_i('Shipping Cost')}}">';
	   html += ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-money"></i></span>';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button>';
	   html += ' </div> </div> </div> </div>';

	   // <!--------------------------- shipping time -------------------------------------------------------->
	   html += '<div class="form-group row "><div class="col-sm-12"><div class="input-group ">';
	   html += '<input type="number" class="form-control " name="delay[]" placeholder="{{_i('Shipping time (For example 3-5 days)')}}">';
	   html += '<span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="fa fa-clock-o"></i></span>';
	   html += ' </div> </div> </div>';

	   //<!--------------------------- Paiement on delivery ------------------------------>
	   html += ' <div class="form-group row "><div class="col-sm-12"><div class="input-group ">';
	   html += ' <select class="form-control  delivery_method"  name="delivery_method[]"  >';
	   html += ' <option selected >{{_i('Paiement on delivery ?')}}</option>';
	   html += ' <option  value="available">{{_i('Payment on delivery: Available')}}</option>';
	   html += ' <option  value="not_available">{{_i('Payment on delivery: Not available')}}</option>';
	   html += ' </select>';
	   html += ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"><i class="ti ti-wallet"></i></span>';
	   html += ' </div> </div> </div>';

	   //<!--------------------------- cash_delivery_commission ------------------------------>
	   html += ' <div class="cach_commission" style="display: none">';
	   html += ' <div class="form-group row "> <div class="col-sm-12"> <div class="input-group ">';
	   html += ' <input type="number" class="form-control " name="cash_delivery_commission[]" placeholder="{{_i('Cash delivery commission')}}">';
	   html += ' <span class="input-group-addon input-group-addon-small" id="basic-addon5"> <i class="ti ti-money"></i> </span> ';
	   html += ' <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{_i('SR')}}</button> ';
	   html += ' </div> </div> </div> ';
	   html += ' </div>';

   //<!--------------------------- delete shipping price --------------------->
	   html += ' <div class="form-group row "><div class="col-sm-12">';
	   html += '<button type="button" class="btn btn-danger "  onclick="delete_shipping_price_section(this , null)"  ><i class="fa fa-times"></i> {{_i('Delete Condition')}}</button>';
	   html += '</div> </div>';

	   html += '</div> ';
	   console.log('here');

	   $('.'+section_shipping_price_add).prepend(html);
	   $(".js-example-basic-multiple").select2();
		   $(".js-example-basic-multiple").select2({
			   placeholder: "Select City",
			   allowClear: true
		   });
	   });
   $('body').on('change','.country_id', function () {
	   var cityId = $(this).closest('.single_shipping_price').find('.city_id');
	   var countryId = $(this).children("option:selected").val();
	   console.log(countryId)
	   cityId.attr("name", "city_id["+countryId+"][]");
	   $.ajax({
		   url: '{{ url('admin/shipping/get_cities') }}',
		   method: "get",
		   data: {
			   country_id: countryId,
		   },
		   success: function (response) {
			   cityId.empty();
			   var html = '';
			   cityId.append('<option selected value="all">{{_i('All Cities')}}</option>');
			   $.each(response , function (key , row) {
				   html += '<option  value=" '+row.id+' ">'+row.title+'</option>';
				   //$('.city_id').append('<option  value=" '+row.id+' ">'+row.title+'</option>');
			   });
			   $(".js-example-basic-multiple").select2();
			   cityId.append(html);
		   }
	   });
   });

   function delete_shipping_price_section(obj,option_id) {
	   if(option_id == null){
		   $(obj).closest('.single_shipping_price').remove();
	   }else{
		   $.ajaxSetup({
			   headers: {
				   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			   }
		   });
		   $.ajax({
			   url: '{{ url('admin/shipping_option/delete') }}',
			   data: {
				   '_method': 'DELETE',
				   'optionId': option_id
			   },
			   type: "POST",
			   success: function (response) {
				   $(obj).closest('.single_shipping_price').remove();
				   $('.modal.modal_create').modal('hide');
				   Swal.fire({
					   //position: 'top-end',
					   icon: 'success',
					   title: '{{_i("Deleted Successfully")}}',
					   showConfirmButton: false,
					   timer: 5000
				   });

			   }
		   });
	   }
   }
</script>
@endpush
