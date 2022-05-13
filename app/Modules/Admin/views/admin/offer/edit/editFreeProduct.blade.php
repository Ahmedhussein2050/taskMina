
<div class="main-body border" id="show-product2" @if(count($Offer_Free_product) > 0) style="display: block;" @else style="display: none;" @endif>
    <div class="row" >
		<div class="col-md-3 col-lg-3 append2 bg-light-blue" id="freeProduct">

			<label for="title"> {{ _i('Price :') }} </label>
			<div class="input-group">
				<span class="input-group-addon">{{_i("Min")}}</span>
				<input type="number" class="min min2 form-control" name="num" min="0" placeholder="Min" />
				<span class="input-group-addon" style="border-left: 0; border-right: 0;">{{_i("Max")}}</span>
				<input type="number" name="num" class="max max2 form-control"  placeholder="Max" />
			</div>


			<label for="title"> {{ _i('Commission :') }} </label>
			<div class="input-group">
				<span class="input-group-addon">{{_i("Min")}}</span>
				<input type="number" name="num" class="minc minc2 form-control" min="0" placeholder="Min" />
				<span class="input-group-addon" style="border-left: 0; border-right: 0;">{{_i("Max")}}</span>
				<input type="number" name="num" class="maxc maxc2 form-control" placeholder="Max" />
			</div>


			<div class="mb-3">

				<button type="button" class="btn btn-warning btn-block" id="getData">{{_i("Filter")}}</button>

			</div>


			<div class="tree-view">
				<div id="checkTree2">
					<ul>
						{!! $html !!}
					</ul>
				</div>
			</div>



		</div>
		<!-- Start left column -->
		<div class="col-md-9 col-lg-9 mt-3" id="appendproductFree">
			@include('admin.offer.edit.editSelectFreeProduct')

		</div>
		<!-- end left column -->
		<!-- Start right column -->

		<!-- end right column -->
	</div>
</div>


