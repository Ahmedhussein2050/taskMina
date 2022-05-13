@foreach ($options as $option)
    <?php

    $selectedCountry = null;
    $currency_code = $option->currency != null ? $option->currency->code : null;
    ?>
    <div class="single_shipping_price single_shipping_price_v2" id="option_{{ $loop->iteration }}">
        <div class="card">
            <div class="card-block">
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">
                            @if ($option->country == null)
                                {{ _i('All Countries') }}
                            @else
                                {{ $option->country->title(App\Bll\Lang::getSelectedLangId()) }}
                            @endif
                        </div>
                    </div>
                </div>
                <!--------------------------- cities--------------------->

                @php

                    $cities = $option->cities;

                @endphp
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">
                            @if ($option->cities->count() == 0)
                                {{ _i('All Cities') }}
                            @else
                                @foreach ($cities as $city)
                                {{-- @dd( $city) --}}
                                    {{ $city->title(App\Bll\Lang::getSelectedLangId()) }}
                                @endforeach

                            @endif


                        </div>
                    </div>
                </div>
                <!--------------------------- regions--------------------->
                @php
                    $regions = $option->regions;

                @endphp

                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">

                            {{-- @if ($option->regions->count() == 0)
                                {{ _i('All Regions') }}
                            @else
                                @foreach ($regions as $city)
                                     {{ $city->title(App\Bll\Lang::getSelectedLangId()) }}
                                @endforeach

                            @endif --}}
                        </div>
                    </div>
                </div>
                <!--------------------------- pricing type--------------------->
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">
                            @if ($option['cost'] != null)
                                {{ _i('Pricing Type : Fixed') }}
								<div >
									<div class="row ">
										<div class="col-sm-12">
											<div class="input-group ">
												<input readonly="readonly" disabled="disabled" type="number" class="form-control "
													step=".1" value="{{ $option['cost'] }}"
													placeholder="{{ _i('Shipping Cost') }}">
												<span class="input-group-addon input-group-addon-small" id="basic-addon5">
													<i class="ti ti-money"></i>
												</span>
												<button type="button"
													class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
											</div>
										</div>
									</div>
								</div>
                            @else
                                {{ _i('Pricing Type : By Weight') }}
								<div >
									@php
										$shipping_type = \App\Modules\Orders\Models\Shipping\Shipping_type::where('shipping_option_id', $option->id)->first();
									@endphp
									@if ($shipping_type != null)
										<div class="row ">
											<div class="col-sm-12"><label> {{ _i('Cost') }}</label>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														 value="{{ $shipping_type['no_kg'] }}"
														placeholder="{{ _i('The first kilogram') }}">
													<span class="input-group-addon input-group-addon-small" id="basic-addon5">
														{{ _i('first') }}
													</span>
													<button type="button" disabled="disabled"
														class="btn  btn-sm mr-3 ">{{ _i('KG') }}</button>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														step=".1"  value="{{ $shipping_type['cost_no_kg'] }}"
														placeholder="{{ _i('Shipping Cost') }}">
													<span class="input-group-addon input-group-addon-small" id="basic-addon5">
														<i class="ti ti-money"></i>
													</span>

													<button disabled="disabled" type="button"
														class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
												</div>
											</div>
										</div>


										<!----------------- Cost of the increase ------------------->
										<div class="row ">
											<div class="col-sm-12"><label>
													{{ _i('Cost of the increase') }}</label>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														 step="0.1"
														value="{{ $shipping_type['cost_increase'] }}"
														placeholder="{{ _i('Cost of the increase') }}">
													<button disabled="disabled" type="button"
														class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														value="{{ $shipping_type['kg_increase'] }}"
														placeholder="{{ _i('Cost by weight') }}">
													<button disabled="disabled" type="button"
														class="btn  btn-sm mr-3 ">{{ _i('KG') }}</button>
												</div>
											</div>
										</div>

									@else
										<div class="row ">
											<div class="col-sm-12"><label> {{ _i('Cost') }}</label>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														 placeholder="{{ _i('The first kilogram') }}">
													<span class="input-group-addon input-group-addon-small" id="basic-addon5">
														{{ _i('first') }}
													</span>
													<button disabled="disabled" type="button"
														class="btn  btn-sm mr-3 ">{{ _i('KG') }}</button>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														step=".1"  placeholder="{{ _i('Shipping Cost') }}">
													<span class="input-group-addon input-group-addon-small" id="basic-addon5">
														<i class="ti ti-money"></i>
													</span>
													<button disabled="disabled" type="button"
														class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
												</div>
											</div>
										</div>
										<!----------------- Cost of the increase ------------------->
										<div class="row ">
											<div class="col-sm-12"><label>
													{{ _i('Cost of the increase') }}</label>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input disabled="disabled" class="form-control " type="number"
														 step="0.1"
														placeholder="{{ _i('Cost of the increase') }}">
													<button type="button"
														class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="input-group ">
													<input readonly="readonly" disabled="disabled" class="form-control " type="number"
														 placeholder="{{ _i('Cost by weight') }}">
													<button type="button"
														class="btn  btn-sm mr-3 ">{{ _i('KG') }}</button>
												</div>
											</div>
										</div>
									@endif
								</div>
                            @endif

                        </div>
                    </div>
                </div>
                <!--------------------------- shipping cost --------------------->
                <!--------------------------- if Pricing Type : By Weight --------------------->


                <!--------------------------- if Pricing Type : Fixed --------------------->

                <!--------------------------- shipping time --------------------->
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">
                            <input readonly="readonly" disabled="disabled" type="number" class="form-control "
                                 value="{{ $option['delay'] }}"
                                placeholder="{{ _i('Shipping time (For example 3-5 days)') }}">
                            <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                <i class="fa fa-clock-o"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!--------------------------- Paiement on delivery --------------------->
                <div class="row ">
                    <div class="col-sm-12">
                        <div class="input-group ">
                            <select readonly="readonly" disabled="disabled" class="form-control  delivery_method"
                               >
                                <option selected>{{ _i('Paiement on delivery ?') }}</option>
                                <option value="available"
                                    {{ $option['cash_delivery_commission'] != null ? 'selected' : '' }}>
                                    {{ _i('Payment on delivery: Available') }}</option>
                                <option value="not_available"
                                    {{ $option['cash_delivery_commission'] == null ? 'selected' : '' }}>
                                    {{ _i('Payment on delivery: Not available') }}</option>
                            </select>
                            <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                <i class="ti ti-wallet"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <!--------------------------- cash_delivery_commission --------------------->
                <div class="cach_commission" style="display:  @if ($option['cash_delivery_commission'] != null) flex @else none @endif ">
                    <div class="row ">
                        <div class="col-sm-12">
                            <div class="input-group ">
                                <input readonly="readonly" disabled="disabled" class="form-control " type="number"

                                    value="{{ $option['cash_delivery_commission'] }}"
                                    placeholder="{{ _i('Cash delivery commission') }}">
                                <span class="input-group-addon input-group-addon-small" id="basic-addon5">
                                    <i class="ti ti-money"></i>
                                </span>
                                <button type="button"
                                    class="btn  btn-sm mr-3 ">{{ $currency_code }}</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!--------------------------- delete shipping price --------------------->

            </div>
            <div class="card-footer ">

                <button type="button" class="btn btn-danger "
                    onclick="delete_shipping_price_section(this , {{ $option['id'] }})"><i
                        class="fa fa-times"></i>
                    {{ _i('Delete Condition') }}</button>

            </div>
        </div>
    </div>
@endforeach
