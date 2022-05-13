
<div class="main-body border" id="show-products"  @if(count($Offer_products) > 0) style="display: block;" @else style="display: none;" @endif >
	<div class="row" >
		<!-- Start right column -->
		<div class="col-md-3 col-lg-3 append bg-gray-light" id="applyProduct">

			<label for="title"> {{ _i('Price :') }} </label>
			<div class="input-group">
				<span class="input-group-addon">{{_i("Min")}}</span>
				<input type="number" class="min form-control" name="num" min="0" placeholder="Min" />
				<span class="input-group-addon" style="border-left: 0; border-right: 0;">{{_i("Max")}}</span>
				<input type="number" name="num" class="max form-control"  placeholder="Max" />
			</div>

			<label for="title"> {{ _i('Commission :') }} </label>
			<div class="input-group">
				<span class="input-group-addon">Min</span>
				<input type="number" name="num" class="minc  form-control" min="0" placeholder="Min" />
				<span class="input-group-addon" style="border-left: 0; border-right: 0;">Max</span>
				<input type="number" name="num" class="maxc  form-control" placeholder="Max" />
			</div>

			<div class="mb-3">

				<button type="button" class="btn btn-warning btn-block" id="getData">{{_i("Filter")}}</button>

			</div>

				<div class="tree-view">
					<div id="checkTree">
						<ul>
							{!! $html !!}
						</ul>
					</div>
				</div>



		</div>
		<!-- end right column -->
		<!-- Start left column -->
		<div class="col-md-9 col-lg-9" id="appendproducts">
				@include('admin.offer.edit.editSelectProduct')
		</div>
		<!-- end left column -->

	</div>
</div>

@push('js')
    <!-- classie js -->
    <script type="text/javascript" src="{{asset('admin_dashboard/bower_components/classie/js/classie.js')}}"></script>
    <!-- Tree view js -->
    <script type="text/javascript" src="{{asset('admin_dashboard/bower_components/jstree/js/jstree.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('admin_dashboard/assets/pages/treeview/jquery.tree.js')}}"></script>
    <script>

        $('body').on('click', '#getData', function(e) {
            var iditem = $(this).closest(".append").attr("id");
            var iditem2 = $(this).closest(".append2").attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
                }
            });
            e.preventDefault();
            if (iditem =='applyProduct') {
                var ids = new Array();
                var item = $(this).closest("#checkTree").find('.jstree-clicked');
                $.each(item, function () {
                    ids.push($(this).closest("li").attr('data-id'));

                });

                var min = $(this).closest("#applyProduct").find('.min').val()
                var max = $(this).closest("#applyProduct").find('.max').val()
                var maxc = $(this).closest("#applyProduct").find('.maxc').val()
                var minc = $(this).closest("#applyProduct").find('.minc').val()
                var ProductOffer = 'ProductOffer'
            }
            if (iditem2 =='freeProduct'){

                var ids = new Array();
                var item = $(this).closest("#checkTree2").find('.jstree-clicked');
                $.each(item, function() {
                    ids.push($(this).closest("li").attr('data-id'));

                });

                var min = $(this).closest("#freeProduct").find('.min').val()
                var max = $(this).closest("#freeProduct").find('.max').val()
                var maxc = $(this).closest("#freeProduct").find('.maxc').val()
                var minc = $(this).closest("#freeProduct").find('.minc').val()
                var ProductOffer = 'ProductFree'
            }
            var url = "{{url('admin/offers/productAjax')}}";
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {
                    ids: ids,
                    min: min,
                    max: max,
                    maxc: maxc,
                    minc: minc,
                    ProductOffer:ProductOffer
                },
                success: function (data) {

                    if (iditem =='applyProduct') {
                        $("#appendproducts").html(data);
                    }else if (iditem2 =='freeProduct'){
                        $("#appendproductFree").html(data);
                    }

                }
            });
        });


        $('body').on('click', '.jstree-anchor', function(e) {
            var iditem = $(this).closest("#checkTree").attr("id");
            var iditem2 = $(this).closest("#checkTree2").attr("id");
            $.ajaxSetup({
                headers: {
                    'X-CSRF-Token': $('meta[name="csrf_token"]').attr('content')
                }
            });
            e.preventDefault();
            if (iditem =='checkTree') {

                var ids = new Array();
                var item = $(this).closest("#checkTree").find('.jstree-clicked');
                $.each( item, function() {
                    ids.push($(this).closest("li").attr('data-id'));

                });

                var min = $('.min').val()
                var max = $('.max').val()
                var maxc= $('.maxc').val()
                var minc = $('.minc').val()
                var ProductOffer = 'ProductOffer'
            }
            if(iditem2 =='checkTree2')
            {
                var ids = new Array();
                var item = $(this).closest("#checkTree2").find('.jstree-clicked');
                $.each( item, function() {
                    ids.push($(this).closest("li").attr('data-id'));

                });

                var min = $('.min2').val()
                var max = $('.max2').val()
                var maxc = $('.maxc2').val()
                var minc = $('.minc2').val()
                var ProductOffer = 'ProductFree'
            }
            var url = "{{url('admin/offers/productAjax')}}";
            $.ajax({
                url: url,
                type: 'get',
                dataType: 'json',
                data: {
                    ids: ids,
                    min: min,
                    max: max,
                    maxc: maxc,
                    minc: minc,
                    ProductOffer:ProductOffer
                },
                success: function (data) {

                    if (iditem =='checkTree') {
                        $("#appendproducts").html(data);
                    }else if (iditem2 =='checkTree2'){
                        $("#appendproductFree").html(data);
                    }

                }
            });
        });


        $('body').on('click', '.btn-delete[data-url]', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var id = $(this).data('id');
            var type = $(this).data('type');

            if (type =='ProductOffer') {
                $(".data_" + id).remove();
            }else {
                $(".dataFree_" + id).remove();
            }

        });


    </script>

    @endpush
