<div class="modal-body">
	<div class="category_well">
		<form id='frm_master' data-parsley-validate='' enctype="multipart/form-data" method='post' action='{{url("admin/categories/update")}}'>
			@method('PATCH')
			@csrf
			@foreach($categories as $category)
				<div class="well" id="well_{{$category->id}}">
					<div class="form-group parent" data-cat-id="category.id">
						<div class="input-group mb-3">
							<input type="text" value="{{$category->title}}" class="form-control input" data-category_id="{{$category->id}}" name="parentCategory[{{$category->id}}]" required="" class="input border-danger" >
							<input type="hidden" class="p_sort" id='sort_{{$category->id}}' value="{{$category->number}}" name='parent_sort[{{$category->id}}]'>

							<div class="input-group-append">
								<button type="button" class="btn btn-default up" onclick="moveMasterUp(this,{{$category->id}})"><i class="ti-angle-up"></i></button>
								<button type="button" class="btn btn-default down" onclick="moveMasterDown(this,{{$category->id}})"><i class="ti-angle-down"></i></button>
								<button type="button" data-del='1' class="btn btn-default delete" onclick="categorydel(this,{{$category->id}})"><i class="ti-close"></i></button>
								<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{_i('Translation')}}">
									<span class="ti ti-settings"></span>
								</button>
								<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
									@foreach ($languages as $lang)
										<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="{{$category->id}}" data-lang="{{$lang->id}}" style="display: block; padding: 5px 10px 10px;">{{$lang->title}}</a></li>
									@endforeach
								</ul>
							</div>
							@empty($category->image)
								<label for="file-upload-{{$category->id}}" class="custom-file-upload btn btn-default mr-1">
									<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
								</label>
								@else
									<div class="dropdown mr-1" hidden>
										<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											{{ _i('Change image') }}
										</button>
										<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
											<a class="dropdown-item" href="#">{{ _i('View image') }}</a>
											<a class="dropdown-item" href="#"><label for="file-upload-{{$category->id}}">{{ _i('Change image') }}</label></a>
										</div>
									</div>
									<label for="file-upload-{{$category->id}}" class="custom-file-upload btn btn-default mr-1 category-image-label">
										<img src="{{ asset($category->image) }}" alt="" class='category-image'>
									</label>
									@endempty
									<input id="file-upload-{{$category->id}}" name='parent_images[{{$category->id}}]' type="file" accept='image/*' class='file-upload ajax-upload' data-id='{{ $category->id }}'>
						</div>
					</div>
					@foreach(get_sub_categories($category->id) AS $child)
						<div class="form-group child"  >
							<div class="input-group mb-3 subCategory">
								<input type="text" value='{{$child->title}}' class="form-control"name="category[{{$category->id}}][{{$child->id}}]" required="" class="input border-danger">
								<input type="hidden" class="c_sort" value="{{$child->number}}" name="sort[{{$category->id}}][{{$child->id}}]">
								<div class="input-group-append" id="child.id">
									<button class="btn btn-default up" type="button" onclick="up(this,{{$category->id}})"><i class="ti-angle-up"></i></button>
									<button class="btn btn-default down" type="button" onclick="down(this,{{$category->id}})"><i class="ti-angle-down"></i></button>
									<button class="btn btn-default delete" type="button"  data-del='1'  onclick="subdel(this, {{$child->id}})"><i class="ti-close"></i></button>
									<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title="{{_i('Translation')}}">
										<span class="ti ti-settings"></span>
									</button>
									<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
										@foreach ($languages as $lang)
											<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="{{$child->id}}" data-lang="{{$lang->id}}" style="display: block; padding: 5px 10px 10px;">{{$lang->title}}</a></li>
										@endforeach
									</ul>
								</div>
								@empty($child->image)
									<label for="file-upload-{{$child->id}}" class="custom-file-upload btn btn-default mr-1">
										<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
									</label>
									@else
										<label for="file-upload-{{$child->id}}" class="custom-file-upload btn btn-default mr-1 category-image-label">
											<img src="{{ asset($child->image) }}" alt="" class='category-image'>
										</label>
										@endempty
										<input id="file-upload-{{$child->id}}" name='sub_images[{{$child->id}}]' type="file" accept='image/*' class='file-upload ajax-upload' data-id='{{ $child->id }}'>
							</div>
						</div>
					@endforeach
					<div class="form-group">
						<button class="btn btn-tiffany sub-category" type="button" onclick="addSubCategory({{$category->id}})">{{_i("Add sub category")}}</button>
					</div>
				</div>
			@endforeach
		</form>
	</div>
</div>
<div class="form-group">
	<button class="btn btn-tiffany category" type="button" onclick="addCategory()">{{_i("Add Category")}}</button>
</div>
<div class="modal-footer">
	<div class="form-group">
		<button class="btn btn-tiffany save-category" type="button" onclick="saveAllCat()">{{_i("Save")}}</button>
	</div>
</div>

@push("js")
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
<script type="text/javascript">
	function  addCategory()
	{
		index = "m_" + ($("#frm_master").children(".well").length + 1);
		i =  $("#frm_master").children(".well").last().find(".p_sort").val() ;
		if(isNaN(i))
			i=0;
		i =parseInt(i)+1;
		well =($(".well").length+1);
		if(isNaN(well))
			well=0;
		$("#frm_master").append(`  <div class="well" id="well_` + index + `">
								<div class="form-group parent" ">
									<div class="input-group mb-3">
										<input type="text" value="" class="form-control input"  name="parentCategory[new][`+well+`][]" required="" class="input border-danger" >
										<input type="hidden" class="p_sort" id="sort_` + index + `" value="` + i + `" name='parent_sort[new][`+well+`][]'>
										<div class="input-group-append">
											<button type="button" class="btn btn-default up" onclick="moveMasterUp(this, '` + index + `')"><i class="ti-angle-up"></i></button>
											<button type="button" class="btn btn-default down" onclick="moveMasterDown(this, '` + index + `')"><i class="ti-angle-down"></i></button>
											<button type="button" data-del='0' class="btn btn-default delete" onclick="categorydel(this,'` + index + `')"><i class="ti-close"></i></button>
											<label for="file-upload-`+well+`" class="custom-file-upload btn btn-default">
												<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
						</label>
                        <input id="file-upload-`+well+`" name='parent_images[new][`+well+`]' type="file" accept='image/*' class='file-upload'>
										</div>
									</div>
								</div>
								<div class="form-group">
									<button class="btn btn-tiffany sub-category" type="button" onclick="addSubCategory('` + index + `','1')">{{_i("Add sub category")}}</button>
							</div>
							</div>
							`);
	}

	function addSubCategory(index, initialized="") {
		var select = ".child";
		var rand = Math.floor(Math.random() * 100) + 1;

		if ($("#well_" + index).find(select).length == 0)
		{
			i=0;
			select = ".parent";
			obj = $("#well_" + index).children(select).last();
		}
		else
		{
			//i=$("#well_" + index).last(".child").find(".c_sort").val();
			i=$("#well_" + index).last(".child").find(".c_sort").length;
			// i =parseInt(i)+1;
			// alert(i);
			obj = $("#well_" + index).find(select).last();
		}
		var key="";
		if(initialized=="")
		{
			var key ="["+index+"][new]";
		}
		else
		{
			index =($(".well").length);
			var key ="[new]["+index+"]";
		}

		obj.append(`  <div class="form-group child"  >
									<div class="input-group mb-3 subCategory">
										<input type="text" class="form-control" data-category-id="" name="category`+key+`[]" required="" class="input border-danger">
										<input type="hidden" class="c_sort" name="sort`+key+`[]" value="`+i+`">
										<div class="input-group-append" id="child.id">
											<button class="btn btn-default up" type="button" onclick="up(this, ` + index + `)"><i class="ti-angle-up"></i></button>
											<button class="btn btn-default down" type="button" onclick="down(this, ` + index + `)"><i class="ti-angle-down"></i></button>
											<button class="btn btn-default delete" data-del='0' type="button" onclick="subdel(this,` + index + ` )"><i class="ti-close"></i></button>
											<label for="file-upload-`+rand+`" class="custom-file-upload btn btn-default">
												<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
						</label>
                        <input id="file-upload-`+rand+`" name='sub_images`+key+`[]' type="file" accept='image/*' class='file-upload'>
										</div>
									</div>
								</div>`);
	}

	function moveMasterUp(obj, i)
	{
		var current = $(obj.closest(".well"));
		var find = $(obj.closest(".well")).prev(".well");

		if (find.length > 0)
		{
			$(current).insertBefore(find);

			var pos = $(current).find(".p_sort").val(); //.find(".p_sort").html()
			pos = parseInt(pos);
			$(current).find(".p_sort").val(pos - 1);

			var pos = $(find).find(".p_sort").val(); //.find(".p_sort").html()
			pos = parseInt(pos);
			$(find).find(".p_sort").val(pos + 1);
		}
	}

	function up(obj, i)
	{
		var current = $(obj.closest(".child"));
		var find = $(obj.closest(".child")).prev(".child");
		if (find.length > 0)
		{
			$(current).insertBefore(find);
		}
	}

	function down(obj, i)
	{
		var current = $(obj.closest(".child"));
		var find = $(obj.closest(".child")).next(".child");
		if (find.length > 0)
		{
			$(current).insertAfter(find);
		}
	}

	function moveMasterDown(obj, i)
	{
		var current = $(obj.closest(".well"));
		var find = $(obj.closest(".well")).next(".well");
		if (find.length > 0)
		{
			$(current).insertAfter(find);
			var pos = $(current).find(".p_sort").val(); //.find(".p_sort").html()
			pos = parseInt(pos);
			$(current).find(".p_sort").val(pos + 1);

			var pos = $(find).find(".p_sort").val(); //.find(".p_sort").html()
			pos = parseInt(pos);

			$(find).find(".p_sort").val(pos - 1);
		}
	}

	function categorydel(obj, index) {
		if ($(obj).data("del") == "1")
		{
			Swal.fire({
				title: '',
				text: "{{_i("Please be aware that agreeing to delete this category, will delete all sub - classifications of this category, and this step is not irreversible")}}",
				type: 'warning',
				showCancelButton: true,
				confirmButtonClass: 'red-alert',
				confirmButtonText: "{{_i('Confirm Delete')}}",
				cancelButtonText:  '{{_i("Cancel")}}',
			}).then((result) => {
				if (result.value) {
			$.get('{{url("admin/categories")}}/' + index + '/delete')
					.then((data) => {
				if (data != 'failed'){
				$("#well_" + index).remove();
				swal.fire('{{_i("Alert")}}', '{{_i("Deleted Successfully")}}', "info");
			}else{
				Swal.fire({
					title: '',
					text: "{{_i('This section cannot be deleted because there are products in it. Delete it first')}}",
					type: 'warning',
				});
			}
		});
		}
		});
		} else{
			$("#well_" + index).remove();
		}
	}

	function saveAllCat()
	{
		$('.save-category').attr('disabled', true);
		var result = $("#frm_master").parsley().validate();
		if (result)
		{
			var url = "{{ url('admin/categories/update') }}";
			$.ajax({
				url: url,
				method: "post",
				data: new FormData($('#frm_master')[0]),
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
					if (response == 'success'){
						$('.save-category').attr('disabled', false);
						Swal.fire({
							icon: 'success',
							title: "{{_i('Saved Successfully')}}",
							showConfirmButton: false,
							timer: 5000
						}).then(  function(){}  );
					}
				},
			});
			return false;
			var datacat = $("#frm_master").serialize();
			console.log(datacat);
			$.post('{{url("admin/categories/update")}}', datacat).then((data) => {
				$('#category').modal('toggle');
			$('#category').removeClass('show');
			// location.reload();
		});
			Swal.fire({
				position: 'top-end',
				icon: 'success',
				title: "{{_i('Saved Successfully')}}",
				showConfirmButton: false,
				timer: 5000
			}).then(  function(){}  );
			return;
		}
		Swal.fire({
			title: '{{_i("Alert")}}',
			text: "{{_i('Please complete missing data')}}",
			icon: 'warning',
		});
		window.reload();
	}

	function subdel(obj, i)
	{
		if ($(obj).data("del") == "1")
		{
			$.get('{{url("admin/categories")}}/' + i + '/delete').then((data) => {
				swal.fire("{{_i('alert')}}", '{{_i("Deleted Successfully")}}', "info");
			$(obj.closest(".child")).remove();
		});
		}else{
			$(obj.closest(".child")).remove();
		}
	}

	$(document).on('change', '.file-upload', function() {
		var id = $(this).attr('id');
		var file = $('#' + id)[0].files[0].name;
		$(this).prev('label').text(file);
	});

	$('.file-upload.ajax-upload').change(function(){
		//on change event
		formdata = new FormData();
		if($(this).prop('files').length > 0)
		{
			file = $(this).prop('files')[0];
			id = $(this).data('id');
			formdata.append("image", file);
			formdata.append("id", id);
			formdata.append("_token", "{{ csrf_token() }}");
			jQuery.ajax({
				url: '{{ route('categories.image.upload', 1) }}',
				type: "POST",
				data: formdata,
				processData: false,
				contentType: false,
				success: function (result) {
					Swal.fire({
						title: '{{_i("Alert")}}',
						text: "{{_i('Image updated successfully')}}",
						icon: 'success',
					});
				}
			});
		}
	});

</script>

<style >
	.input-group{
		display:flex
	}
	.up,.down,.delete{
		padding: 10px;
	}
</style>
@endpush
