@extends('admin.layout.index',[
	'title' => _i('Home'),
	'activePageName' => _i('Home'),
	'activePageUrl' => '',
])

@push('css')
    <style>
        .card-block ul li:hover a {
            font-weight: bold;
            width: 100%;
        }
        .card-block ul li a{
            /* font-size: 30px; */
        }
    </style>
@endpush
@section('content')
    <section class="content">

        <div class="row">
            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks primary-border">
                    <div class="card-block">
                        <a href="{{url('admin/')}}"><h5>{{_i('Users')}}</h5></a>
                        <ul>
                            <li style="float: left; color: #8CDDCD; ">
                                <i class="icofont icofont-ui-user-group "></i>
                            </li>
                            <li class="text-right ">
                                <a  href="{{url('admin/')}}" style="color: #8CDDCD;" >{{$users}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks warning-border">
                    <div class="card-block">
                        <a href="{{url('admin/admin')}}"><h5>{{_i('Admins')}}</h5></a>
                        <ul>
                            <li style="float: left">
                                <i class="icofont icofont-ui-user-group text-warning"></i>
                            </li>
                            <li class="text-right text-warning">
                                <a class="text-warning" href="{{url('admin/admin')}}" >{{$admins}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-xl-3">
                <div class="card client-blocks warning-border">
                    <div class="card-block">
                        <a href="{{url('admin/')}}"><h5>{{_i('Contacts')}}</h5></a>
                        <ul>
                            <li style="float: left">
                                <i class="icofont icofont-envelope-open text-warning"></i>
                            </li>
                            <li class="text-right">
                                <a class="text-warning" href="{{url('admin/')}}" >{{$contacts}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>

    </section>
{{--    <section class="content">--}}

{{--		<div class="row">--}}
{{--			<div class="col-md-6 col-xl-3">--}}
{{--				<div class="card client-blocks">--}}
{{--					<div class="card-block">--}}
{{--						<h5><a href="javascript:void(0)" class="groups reload-datatable" data-type="all" data-id='all'>{{ _i('All Sales Amount') }}</a>--}}
{{--						</h5>--}}
{{--						<ul>--}}
{{--							<li class="text-center text-primary">--}}
{{--								{{$total}}--}}
{{--							</li>--}}
{{--						</ul>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}

{{--			<div class="col-md-6 col-xl-3">--}}
{{--				<div class="card client-blocks">--}}
{{--					<div class="card-block">--}}
{{--						<h5><a href="javascript:void(0)" class="groups reload-datatable" data-type="all" data-id='all'>{{ _i('All Products Cost') }}</a>--}}
{{--						</h5>--}}
{{--						<ul>--}}
{{--							<li class="text-right text-primary">--}}
{{--								{{$products}}--}}
{{--							</li>--}}
{{--						</ul>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}


{{--		<!--- start datatable -->--}}
{{--		<div class="row">--}}


{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Store Statistics') }}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $store_statistics_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}

{{--						<h5>{{ _i('Orders Chart') }}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}


{{--						<div>{!! $orders_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Abandoned carts chart') }} </h5>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $abandoned_carts_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Profit chart') }}</h5>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $profit_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Visits chart') }}</h5>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $store_visits_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Shipping fee chart') }}</h5>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $shipping_fee_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<div class="col-md-12 col-lg-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{ _i('Tax amounts') }}</h5>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div>{!! $tax_amount_chart->container() !!}</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--		</div>--}}
{{--		<div class="row">--}}
{{--			<!--- sales datatable -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Sales Lifetime')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('From')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-datatable" type="date" id="date_from" name="date_from">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('To')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-datatable" type="date" id="date_to" name="date_to">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="sales_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Day')}}</th>--}}
{{--									<th> {{_i('Products count')}}</th>--}}
{{--									<th> {{_i('Sales total')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end sales datatable ----->--}}

{{--			<!--- orders datatable -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Last Orders')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('From')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-orders-datatable" type="date" id="order_date_from" name="order_date_from">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('To')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-orders-datatable" type="date" id="order_date_to" name="order_date_to">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="orders_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Order.No')}}</th>--}}
{{--									<th> {{_i('Products count')}}</th>--}}
{{--									<th> {{_i('Total')}}</th>--}}
{{--									<th> {{_i('Status')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end orders datatable ----->--}}
{{--		</div>--}}

{{--		<!--- start searches datatable -->--}}
{{--		<div class="row">--}}
{{--			<!--- most search words datatable -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Most words searched')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="most_words_searched_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Word search')}}</th>--}}
{{--									<th> {{_i('No.times searched')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end most search words datatable ----->--}}

{{--			<!--- last search words datatable -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Latest words searched')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="last_words_searched_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Word search')}}</th>--}}
{{--									<th> {{_i('Client name')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end last search words datatable ----->--}}
{{--		</div>--}}
{{--		<!---- end searches datatable ----->--}}

{{--		<!---- products reports ----->--}}
{{--		<div class="row">--}}
{{--			<!--- start sold products -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Report of products sold')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('From')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-sold-products-datatable" type="date" id="sold_products_date_from" name="order_date_from">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('To')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-sold-products-datatable" type="date" id="sold_products_date_to" name="order_date_to">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="sold_products_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('No.products')}}</th>--}}
{{--									<th> {{_i('Total price')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end sold products datatable ----->--}}
{{--			<!--- start Best selling products -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Report of Best selling products')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('From')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-best-products-datatable" type="date" id="best_products_date_from" name="order_date_from">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('To')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-best-products-datatable" type="date" id="best_products_date_to" name="order_date_to">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="best_products_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th style="max-width: 30px;"> {{_i('Product')}}</th>--}}
{{--									<th> {{_i('No.orders')}}</th>--}}
{{--									<th> {{_i('Total pieces')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end Best selling products ----->--}}
{{--		</div>--}}

{{--		<div class="row">--}}
{{--			<!--- start total orders -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Report of total orders')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('Country')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<select class="form-control reload-total-orders-datatable" id="country_id">--}}
{{--									<option selected disabled>{{_i('Select Country')}}</option>--}}
{{--									@foreach($countries as $country)--}}
{{--									<option value="{{$country->country_id}}">{{$country->title}}</option>--}}
{{--									@endforeach--}}
{{--								</select>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-4 ">{{_i('City')}} </label>--}}
{{--							<div class="col-md-8">--}}
{{--								<select class="form-control reload-total-orders-datatable" id="city_id">--}}
{{--									<option selected disabled>{{_i('Select Country')}}</option>--}}
{{--								</select>--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="total_orders_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Orders total')}}</th>--}}
{{--									<th> {{_i('Cost total')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end total orders ----->--}}

{{--			<!--- start orders filter by status datatable -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('All Orders')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="form-group row"></div>--}}
{{--					<div class="form-group row">--}}
{{--						<label class=" col-md-1 col-form-label "></label>--}}
{{--						<label class=" col-md-2 col-form-label ">{{_i('Status')}} </label>--}}
{{--						<div class="col-md-8">--}}
{{--							<select  class="form-control " id="order_filter_status">--}}
{{--								<option disabled selected>{{_i('Select Status')}}</option>--}}
{{--								<option value="complete">{{_i('Complete')}}</option>--}}
{{--								<option value="wait">{{_i('Wait')}}</option>--}}
{{--								<option value="refused">{{_i('Refused')}}</option>--}}
{{--								<option value="accepted">{{_i('Accepted')}}</option>--}}
{{--								<option value="shipped">{{_i('Shipped')}}</option>--}}
{{--							</select>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="orders_filter_by_status_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Order.No')}}</th>--}}
{{--									<th> {{_i('Products Count')}}</th>--}}
{{--									<th> {{_i('Total')}}</th>--}}
{{--									<th> {{_i('Status')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end orders filter by status datatable ----->--}}
{{--		</div>--}}

{{--		<div class="row">--}}
{{--			<!--- start Most viewed products -->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('Most viewed products')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="form-group row">--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('From')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-most-viewed-products-datatable" type="date" id="most_viewed_products_date_from" name="order_date_from">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--						<div class="col-md-6">--}}
{{--							<label class=" col-md-3 ">{{_i('To')}} </label>--}}
{{--							<div class="col-md-9">--}}
{{--								<input class="form-control reload-most-viewed-products-datatable" type="date" id="most_viewed_products_date_to" name="order_date_to">--}}
{{--							</div>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="most_viewed_products_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}
{{--									<th> {{_i('ID')}}</th>--}}
{{--									<th> {{_i('Prodcuct Name')}}</th>--}}
{{--									<th> {{_i('Views')}}</th>--}}
{{--									<th> {{_i('Date')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end Most viewed products datatable ----->--}}

{{--			<!---- start average sales amount datatable ----->--}}
{{--			<div class="col-md-6">--}}
{{--				<div class="card">--}}
{{--					<div class="card-header">--}}
{{--						<h5>{{_i('admin average sales')}}</h5>--}}
{{--						<div class="card-header-right">--}}
{{--							<i class="icofont icofont-rounded-down"></i>--}}
{{--							<i class="icofont icofont-refresh"></i>--}}
{{--							<i class="icofont icofont-close-circled"></i>--}}
{{--						</div>--}}
{{--					</div>--}}

{{--					<div class="card-block">--}}
{{--						<div class="dt-responsive table-responsive text-center">--}}
{{--							<table id="average_purchases_table" class="table table-bordered table-striped dataTable">--}}
{{--								<thead>--}}
{{--								<tr role="row">--}}

{{--									<th> {{_i('Username')}}</th>--}}
{{--									<th> {{_i('Total_Purchases_amount')}}</th>--}}
{{--									<th> {{_i('Sales_count')}}</th>--}}
{{--									<th> {{_i('Average_Purchases_amount')}}</th>--}}
{{--								</tr>--}}
{{--								</thead>--}}
{{--							</table>--}}
{{--						</div>--}}
{{--					</div>--}}
{{--				</div>--}}
{{--			</div>--}}
{{--			<!---- end average sales amount datatable ----->--}}

{{--		</div>--}}

{{--    </section>--}}
@endsection

{{--@push('js')--}}
{{--	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>--}}
{{--	{!! $abandoned_carts_chart->script() !!}--}}
{{--	{!! $profit_chart->script() !!}--}}
{{--	{!! $store_visits_chart->script() !!}--}}
{{--	{!! $shipping_fee_chart->script() !!}--}}
{{--	{!! $tax_amount_chart->script() !!}--}}
{{--	{!! $store_statistics_chart->script() !!}--}}
{{--	{!! $orders_chart->script() !!}--}}

{{--	<script type="text/javascript">--}}
{{--		$(document).ready(function() {--}}
{{--			//sales lifetime--}}
{{--			table =  $('#sales_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.salesSearch')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'day'},--}}
{{--					{data: 'products_count'},--}}
{{--					{data: 'sales_total'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('.reload-datatable').change(function(){--}}
{{--				var from = $('#date_from').val();--}}
{{--				var to = $('#date_to').val();--}}
{{--				table.ajax.url( '{{ route('admin.salesSearch') }}?date_from=' + from + '&date_to=' + to ).load();--}}
{{--			});--}}

{{--			//Most words searched datatble--}}
{{--			table_serch = $('#most_words_searched_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.wordsSearch')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'word'},--}}
{{--					{data: 'words_total'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			//Most words searched datatble--}}
{{--			$('#last_words_searched_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.wordsSearch')}}",--}}
{{--					data: {--}}
{{--						"type": "last_words_search"--}}
{{--					}--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'word'},--}}
{{--					{data: 'user'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}

{{--			//last orders--}}
{{--			orders_table =  $('#orders_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.lastOrders')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'ordernumber'},--}}
{{--					{data: 'products_count'},--}}
{{--					{data: 'total'},--}}
{{--					{data: 'status'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('.reload-orders-datatable').change(function(){--}}
{{--				var from = $('#order_date_from').val();--}}
{{--				var to = $('#order_date_to').val();--}}
{{--				orders_table.ajax.url( '{{ route('admin.lastOrders') }}?order_date_from=' + from + '&order_date_to=' + to ).load();--}}
{{--			});--}}

{{--			// sold products--}}
{{--			sold_products_table =  $('#sold_products_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.soldProducts')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'products_count'},--}}
{{--					{data: 'price_total'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('.reload-sold-products-datatable').change(function(){--}}
{{--				var from = $('#sold_products_date_from').val();--}}
{{--				var to = $('#sold_products_date_to').val();--}}
{{--				sold_products_table.ajax.url( '{{ route('admin.soldProducts') }}?order_date_from=' + from + '&order_date_to=' + to ).load();--}}
{{--			});--}}

{{--			// best seling products--}}
{{--			best_products_table =  $('#best_products_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.bestSellingProducts')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'product_name'},--}}
{{--					{data: 'products_count'},--}}
{{--					{data: 'total_pieces'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('.reload-best-products-datatable').change(function(){--}}
{{--				var from = $('#best_products_date_from').val();--}}
{{--				var to = $('#best_products_date_to').val();--}}
{{--				best_products_table.ajax.url( '{{ route('admin.bestSellingProducts') }}?order_date_from=' + from + '&order_date_to=' + to ).load();--}}
{{--			});--}}

{{--			// total orders total_orders_table--}}
{{--			total_orders_table =  $('#total_orders_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.totalOrders')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'orders_total'},--}}
{{--					{data: 'cost_total'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('#country_id').change(function(){--}}
{{--				var countryId = $('#country_id').val();--}}
{{--				if(countryId != null){--}}
{{--					$.ajax({--}}
{{--						url: '{{ route('admin.get_cities') }}',--}}
{{--						method: "get",--}}
{{--						data: {--}}
{{--							country_id: countryId,--}}
{{--						},--}}
{{--						success: function (response) {--}}
{{--							$('#city_id').empty();--}}
{{--							var html = '';--}}
{{--							$('#city_id').append('<option selected disabled>{{_i('Select City')}}</option>');--}}
{{--							$.each(response , function (key , row) {--}}
{{--								html += '<option  value=" '+row.id+' ">'+row.title+'</option>';--}}
{{--							});--}}
{{--							//$(".js-example-basic-multiple").select2();--}}
{{--							$('#city_id').append(html);--}}

{{--						}--}}
{{--					});--}}
{{--				}--}}
{{--				var cityId = $('#city_id').val();--}}
{{--				total_orders_table.ajax.url( '{{ route('admin.totalOrders') }}?country_id=' + countryId + '&city_id=' + cityId ).load();--}}
{{--			});--}}
{{--			$('#city_id').change(function(){--}}
{{--				var countryId = $('#country_id').val();--}}
{{--				var cityId = $('#city_id').val();--}}
{{--				total_orders_table.ajax.url( '{{ route('admin.totalOrders') }}?country_id=' + countryId + '&city_id=' + cityId ).load();--}}
{{--			});--}}

{{--			//filter orders by status--}}
{{--			orders_filter_status_table =  $('#orders_filter_by_status_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.ordersFilterByStatus')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'ordernumber'},--}}
{{--					{data: 'products_count'},--}}
{{--					{data: 'total'},--}}
{{--					{data: 'status'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('#order_filter_status').change(function(){--}}
{{--				var status = $('#order_filter_status').val();--}}
{{--				var to = $('#order_date_to').val();--}}
{{--				orders_filter_status_table.ajax.url( '{{ route('admin.ordersFilterByStatus') }}?status=' + status ).load();--}}
{{--			});--}}


{{--			//Most Viewed Products--}}
{{--			most_viewed_products_table =  $('#most_viewed_products_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.mostViewedProducts')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}
{{--					{data: 'id'},--}}
{{--					{data: 'product_name'},--}}
{{--					{data: 'product_visits'},--}}
{{--					{data: 'day'},--}}
{{--				],--}}
{{--			});--}}
{{--			$('.reload-most-viewed-products-datatable').change(function(){--}}
{{--				var from = $('#most_viewed_products_date_from').val();--}}
{{--				var to = $('#most_viewed_products_date_to').val();--}}
{{--				most_viewed_products_table.ajax.url( '{{ route('admin.mostViewedProducts') }}?view_date_from=' + from + '&view_date_to=' + to ).load();--}}
{{--			});--}}

{{--			$table_average = $('#average_purchases_table').DataTable({--}}
{{--				ajax: {--}}
{{--					url: "{{route('admin.avg.sales')}}"--}}
{{--				},--}}
{{--				processing: true,--}}
{{--				serverSide: true,--}}
{{--				columns: [--}}

{{--					{data: 'name'},--}}
{{--					{data: 'total'},--}}
{{--					{data: 'orders_count'},--}}
{{--					{data: 'average'},--}}
{{--				],--}}
{{--			});--}}

{{--		});--}}
{{--	</script>--}}

{{--	<script>--}}
{{--		@if(\Settings::get('google_analytics_id'))--}}
{{--		<!-- Global site tag (gtag.js) - Google Analytics -->--}}
{{--		<script async--}}
{{--		src="https://www.googletagmanager.com/gtag/js?id={{ \Settings::get('google_analytics_id') }}"></script>--}}
{{--	<script>--}}
{{--		window.dataLayer = window.dataLayer || [];--}}

{{--		function gtag() {--}}
{{--			dataLayer.push(arguments);--}}
{{--		}--}}

{{--		gtag('js', new Date());--}}

{{--		gtag('config', "{{ \Settings::get('google_analytics_id') }}");--}}
{{--	</script>--}}
{{--	@endif--}}
{{--	</script>--}}




{{--@endpush--}}
