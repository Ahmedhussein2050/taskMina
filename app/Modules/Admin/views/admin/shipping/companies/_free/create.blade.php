@extends('admin.layout.index',
[
	'title' => _i('Shipping'),
	'subtitle' => _i('Shipping'),
	'activePageName' => _i('Shipping'),
	'activePageUrl' => route('shipping.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index')
])
@push('css')
<style>
    .modal-header {
    background-color: #5cd5c4;
    border-color: #5cd5c4;
    color: #fff;
    }
</style>
@endpush
@section('content')
<div class="page-body">
    @if(isset($shipping_options) && count($shipping_options) > 0)
    <form class="save_shipping_company" method="POST" action="{{url('admin/save_shipping_company')}}" data-parsley-validate="">
        @csrf
        <input type="hidden" name="free_shipping" value="1">
        <div class="row">
            <div class="col-sm-4 ">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="free_company_description" placeholder="{{_i('Company description')}}">{{$shipping_company->description}}</textarea>
                            </div>
                        </div>
                        <div class="form-group row  col-sm-12">
                            <div class="input-group ">
                                <label class="col-sm-4 ">{{_i('Active')}}</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" class="js-switch "  value="1"  name="is_active"
                                    @if($shipping_company->is_active == 1) checked @endif />
                                </div>
                            </div>
                        </div>
						<div class="form-group row  col-sm-12">
							<select class="form-control" name="shipping_type">
								<option  disabled>{{_i('Select shipping type')}}</option>
								<option value="Free" @if($shipping_company['shipping_type']=="Free") selected @endif>{{_i('Free')}}</option>
								<option value="Aramex" @if($shipping_company['shipping_type']=="Aramex") selected @endif>{{_i('Aramex')}}</option>
								<option value="DHL" @if($shipping_company['shipping_type']=="DHL") selected @endif>{{_i('DHL')}}</option>
							</select>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 ">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <label style="color: #58c0e9;">{{_i('You can select the city or country that supports free shipping for it if purchases exceed the minimum you specify')}}</label>
                            </div>
                        </div>
                        @foreach($shipping_options as $single_option)
                        <div class="section_condition_add">
                            <div class="single_section_condition">
                                <div class="form-group row ">
                                    <div class="col-sm-12">
                                        <div class="input-group ">
                                            <select class="form-control country_id" name="country_id[]" onchange="get_cities(this)" required="">
                                            <option  value="all" {{$single_option['country_id'] == "null" ? "selected": ""}}>{{_i('All Countries')}}</option>
                                            @foreach($countries as $country)
                                            <option value="{{$country->id}}" {{$country->id==$single_option['country_id'] ? "selected": ""}} >{{$country->title}}</option>
                                            @endforeach
                                            </select>
                                            <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                            <i class="ti ti-map"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------- cities--------------------->
                                <div class="form-group row ">
                                    <div class="col-sm-12">
                                        <div class="input-group ">
                                            <select class="form-control js-example-basic-multiple city_id" multiple="multiple"  @if($single_option['country_id'] != null) name="city_id[{{$single_option['country_id']}}][]" @else name="city_id[all][]" @endif  required="" >
                                            @php
                                            $option_city =\App\Models\Shipping\Cities_shipping_option::where('shipping_option_id',$single_option['id'])->get();
                                            @endphp
                                            <option  value="all" {{$single_option['country_id']  == null ? "selected":""}}>{{_i('All Cities')}}</option>
                                            @foreach($cities as $city)
                                            <option value="{{$city->id}}"
                                            @foreach($option_city as $row) @if($single_option['country_id'] != null) {{$city->id == $row->city_id ? "selected":""}} @endif @endforeach
                                            >{{$city->title}}</option>
                                            @endforeach
                                            </select>
                                            <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                            <i class="ti ti-map-alt"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------- Minimum purchases --------------------->
                                <div class="form-group row ">
                                    <div class="col-sm-12">
                                        <div class="input-group ">
                                            <input class="form-control " name="minimum_purchases[]" value="{{$single_option['minimum_purchases']}}" placeholder="{{_i('Minimum purchases')}}" required="">
                                            <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                            <i class="ti ti-money"></i>
                                            </span>
                                            <button type="button" class="btn btn-tiffany btn-sm mr-3 ">{{ get_default_currency()->code }}</button>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------------- delete condition --------------------->
                                {{--                                <input type="hidden" name="shipping_option_id" value="{{$single_option['id']}}">--}}
                                <div class="form-group row ">
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-danger " onclick="delete_saved_section_condition(this , {{$single_option['id']}})"  >
                                        <i class="fa fa-times"></i> {{_i('Delete Condition')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary add_condition col-sm-12" ><i class="fa fa-plus"></i> {{_i('Add Condition')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @else
    <form class="save_shipping_company" method="POST" action="{{url('admin/save_shipping_company')}}" data-parsley-validate="">
        @csrf
        <input type="hidden" name="free_shipping" value="1">
        <div class="row">
            <div class="col-sm-4 ">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <textarea class="form-control" name="free_company_description" placeholder="{{_i('Company description')}}">@if($shipping_company != null){{$shipping_company->description}}@endif</textarea>
                            </div>
                        </div>
                        <div class="form-group row  col-sm-12">
                            <div class="input-group ">
                                <label class="col-sm-4 ">{{_i('Active')}}</label>
                                <div class="col-sm-2">
                                    <input type="checkbox" class="js-switch" value="1" name="is_active" @if($shipping_company != null) @if($shipping_company->is_active == 1) checked @endif @endif />
                                </div>
                            </div>
                        </div>
						<div class="form-group row  col-sm-12">
							<select class="form-control" name="shipping_type">
								<option  disabled>{{_i('Select shipping type')}}</option>
								<option value="Free" @if($shipping_company['shipping_type']=="Free") selected @endif>{{_i('Free')}}</option>
								<option value="Aramex" @if($shipping_company['shipping_type']=="Aramex") selected @endif>{{_i('Aramex')}}</option>
								<option value="DHL" @if($shipping_company['shipping_type']=="DHL") selected @endif>{{_i('DHL')}}</option>
							</select>
						</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-8 ">
                <div class="card">
                    <div class="card-block">
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <label style="color: #58c0e9;">{{_i('You can select the city or country that supports free shipping for it if purchases exceed the minimum you specify')}}</label>
                            </div>
                        </div>
                        <div class="section_condition_add">
                        </div>
                        <div class="form-group row ">
                            <div class="col-sm-12">
                                <button type="button" class="btn btn-primary add_condition col-sm-12" ><i class="fa fa-plus"></i> {{_i('Add Condition')}}</button>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary save ">{{_i('Save')}}</button>
                        <button type="button" class="btn btn-default" data-dismiss="modal">{{_i('Close')}}</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
@include('admin.shipping.companies.free.add_condition')
@endsection
