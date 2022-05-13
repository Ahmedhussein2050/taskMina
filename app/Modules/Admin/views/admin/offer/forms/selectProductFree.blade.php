<div class="main-body border show2" id="show-product2" style="display: none;">
    <div class="row">

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

            {{--<div class="form-group row">--}}
                {{--<label for="title"> {{ _i('Minimum') }} </label>--}}
                {{--<div class="">--}}
                    {{--<input type="number" class="min min2 form-control" name="num" min="0">--}}
                {{--</div>--}}
            {{--</div>--}}
            {{--<div class="form-group row">--}}
                {{--<label for="title"> {{ _i('Maximum') }} </label>--}}
                {{--<div class="">--}}
                    {{--<input type="number" name="num" class="max max2 form-control" max="100">--}}
                {{--</div>--}}
            {{--</div>--}}
			{{--<div class="form-group row">--}}
                {{--<label for="title"> {{ _i('Min Commission') }} </label>--}}
                {{--<div class="">--}}
                    {{--<input type="number" name="num" class="minc minc2 form-control" min="0">--}}
                {{--</div>--}}
            {{--</div>--}}
			{{--<div class="form-group row">--}}
                {{--<label for="title"> {{ _i('Max Commission') }} </label>--}}
                {{--<div class="">--}}
                    {{--<input type="number" name="num" class="maxc maxc2 form-control"  >--}}
                {{--</div>--}}
            {{--</div>--}}
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
		<div class="col-md-9 col-lg-9 mt-3" id="appendproductFree">
        </div>
        <!-- end left column -->
        <!-- Start right column -->

        <!-- end right column -->
    </div>


</div>
