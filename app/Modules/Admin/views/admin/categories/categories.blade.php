<div class="modal-body">
    <div class="category_well">

        <form id='frm_master' data-parsley-validate='' enctype="multipart/form-data" method='post'
            action='{{ url('admin/categories/update') }}'>
            @method('PATCH')
            @csrf

            @php($current_step = '')
            @php($padding = 0)


            @foreach ($cats as $id => $step)
                <?php
                $category = $categories[$id];

				$title= str_replace("|","",$step);
				$title= str_replace("--","",$step);

				$category->title = $title;

              	$padding =  substr_count($step,"--")*10;
				$end_dev ="";

                if (strpos($step ,'--')==false) {
					if($loop->index!=0)
					$end_dev ="</div>";
					?>
                <?= $end_dev ?> <div class="well" id="well_{{ $id }}">

                    @include("admin.categories.div")
                    <?php
				}
				else {
					# code...
					?>
                    @include("admin.categories.sub_div",["child"=> $category])

                    <?php
				}

						?>
 				<input type="hidden" name="categories" id="categories_lang" value="{{ json_encode($categories)}}">



            @endforeach
    </div>
    </form>
</div>
</div>
<div class="form-group">
    <button class="btn btn-tiffany category" type="button" onclick="addCategoryv2()">{{ _i('Add Category') }}</button>
</div>
<div class="modal-footer">
    <div class="form-group">
        {{-- <button class="btn btn-tiffany save-category" type="button" onclick="saveAllCat()">{{_i("Save")}}</button> --}}
    </div>
</div>


@push('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script type="text/javascript">
			// let lang = $('#categories_lang').val();

			// console.log(lang);


        function addCategory() {
            index = "m_" + ($("#frm_master").children(".well").length + 1);
            i = $("#frm_master").children(".well").last().find(".p_sort").val();
            if (isNaN(i))
                i = 0;
            i = parseInt(i) + 1;
            well = ($(".well").length + 1);
            if (isNaN(well))
                well = 0;



            $("#frm_master").append(`  <div class="well" id="well_` + index + `" >
								<div class="form-group parent" ">
									<div class="input-group mb-3">
										<input type="text" value="" class="form-control input"  name="parentCategory[new][` + well + `][]" required="" class="input border-danger" >
										<input type="hidden" class="p_sort my_sort" id="sort_` + index + `" value="` + i +
                `" name='parent_sort[new][` + well + `][]'>
										<div class="input-group-append">
											<button type="button" class="btn btn-default up" onclick="moveMasterUp(this, '` + index + `')"><i class="ti-angle-up"></i></button>
											<button type="button" class="btn btn-default down" onclick="moveMasterDown(this, '` + index + `')"><i class="ti-angle-down"></i></button>
											<button type="button" data-del='0' class="btn btn-default delete" onclick="categorydel(this,'` + index + `')"><i class="ti-close"></i></button>
											<button class="btn btn-primary btn-sm add-category-v2">
									<i class="ti ti-plus"></i>
								</button>
											<label for="file-upload-` + well + `" class="custom-file-upload btn btn-default">
												<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
											</label>
											<input id="file-upload-` + well + `" name='parent_images[new][` + well + `]' type="file" accept='image/*' class='file-upload'>
										</div>
									</div>
								</div>
								<div class="form-group">
							</div>
							</div>
							`);
        }
        //  related by old button of add subcategory
        // <button class="btn btn-tiffany sub-category" type="button" onclick="addSubCategory('` + index + `','1')">{{ _i('Add sub category') }}</button>
        function addCategoryv2() {
            index = "m_" + ($("#frm_master").children(".well").length + 1);
            i = $("#frm_master").children(".well").last().find(".p_sort").val();
            if (isNaN(i))
                i = 0;
            i = parseInt(i) + 1;
            well = ($(".well").length + 1);
            if (isNaN(well))
                well = 0;
            $("#frm_master").append(`  <div class="well" id="well_` + index + `"  >
								<div class="form-group parent" data-fordelete="0">
									<div class="input-group mb-3">
										<input type="text" value="" class="form-control input mainCategoryName"  name="parentCategory[new][` + well + `][]" required="" class="input border-danger" >
										<input type="hidden" class="p_sort my_sort" id="sort_` + index + `" value="` + i +
                `" name='parent_sort[new][` + well + `][]'>
										<input type="hidden" class="parent_id" id="parent_id" name='parent_id' value="0">
										<input type="hidden" class="type" name="type" value="new">
										<div class="input-group-append">
											<button type="button" class="btn btn-default up" onclick="moveMasterUp(this, '` + index + `')"><i class="ti-angle-up"></i></button>
											<button type="button" class="btn btn-default down" onclick="moveMasterDown(this, '` + index + `')"><i class="ti-angle-down"></i></button>
											<button type="button" data-del='0' class="btn btn-default delete" onclick="categorydel(this,'` + index + `')"><i class="ti-close"></i></button>
					<button class="btn btn-primary btn-sm add-category-v2" data-id="0" onclick="addCategoryV2(event,this)">
						<i class="ti ti-plus"></i>
					</button>
				<label for="file-upload-` + index + `" class="custom-file-upload btn btn-default">
												<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
		</label>
		<input id="file-upload-` + index + `" name='parent_images[new][` + well + `]' type="file" accept='image/*' class='file-upload categoryImage'>

										<button class="btn btn-info btn-sm " onclick="saveMainCategoryV2(event,this)" >
										<i class="ti ti-save"> </i>
										</button>
										</div>
									</div>
								</div>
								<div class="form-group">
							</div>
							</div>
							`);
        }

        function addSubCategory(index, initialized = "") {
            var select = ".child";
            var rand = Math.floor(Math.random() * 100) + 1;

            if ($("#well_" + index).find(select).length == 0) {
                i = 0;
                select = ".parent";
                obj = $("#well_" + index).children(select).last();
            } else {
                //i=$("#well_" + index).last(".child").find(".c_sort").val();
                i = $("#well_" + index).last(".child").find(".c_sort").length;
                // i =parseInt(i)+1;
                // alert(i);
                obj = $("#well_" + index).find(select).last();
            }
            var key = "";
            if (initialized == "") {
                var key = "[" + index + "][new]";
            } else {
                index = ($(".well").length);
                var key = "[new][" + index + "]";
            }

            obj.append(`<div class="form-group child"  >
									<div class="input-group mb-3 subCategory">
										<input type="text" class="form-control" data-category-id="" name="category` + key + `[]" required="" class="input border-danger">
										<input type="hidden" class="c_sort my_sort" name="sort` + key + `[]" value="` + i + `">
										<div class="input-group-append" id="child.id">
											<button class="btn btn-default up" type="button" onclick="up(this, ` + index + `)"><i class="ti-angle-up"></i></button>
											<button class="btn btn-default down" type="button" onclick="down(this, ` + index + `)"><i class="ti-angle-down"></i></button>
											<button class="btn btn-default delete" data-del='0' type="button" onclick="subdel(this,` + index + ` )"><i class="ti-close"></i></button>
											<label for="file-upload-` + rand + `" class="custom-file-upload btn btn-default">
												<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
											</label>
											<input id="file-upload-` + rand + `" name='sub_images` + key + `[]' type="file" accept='image/*' class='file-upload'>
										</div>
									</div>
								</div>`);
        }

        function saveMainCategoryV2(e, myObj) {
            e.preventDefault();
            let container = $(myObj).parents('.parent:first');
            let subCategoryDiv = $(myObj).parents('.parent:first');
            let parent_id = $(subCategoryDiv).find('input[name=parent_id]').val();
            let name = $(subCategoryDiv).find('.mainCategoryName').val();
            let number = $(subCategoryDiv).find('.p_sort').val();
            let type = $(subCategoryDiv).find('input[name=type]').val();

            let typeField = $(subCategoryDiv).find('input[name=type]');
            let image = null;
            let imageLabel = null;
            let file = null;
            if (type == 'new') {
                file = $(subCategoryDiv).find('.categoryImage');
                imageLabel = $(subCategoryDiv).find('.custom-file-upload');
                image = $(file)[0].files[0];
            }
            let token = '{{ csrf_token() }}';
            let form = new FormData();
            form.append('_token', token);
            form.append('name', name);
            form.append('parent_id', parent_id);
            form.append('type', type);
            if (type == 'new') {
                form.append('file', image);
            }
            form.append('number', number);
            //	Request Ajax
            $.ajax({
                url: "{{ route('create.category.v2') }}",
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    //  swal success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "{{ _i('Saved Successfully') }}",
                        showConfirmButton: false,
                        timer: 5000
                    }).then(function() {});
                    // type value == category_id
                    typeField.val(data['category']['id']);
                    //  update image field
                    new_image = `<img src="` + "{{ asset('/') }}" + data['category']['image'] +
                        ` " alt="" class="category-image">`;
                    if (type == 'new') {
                        imageLabel.empty();
                        imageLabel.append(new_image);
                        console.log($(container).attr('data-fordelete'));
                        $(container).attr('data-fordelete', data['category']['id'])
                        $(container).attr('data-fordelete', data['category']['id'])
                        $(container).find('.add-category-v2').attr('data-id', data['category']['id']);
                    }

                    // balalam
                    location.reload();

                },
                error: function(xhr, textStatus, errorThrown) {
                    var errors = $.parseJSON(xhr.responseText);
                    var vals = '';
                    $.each(errors.errors, function(key, val) {
                        vals = vals + '' + val + '';
                    });
                    Swal.fire({
                        title: '{{ _i('Alert') }}',
                        text: vals,
                        icon: 'warning',
                    });

                }
            });

        }

        function moveMasterUp(obj, i) {
            var current = $(obj.closest(".well"));
            var find = $(obj.closest(".well")).prev(".well");
            if (find.length > 0) {
                $(current).insertBefore(find);
                var pos = $(current).find(".p_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);
                $(current).find(".p_sort").val(pos - 1);
                var pos = $(find).find(".p_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);
                $(find).find(".p_sort").val(pos + 1);
                let sort_ids = [];
                let p_sort_classes = $('body').find('.p_sort');
                p_sort_classes.each(function() {
                    // console.log($(this).parents('div[data-fordelete]:first'));
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let my_sort_classes = $('body').find('.my_sort');
                my_sort_classes.each(function() {
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let token = '{{ csrf_token() }}';
                let url = '{{ route('category.order.update') }}';
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        '_token': token,
                        'data': sort_ids
                    },
                    dataType: 'json',
                    success: function(response) {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var errors = $.parseJSON(xhr.responseText);
                    }
                });

            }
        }

        function up(obj, i) {
            var current = $(obj.closest(".child"));
            var find = $(obj.closest(".child")).prev(".child");

            if (find.length > 0) {
                $(current).insertBefore(find);
                var pos = $(current).find(".c_sort").val();
                //.find(".p_sort").html()
                pos = parseInt(pos);
                $(current).find(".c_sort").val(pos - 1);
                var pos = $(find).find(".c_sort").val();
                //.find(".p_sort").html()
                pos = parseInt(pos);
                // console.log(pos) ;
                $(find).find(".c_sort").val(pos + 1);
                let sort_ids = [];
                let p_sort_classes = $('body').find('.c_sort');
                p_sort_classes.each(function() {
                    // console.log($(this).parents('div[data-fordelete]:first'));
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let my_sort_classes = $('body').find('.my_sort');
                my_sort_classes.each(function() {
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let token = '{{ csrf_token() }}';
                let url = '{{ route('category.order.update') }}';
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        '_token': token,
                        'data': sort_ids
                    },
                    dataType: 'json',
                    success: function(response) {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var errors = $.parseJSON(xhr.responseText);
                    }
                });

            }
        }

        function down(obj, i) {
            var current = $(obj.closest(".child"));
            var find = $(obj.closest(".child")).next(".child");
            if (find.length > 0) {
                $(current).insertAfter(find);
                var pos = $(current).find(".c_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);
                $(current).find(".c_sort").val(pos + 1);
                var pos = $(find).find(".c_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);
                $(find).find(".c_sort").val(pos - 1);
                let sort_ids = [];
                let p_sort_classes = $('body').find('.c_sort');
                p_sort_classes.each(function() {
                    // console.log($(this).parents('div[data-fordelete]:first'));
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                console.log(sort_ids);
                let my_sort_classes = $('body').find('.my_sort');
                my_sort_classes.each(function() {
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let token = '{{ csrf_token() }}';
                let url = '{{ route('category.order.update') }}';
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        '_token': token,
                        'data': sort_ids
                    },
                    dataType: 'json',
                    success: function(response) {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var errors = $.parseJSON(xhr.responseText);
                    }
                });
            }
        }

        function moveMasterDown(obj, i) {
            var current = $(obj.closest(".well"));
            var find = $(obj.closest(".well")).next(".well");
            if (find.length > 0) {
                $(current).insertAfter(find);
                var pos = $(current).find(".p_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);
                $(current).find(".p_sort").val(pos + 1);

                var pos = $(find).find(".p_sort").val(); //.find(".p_sort").html()
                pos = parseInt(pos);

                $(find).find(".p_sort").val(pos - 1);
                let sort_ids = [];
                let p_sort_classes = $('body').find('.p_sort');
                p_sort_classes.each(function() {
                    // console.log($(this).parents('div[data-fordelete]:first'));
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let my_sort_classes = $('body').find('.my_sort');
                my_sort_classes.each(function() {
                    sort_ids.push([$(this).attr('value'), $(this).parents('div[data-fordelete]:first').attr(
                        'data-fordelete')]);
                });
                let token = '{{ csrf_token() }}';
                let url = '{{ route('category.order.update') }}';
                $.ajax({
                    url: url,
                    method: "post",
                    data: {
                        '_token': token,
                        'data': sort_ids
                    },
                    dataType: 'json',
                    success: function(response) {

                    },
                    error: function(xhr, textStatus, errorThrown) {
                        var errors = $.parseJSON(xhr.responseText);
                    }
                });

            }
        }

        function categorydel(obj, index) {
            if ($(obj).data("del") == "1") {
                Swal.fire({
                    title: '',
                    text: "{{ _i('Please be aware that agreeing to delete this category, will delete all sub - classifications of this category, and this step is not irreversible') }}",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonClass: 'red-alert',
                    confirmButtonText: "{{ _i('Confirm Delete') }}",
                    cancelButtonText: '{{ _i('Cancel') }}',
                }).then((result) => {
                    if (result.value) {
                        $.get('{{ url('admin/categories') }}/' + index + '/delete')
                            .then((data) => {
                                if (data.status != "failed") {
                                    $("#well_" + index).remove();
                                    swal.fire('{{ _i('Alert') }}', '{{ _i('Deleted Successfully') }}',
                                        "info");
                                } else {
                                    Swal.fire({
                                        title: '',
                                        text: "{{ _i('This section cannot be deleted because there are products in it. Delete it first') }}",
                                        type: 'warning',
                                    });
                                }
                            });
                    }
                });
            } else {
                $("#well_" + index).remove();
            }
        }

        function saveAllCat() {
            $('.save-category').attr('disabled', true);
            var result = $("#frm_master").parsley().validate();
            if (result) {
                var url = "{{ url('admin/categories/update') }}";
                $.ajax({
                    url: url,
                    method: "post",
                    data: new FormData($('#frm_master')[0]),
                    dataType: 'json',
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        if (response.errors) {
                            $('#masages_model').empty();
                            $.each(response.errors, function(index, value) {
                                $('#masages_model').show();
                                $('#masages_model').append(value + "<br>");
                            });
                        }
                        if (response == 'success') {
                            $('.save-category').attr('disabled', false);
                            Swal.fire({
                                icon: 'success',
                                title: "{{ _i('Saved Successfully') }}",
                                showConfirmButton: false,
                                timer: 5000
                            }).then(function() {});
                        }
                    },
                });
                return false;
                var datacat = $("#frm_master").serialize();
                console.log(datacat);
                $.post('{{ url('admin/categories/update') }}', datacat).then((data) => {
                    $('#category').modal('toggle');
                    $('#category').removeClass('show');
                    // location.reload();
                });
                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: "{{ _i('Saved Successfully') }}",
                    showConfirmButton: false,
                    timer: 5000
                }).then(function() {});
                return;
            }
            Swal.fire({
                title: '{{ _i('Alert') }}',
                text: "{{ _i('Please complete missing data') }}",
                icon: 'warning',
            });
            window.reload();
        }

        function subdel(obj, i) {
            if ($(obj).data("del") == "1") {
                $.get('{{ url('admin/categories') }}/' + i + '/delete').then((data) => {
                    swal.fire("{{ _i('alert') }}", '{{ _i('Deleted Successfully') }}', "info");
                    $(obj.closest(".child")).remove();
                    console.log(data['cat_ids']);
                    for (let i = 0; i <= data['cat_ids'].length; i++) {
                        $('div[data-fordelete="' + data['cat_ids'][i] + '"]').remove();
                    }
                });
            } else {
                $(obj.closest(".child")).remove();
            }
        }

        $(document).on('change', '.file-upload', function() {
            var id = $(this).attr('id');
            var file = $('#' + id)[0].files[0].name;
            $(this).prev('label').text(file);
        });

        $('.file-upload.ajax-upload').change(function() {
            //on change event
            formdata = new FormData();
            if ($(this).prop('files').length > 0) {
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
                    success: function(result) {
                        Swal.fire({
                            title: '{{ _i('Alert') }}',
                            text: "{{ _i('Image updated successfully') }}",
                            icon: 'success',
                        });
                    }
                });
            }
        });

        function addCategoryV2(e, myObj) {
            e.preventDefault();
            let id = $(myObj).data('id');
            let loc = $(myObj).parents('.child:first');
            if (loc['length'] == 0) {
                // console.log("ddddddd");
                loc = $(myObj).parents('.parent:first');
            }
            // get biggest  sort in categories
            let biggest = 0;
            $('.my_sort').each(function() {
                let current = $(this).val();
                if (current > biggest) {
                    biggest = current;
                }
            });
            let current_store = parseInt(biggest) + 1;
            // console.log(loc.attr('class'));
            $(loc).append(`  <div class="form-group child" data-fordelete="0" >
									<div class="input-group mb-3 subCategory">
										<input type="text" class="form-control" data-category-id="" name="category" style="max-height: 40px;" required="" class="input border-danger">
										<label style="    overflow: hidden; max-height: 40px;
    " for="file-upload" class="custom-file-upload btn btn-default">
												<i class="ti-image"></i>
											</label>
											<input id="file-upload" name='sub_images' type="file" accept='image/*' class='file-upload'>
										<input type="hidden" class="c_sort my_sort" name="sort" value="` + current_store + `">
										<input type="hidden" class="parent_id" name="parent_id" value="` + id + `">
										<input type="hidden" class="type" name="type" value="new">

										<div class="input-group-append" id="child.id" style="width: inherit;">
											<button class="btn btn-default up" type="button" onclick="upV2()"><i class="ti-angle-up"></i></button>
											<button class="btn btn-default down" type="button" onclick="downV2()"><i class="ti-angle-down"></i></button>
											<button class="btn btn-danger delete" data-del='0' type="button" onclick="subdel(this , 0)"><i class="ti-close"></i></button>
											<button class="btn btn-primary btn-sm add-category-v2" onclick="addCategoryV2(event,this)">
												<i class="ti ti-plus"></i>
								</button>


								<button class="btn btn-info btn-sm save-category-v2" onclick="saveCategoryV2(event,this)">
									<i class="ti ti-save"></i>
								</button>
											</div>
									</div>
								</div>`);

        }

        function saveCategoryV2(e, myObj) {
            e.preventDefault();
            // alert("save") ;
            let container = $(myObj).parents('.child:first');
            let subCategoryDiv = $(myObj).parents('.subCategory:first');
            let parent_id = $(subCategoryDiv).find('input[name=parent_id]').val();
            let name = $(subCategoryDiv).find('input[name=category]').val();
            let number = $(subCategoryDiv).find('input[name=sort]').val();
            let type = $(subCategoryDiv).find('input[name=type]').val();
            let typeField = $(subCategoryDiv).find('input[name=type]');
            let lang_ex = $(subCategoryDiv).find('.lang_ex');
            console.log(lang_ex);
            let file = $(subCategoryDiv).find('input[name=sub_images]');
            let imageLabel = $(subCategoryDiv).find('.custom-file-upload');
            let image = $(file)[0].files[0];
            let token = '{{ csrf_token() }}';
            let form = new FormData();
            form.append('_token', token);
            form.append('name', name);
            form.append('parent_id', parent_id);
            form.append('type', type);

            form.append('file', image);
            form.append('number', number);
            $.ajax({
                url: "{{ route('create.category.v2') }}",
                data: form,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function(data) {
                    //  swal success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: "{{ _i('Saved Successfully') }}",
                        showConfirmButton: false,
                        timer: 5000
                    }).then(function() {});
                    // type value == category_id
                    typeField.val(data['category']['id']);
                    //  update image field
                    new_image = `<img src="` + "{{ asset('/') }}" + data['category']['image'] +
                        ` " alt="" class="category-image">`;
                    // $(new_image).insertBefore(file) ;
                    imageLabel.empty();
                    imageLabel.append(new_image);
                    console.log($(container).attr('data-fordelete'));
                    $(container).attr('data-fordelete', data['category']['id']);
                    lang_ex.each(function() {
                        $(this).attr('data-id', data['category']['id']);
                    });
                    location.reload();
                },
                error: function(xhr, textStatus, errorThrown) {
                    var errors = $.parseJSON(xhr.responseText);
                    var vals = '';
                    $.each(errors.errors, function(key, val) {
                        vals = vals + '' + val + '';
                    });
                    Swal.fire({
                        title: '{{ _i('Alert') }}',
                        text: vals,
                        icon: 'warning',
                    });

                }
            });


        }
    </script>

    <style>
        .input-group {
            display: flex
        }

        .up,
        .down,
        .delete {
            padding: 10px;
        }

    </style>
@endpush
