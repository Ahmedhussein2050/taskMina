<div class="page-body">
	<div class="row">

		@if (count($companies) > 0)
			@foreach ($companies as $company)
				<div class="col-sm-4 ">
					<div class="card">
						<div class="card-block">
							<div class="card-body card-block text-center">
								<div class="component-image">
									<img src="{{ asset($company['logo']) }}" style="max-width: 150px;">
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
{{-- @push('js')
<script type="text/javascript">
	function status(obj, id) {
		alert(id);
		var bol = $(obj).is(":checked");
		$.ajax({
			url: "shipping/" + id,
			type: "Post",
			data: {
				status: bol,
				_token: "{{ csrf_token() }}",
			},
			dataType: 'json',
			cache: false,
			success: function(response) {
				if (response.status == 'ok') {
					new Noty({
						type: 'success',
						layout: 'topRight',
						text: "Saved Successfully",
						timeout: 2000,
						killer: true
					}).show();
					$('.modal.modal_edit').modal('hide');
					//table.ajax.reload();
				}
			}
		});
	}
</script>
@endpush --}}
