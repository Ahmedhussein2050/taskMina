@extends('admin.layout.index',[
'title' => _i('Notifications'),
'subtitle' => _i('Notifications'),
'activePageName' => '',
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/notifications') ,
'additionalPageName' => _i('Notifications'),
] )

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl mb-3">
            <span class="pull-left">
                  <a href="{{url('admin/notifications/create')}}" data-toggle="modal" data-target="#create" class="btn btn-primary create add-permission">
                        <i class="ti-plus"></i>{{_i('Send new notification')}}
                    </a>
            </span>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{ _i('Notifications') }} </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                        <table class="table table-striped table-bordered nowrap text-center datatable">
                            <thead>
                            <tr role="row">
                                <th> {{_i('ID')}}</th>
                                <th> {{_i('User')}}</th>
                                <th> {{_i('Text')}}</th>
                                <th> {{_i('Created at')}}</th>
                                <th> {{_i('Options')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{_i('Send new notification')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="{{url('admin/notifications')}}" method="post" class="form-horizontal"  id="form" data-parsley-validate="">
                        @csrf
                        <div class="box-body">
							<div class='row'>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> {{_i('Select country')}} </label>
										<div>
											<select name="country" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true id="sel_country" title="{{ _i('Please select country') }}" multiple>
												@foreach($countries AS $country)
												<option value="{{ $country->country_id }}">{{ $country->title }}</option>
												@endforeach
											</select>
											@if ($errors->has('title'))
												<span class="text-danger invalid-feedback" >
													<strong>{{ $errors->first('title') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> {{_i('Select city')}} </label>
										<div>
											<select name="city" multiple class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true id="sel_city" title="{{ _i('Please select city') }}">
												{{-- @foreach($cities AS $city)
												<option value="{{ $city->city_id }}">{{ $city->title }}</option>
												@endforeach --}}
											</select>
											@if ($errors->has('title'))
												<span class="text-danger invalid-feedback" >
													<strong>{{ $errors->first('title') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> {{_i('Select group')}} </label>
										<div>
											<select name="group" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true title="{{ _i('Please select group') }}">
												@foreach($groups AS $group)
												<option value="{{ $group->id }}">{{ $group->title }}</option>
												@endforeach
											</select>
											@if ($errors->has('title'))
												<span class="text-danger invalid-feedback" >
													<strong>{{ $errors->first('title') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> {{_i('Select users')}} </label>
										<div>
											<select name="users[]" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true multiple title="{{ _i('Please select users') }}">
												@foreach($users AS $user)
												<option value="{{ $user->id }}">{{ $user->name }}</option>
												@endforeach
											</select>
											@if ($errors->has('title'))
												<span class="text-danger invalid-feedback" >
													<strong>{{ $errors->first('title') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="" class="col-form-label"> {{_i('Select Promoters')}} </label>
										<div>
											<select name="users[]" class='selectpicker show-tick show-menu-arrow form-control' data-live-search=true multiple title="{{ _i('Please select Promoters') }}">
												@foreach($promotors AS $user)
													<option value="{{ $user->user_id }}">{{ $user->user->name ?? '' }}</option>
												@endforeach
											</select>
											@if ($errors->has('title'))
												<span class="text-danger invalid-feedback" >
													<strong>{{ $errors->first('title') }}</strong>
												</span>
											@endif
										</div>
									</div>
								</div>
							</div>
                            <div class="form-group row">
                                <label for="" class="col-md-12 col-form-label"> {{_i('Notification text')}} </label>
                                <div class="col-md-12">
                                    <textarea type="text" name="text" class="form-control{{ $errors->has('text') ? ' is-invalid' : '' }}" required="" ></textarea>
                                    @if ($errors->has('text'))
                                        <span class="text-danger invalid-feedback" >
                                            <strong>{{ $errors->first('text') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{_i('Send')}}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script  type="text/javascript">
        $(function() {
			$('#sel_country').change(function () {
				$.ajax({
				url: "ajax_city",
				type: "get",
				data: {
					ids:$("#sel_country").val()
				},
				success: function (res) {

					if (res.data) {
						$("#sel_city").children().remove().end();
						$("#sel_city").selectpicker("refresh");
						//if(data.length>0)
						{
							$.each(res.data,function(i,item)
							{
								$("#sel_city").append('<option value="'+i+'">'+item+'</option>')
							});
						}

						$("#sel_city").selectpicker("refresh");
					}
				}
			})

				});


            $('.datatable').DataTable({
				order: [[0,'desc']],
                processing: true,
                serverSide: true,
                ajax: '{{url('admin/notifications')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'user', name: 'user'},
                  	{data: 'textt', name: 'textt'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'options', name: 'options'},
                ]
            });
        });

		$('#form').submit(function (e) {
			e.preventDefault();
			var url = "{{ route('notification.store') }}";
			$.ajax({
				url: url,
				type: "post",
				data: new FormData(this),
				dataType: 'json',
				cache: false,
				contentType: false,
				processData: false,

				success: function (res) {
					if (res == 'error') {
						new Noty({
							type: 'error',
							layout: 'topRight',
							text: "{{ _i('All fields are required')}}",
							timeout: 2000,
							killer: true
						}).show();
					}
					if (res == 'success') {
						$('.modal').modal('hide');
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Added Successfully')}}",
							timeout: 2000,
							killer: true
						}).show();
					}
				}
			})
		});

		$(document).on('click', '.btn-delete[data-remote]', function (e) {
			e.preventDefault();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			var url = $(this).data('remote');
			$.ajax({
				url: url,
				type: 'DELETE',
				dataType: 'json',
				data: {method: '_DELETE', submit: true},
				success: function(res){
					if (res == 'success') {
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Deleted successfully')}}",
							timeout: 3000,
							killer: true
						}).show();
						$('.datatable').DataTable().draw(false);
					}
				}
			})
		});
    </script>
@endpush
