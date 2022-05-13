<div class="col-xs-5 form-group">
	<a class="btn btn-primary  btn-round col-sm-3 create" id="add-btn"
		href="{{ route('shipping.create') }}">
		<i class="fa fa-plus"></i>{{ _i('New shipping company') }}</a>
</div>
<div class="page-body">
	<div class="row">

		@if (count($companies) > 0)
			@foreach ($companies as $company)
				<div class="col-sm-4 ">
					<div class="card">
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="component-image">
									<img src="{{ asset($company['logo']) }}"
										style="max-width: 150px;">
								</div>
								<p class="component-desc">
									<b>{{ $company['title'] }}</b>
								</p>
								<table style='text-align: center;width: 100%;'>
									<tr>
										<td>
											<div class="form-group">
												<div class="btn-group w-100">
													<button type="button"
														class="btn btn-warning dropdown-toggle w-100 float-none"
														data-toggle="dropdown" title="Translation">
														<span class="ti ti-settings"></span>
													</button>
													<ul class="dropdown-menu"
														style="right: auto; left: 0; width: 5em; ">
														@foreach ($languages as $lang)
															<li>
																<a href="#" data-toggle="modal"
																	data-target="#langedit"
																	class="lang_ex"
																	data-id="{{ $company->id }}"
																	data-lang="{{ $lang->id }}"
																	style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a>
															</li>
														@endforeach
													</ul>
												</div>
											</div>
										</td>
										<td>
											<div class="form-group">
												<a class="btn text-white bg-success "
													href="{{ route('shipping.edit', $company->id) }}"><i
														class="ti ti-clipboard">{{ _i('Edit') }}</i>
												</a>
											</div>
										</td>
										<td>
											<div class="form-group">
												<div class="btn-group">
													<a
														href="{{ url('admin/shipping/company/delete/' . $company->id) }}">
														<button class="btn btn-danger " type="button">
															<i
																class="ti ti-trash">{{ _i('Delete') }}</i>
														</button>
													</a>
												</div>
											</div>
										</td>
									</tr>
									<tr>
										<td>
											<div class="form-group">
												<div class="btn-group">
													<input type="checkbox" class="js-switch"
														value="free"
														onchange="status(this,{{ $company->id }})"
														title="{{ _i('Free Shipping') }}"
														@if ($company->shipping_type == 'free') checked @endif
														name="free_shipping" id="free_shipping" />
													{{ _i('Free Shipping') }}

												</div>
											</div>
										</td>
									</tr>
								</table>
							</div>
						</div>
					</div>
				</div>
			@endforeach
		@endif
	</div>
</div>
