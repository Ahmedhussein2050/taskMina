<div class="modal fade edit_modal" id="editdetails" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{_i('edit Category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#couponDetailsEdit" class="nav-link active"
                                                data-toggle="tab">{{_i('Category Details')}}</a></li>
                        {{--                        <li class="nav-item"><a href="#couponIncludeEdit" class="nav-link productFeature"--}}
                        {{--                                                data-toggle="tab">{{_i('Included in Category')}}</a></li>--}}
                    </ul>
                    <form id="form_edit" class="j-forms" data-parsley-validate
                    '>
                    @csrf


                    <div class="tab-content">

                        <!------------- tap  coupon details ------------------>
                        <div class="tab-pane active" id="couponDetailsEdit">
                            <div class="content">
                                <div class="divider-text gap-top-45 gap-bottom-45">
                                    <span>{{ _i('Category\'s details') }}</span>
                                </div>
                                <br>
                                <div class="alert alert-danger" style="display:none"></div>
                                <div class="form-group row">
                                    <div class="col-sm-12 text-right">
                                        <div class="row">


                                            <hr>
                                            <div class="col-sm-12 text-center">
                                                <div class="row">


                                                </div>
                                            </div>

                                            <hr>

                                            <div class="col-sm-12">
                                                <div class="form-group row">
                                                    <div class="col-sm-12">
                                                        <div class="row">
                                                            <label
                                                                class="col-sm-2 col-form-label">{{ _i('cover') }}</label>
                                                            <div class="col-sm-10">
                                                                {{Form::file('cover',null,['class'=>'form-control','id'=>'cover','form' => 'form_edit','placeholder'=>_i('cover')])}}
                                                            </div>
                                                            @if ($errors->has('cover'))
                                                                <span class="text-danger invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('cover') }}</strong>
                                                        </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!------------- end tap coupon details ------------------>

                        <!------------- tap coupon include ------------------>
                    {{--                            <div class="tab-pane" id="couponIncludeEdit">--}}
                    {{--                                <div class="content">--}}
                    {{--                                    <div class="divider-text gap-top-45 gap-bottom-45">--}}
                    {{--                                        <span>{{ _i('Included in Offer') }}</span>--}}
                    {{--                                    </div>--}}
                    {{--                                    <br>--}}
                    {{--                                    <div class="alert alert-danger" style="display:none"></div>--}}
                    {{--                                    <div class="form-group row">--}}
                    {{--                                        <div class="col-sm-12 text-right">--}}
                    {{--                                            <div class="row">--}}

                    {{--                                                <div class="col-sm-12 text-center">--}}
                    {{--                                                    <div class="row">--}}
                    {{--                                                        <div class="col-sm-4">--}}
                    {{--                                                            <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                    {{--                                                                <label>--}}
                    {{--                                                                    <input type="radio" name="type" form="form_edit" class="main_category" value="main_category">--}}
                    {{--                                                                    <span class="cr float-left">--}}
                    {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                    {{--                                                                    </span>--}}
                    {{--                                                                    <span class="">{{ _i('Main Category') }}</span>--}}
                    {{--                                                                </label>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-sm-4">--}}
                    {{--                                                            <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                    {{--                                                                <label>--}}
                    {{--                                                                    <input type="radio" name="type" class="sub_category" form="form_edit" value="sub_category">--}}
                    {{--                                                                    <span class="cr float-left">--}}
                    {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                    {{--                                                                    </span>--}}
                    {{--                                                                    <span class="">{{ _i('Sub Category') }}</span>--}}
                    {{--                                                                </label>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}
                    {{--                                                        <div class="col-sm-4">--}}
                    {{--                                                            <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                    {{--                                                                <label>--}}
                    {{--                                                                    <input type="radio" name="type" class="brand" form="form_edit" value="brand">--}}
                    {{--                                                                    <span class="cr float-left">--}}
                    {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                    {{--                                                                    </span>--}}
                    {{--                                                                    <span class="">{{ _i('Brand') }}</span>--}}
                    {{--                                                                </label>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}

                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}





                    {{--                                                <hr>--}}



                    {{--                                                <div class="col-sm-12 sub_categories_filed" style="display: none">--}}
                    {{--                                                    <div class="form-group row">--}}
                    {{--                                                        <div class="col-sm-12">--}}
                    {{--                                                            <label class="col-sm-12 col-form-label">{{ _i('Included Categories') }} :</label>--}}
                    {{--                                                            <div class="row">--}}
                    {{--                                                                <select  title="{{_i('Select Category')}}" class="col-sm-12 selectpicker"  form="form_edit" id="sub_parent_id" name="sub_parent_id">--}}
                    {{--                                                                    @foreach($categories_of_sub_categories as $cat)--}}
                    {{--                                                                        <option value="{{$cat['id']}}">{{$cat['title']}}</option>--}}
                    {{--                                                                    @endforeach--}}
                    {{--                                                                </select>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}
                    {{--                                                <div class="col-sm-12 brand_categories_filed" style="display: none">--}}
                    {{--                                                    <div class="form-group row">--}}
                    {{--                                                        <div class="col-sm-12">--}}
                    {{--                                                            <label class="col-sm-12 col-form-label">{{ _i('Included Categories') }} :</label>--}}
                    {{--                                                            <div class="row">--}}
                    {{--                                                                <select  title="{{_i('Select Category')}}" class="col-sm-12 selectpicker"  form="form_edit" id="brand_parent_id" name="brand_parent_id">--}}
                    {{--                                                                    @foreach($categories_of_brands as $cat)--}}
                    {{--                                                                        <option value="{{$cat['id']}}">{{$cat['title']}}</option>--}}
                    {{--                                                                    @endforeach--}}
                    {{--                                                                </select>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}

                    {{--                                            --}}{{--                                            <!------- included products --------->--}}
                    {{--                                            --}}{{--                                            <div class="col-sm-12">--}}
                    {{--                                            --}}{{--                                                <div class="form-group row">--}}
                    {{--                                            --}}{{--                                                    <div class="col-sm-12">--}}
                    {{--                                            --}}{{--                                                        <label class="col-sm-12 col-form-label">{{ _i('Included Products') }} :</label>--}}
                    {{--                                            --}}{{--                                                        <div class="row">--}}
                    {{--                                            --}}{{--                                                            <select class="js-example-basic-multiple col-sm-12 selectpicker" multiple="multiple" name="type_product[]">--}}
                    {{--                                            --}}{{--                                                                <option value="all_product">{{_i('Select All')}}</option>--}}
                    {{--                                            --}}{{--                                                                @foreach($products as $product)--}}
                    {{--                                            --}}{{--                                                                    <option value="{{$product['prod_id']}}">{{$product['title']}}</option>--}}
                    {{--                                            --}}{{--                                                                @endforeach--}}
                    {{--                                            --}}{{--                                                            </select>--}}
                    {{--                                            --}}{{--                                                        </div>--}}
                    {{--                                            --}}{{--                                                    </div>--}}
                    {{--                                            --}}{{--                                                </div>--}}
                    {{--                                            --}}{{--                                            </div>--}}

                    {{--                                            <!------- included users group --------->--}}
                    {{--                                                <div class="col-sm-12">--}}
                    {{--                                                    <div class="form-group row">--}}
                    {{--                                                        <div class="col-sm-12">--}}
                    {{--                                                            <label class="col-sm-12 col-form-label">{{ _i('Content Type') }} :</label>--}}
                    {{--                                                            <div class="row">--}}
                    {{--                                                                <select title="{{_i('Content Type')}}"  form="form_edit" class="js-example-basic-multiple col-sm-12 selectpicker store_id" id="container_type" name="container_type">--}}

                    {{--                                                                        <option value="brands">{{_i('Brands')}}</option>--}}
                    {{--                                                                        <option value="sub_categories">{{_i('Sub Categories')}}</option>--}}
                    {{--                                                                        <option value="products">{{_i('Products')}}</option>--}}

                    {{--                                                                </select>--}}
                    {{--                                                            </div>--}}
                    {{--                                                        </div>--}}
                    {{--                                                    </div>--}}
                    {{--                                                </div>--}}

                    {{--                                            </div>--}}
                    {{--                                        </div>--}}
                    {{--                                    </div>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    <!------------- end tap coupon include ------------------>

                    </div>
                    </form>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form_edit"
                        class="btn btn-primary btn-outline-primary m-b-0 save">{{ _i('Save') }}</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('close')}}</button>
            </div>
        </div>
    </div>
</div>
<!---------- model for edit discount code end ---------------------->

<!---------- model for create offer---------------------->
<div class="modal fade modal_create" id="editdetailsz" role="dialog" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{_i('Add Category')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a href="#couponDetails" class="nav-link active"
                                                data-toggle="tab">{{_i('Category Details')}}</a></li>
                        {{--                        <li class="nav-item"><a href="#couponInclude" class="nav-link productFeature"--}}
                        {{--                                                data-toggle="tab">{{_i('Included in Category')}}</a></li>--}}
                    </ul>
                    <form id="form_create" class="j-forms" data-parsley-validate>
                        @csrf

                        <div class="tab-content">

                            <!------------- tap  coupon details ------------------>
                            <div class="tab-pane active" id="couponDetails">
                                <div class="content">
                                    <div class="divider-text gap-top-45 gap-bottom-45">
                                        <span>{{ _i('Category\'s details') }}</span>
                                    </div>
                                    <br>
                                    <div class="alert alert-danger" style="display:none"></div>
                                    <div class="form-group row">
                                        <div class="col-sm-12 text-right">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label">{{ _i('Level') }}</label>
                                                                <div class="col-sm-10 my-1">
                                                                    <select id="rev-stars" class="form-control" name="level">
                                                                        <option value="5" selected>5</option>
                                                                        @for($i = 4; $i >= 1; $i--)
                                                                            <option value="{{$i}}">{{$i}}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label">{{ _i('title') }}</label>
                                                                <div class="col-sm-10">
                                                                    {{Form::text('title',null,['class'=>'form-control','id'=>'title','form' => 'form_create','placeholder'=>_i('title')])}}
                                                                </div>
                                                                @if ($errors->has('title'))
                                                                    <span class="text-danger invalid-feedback"
                                                                          role="alert">
                                                            <strong>{{ $errors->first('title') }}</strong>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-sm-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="row">
                                                                <label
                                                                    class="col-sm-2 col-form-label">{{ _i('cover') }}</label>
                                                                <div class="col-sm-10">
                                                                    {{Form::file('cover',null,['class'=>'form-control','id'=>'cover','form' => 'form_create','placeholder'=>_i('cover')])}}
                                                                </div>
                                                                @if ($errors->has('cover'))
                                                                    <span class="text-danger invalid-feedback"
                                                                          role="alert">
                                                            <strong>{{ $errors->first('cover') }}</strong>
                                                        </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!------------- end tap coupon details ------------------>

                            <!------------- tap coupon include ------------------>
                        {{--                        <div class="tab-pane" id="couponInclude">--}}
                        {{--                            <div class="content">--}}
                        {{--                                <div class="divider-text gap-top-45 gap-bottom-45">--}}
                        {{--                                    <span>{{ _i('Included in Category') }}</span>--}}
                        {{--                                </div>--}}
                        {{--                                <br>--}}
                        {{--                                <div class="alert alert-danger" style="display:none"></div>--}}
                        {{--                                <div class="form-group row">--}}
                        {{--                                    <div class="col-sm-12 text-right">--}}
                        {{--                                        <div class="row">--}}







                        {{--                                            <div class="col-sm-12 text-center">--}}
                        {{--                                                <div class="row">--}}
                        {{--                                                    <div class="col-sm-4">--}}
                        {{--                                                        <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                        {{--                                                            <label>--}}
                        {{--                                                                <input type="radio" name="type" form="form_create" class="main_category" value="main_category">--}}
                        {{--                                                                <span class="cr float-left">--}}
                        {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                        {{--                                                                    </span>--}}
                        {{--                                                                <span class="">{{ _i('Main Category') }}</span>--}}
                        {{--                                                            </label>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                    <div class="col-sm-4">--}}
                        {{--                                                        <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                        {{--                                                            <label>--}}
                        {{--                                                                <input type="radio" name="type" class="sub_category" form="form_create" value="sub_category">--}}
                        {{--                                                                <span class="cr float-left">--}}
                        {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                        {{--                                                                    </span>--}}
                        {{--                                                                <span class="">{{ _i('Sub Category') }}</span>--}}
                        {{--                                                            </label>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                    <div class="col-sm-4">--}}
                        {{--                                                        <div class="checkbox-fade fade-in-primary" style="display: block !important;">--}}
                        {{--                                                            <label>--}}
                        {{--                                                                <input type="radio" name="type" class="brand" form="form_create" value="brand">--}}
                        {{--                                                                <span class="cr float-left">--}}
                        {{--                                                                        <i class="cr-icon icofont icofont-ui-check txt-primary"></i>--}}
                        {{--                                                                    </span>--}}
                        {{--                                                                <span class="">{{ _i('Brand') }}</span>--}}
                        {{--                                                            </label>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}

                        {{--                                                </div>--}}
                        {{--                                            </div>--}}





                        {{--                                            <hr>--}}




                        {{--                                            <div class="col-sm-12 text-center">--}}
                        {{--                                                <div class="row">--}}



                        {{--                                                </div>--}}
                        {{--                                            </div>--}}

                        {{--                                            <hr>--}}



                        {{--                                            <div class="col-sm-12 sub_categories_filed" style="display: none">--}}
                        {{--                                                <div class="form-group row">--}}
                        {{--                                                    <div class="col-sm-12">--}}
                        {{--                                                        <label class="col-sm-12 col-form-label">{{ _i('Included Categories') }} :</label>--}}
                        {{--                                                        <div class="row">--}}
                        {{--                                                            <select  title="{{_i('Select Category')}}" class="col-sm-12 selectpicker"  form="form_create" name="sub_parent_id">--}}
                        {{--                                                                @foreach($categories_of_sub_categories as $cat)--}}
                        {{--                                                                    <option value="{{$cat['id']}}">{{$cat['title']}}</option>--}}
                        {{--                                                                @endforeach--}}
                        {{--                                                            </select>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}
                        {{--                                            <div class="col-sm-12 brand_categories_filed" style="display: none">--}}
                        {{--                                                <div class="form-group row">--}}
                        {{--                                                    <div class="col-sm-12">--}}
                        {{--                                                        <label class="col-sm-12 col-form-label">{{ _i('Included Categories') }} :</label>--}}
                        {{--                                                        <div class="row">--}}
                        {{--                                                            <select  title="{{_i('Select Category')}}" class="col-sm-12 selectpicker"  form="form_create" name="brand_parent_id">--}}
                        {{--                                                                @foreach($categories_of_brands as $cat)--}}
                        {{--                                                                    <option value="{{$cat['id']}}">{{$cat['title']}}</option>--}}
                        {{--                                                                @endforeach--}}
                        {{--                                                            </select>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}

                        {{--                                            <!------- included products --------->--}}
                        {{--                                            <div class="col-sm-12">--}}
                        {{--                                                <div class="form-group row">--}}
                        {{--                                                    <div class="col-sm-12">--}}
                        {{--                                                        <label class="col-sm-12 col-form-label">{{ _i('Included Products') }} :</label>--}}
                        {{--                                                        <div class="row">--}}
                        {{--                                                            <select class="js-example-basic-multiple col-sm-12 selectpicker" multiple="multiple" name="type_product[]">--}}
                        {{--                                                                <option value="all_product">{{_i('Select All')}}</option>--}}
                        {{--                                                                @foreach($products as $product)--}}
                        {{--                                                                    <option value="{{$product['prod_id']}}">{{$product['title']}}</option>--}}
                        {{--                                                                @endforeach--}}
                        {{--                                                            </select>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}

                        {{--                                            <!------- included users group --------->--}}
                        {{--                                            <div class="col-sm-12">--}}
                        {{--                                                <div class="form-group row">--}}
                        {{--                                                    <div class="col-sm-12">--}}
                        {{--                                                        <label class="col-sm-12 col-form-label">{{ _i('Content Type') }} :</label>--}}
                        {{--                                                        <div class="row">--}}
                        {{--                                                            <select title="{{_i('Content Type')}}"  form="form_create" class="js-example-basic-multiple col-sm-12 selectpicker store_id"  name="container_type">--}}

                        {{--                                                                <option value="brands">{{_i('Brands')}}</option>--}}
                        {{--                                                                <option value="sub_categories">{{_i('Sub Categories')}}</option>--}}
                        {{--                                                                <option value="products">{{_i('Products')}}</option>--}}

                        {{--                                                            </select>--}}
                        {{--                                                        </div>--}}
                        {{--                                                    </div>--}}
                        {{--                                                </div>--}}
                        {{--                                            </div>--}}

                        {{--                                        </div>--}}
                        {{--                                    </div>--}}
                        {{--                                </div>--}}
                        {{--                            </div>--}}
                        {{--                        </div>--}}
                        <!------------- end tap coupon include ------------------>

                        </div>
                    </form>


                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" form="form_create"
                        class="btn btn-primary btn-outline-primary m-b-0 save_language">{{ _i('Save') }}</button>

                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('close')}}</button>
            </div>
        </div>
    </div>
</div>


