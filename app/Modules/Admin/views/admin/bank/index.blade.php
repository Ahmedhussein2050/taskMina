@extends('admin.layout.index',
[
    'title' => _i('Banks'),
    'subtitle' => _i('Banks'),
    'activePageName' => _i('Banks'),
    'activePageUrl' => route('transferBank.index'),
    'additionalPageName' => _i('Settings'),
    'additionalPageUrl' => route('settings.index') ,
])

@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if(Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>

    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card blog-page" id="blog">
            <div class="card-block">
            @include('admin.layout.message')
            {!! $dataTable->table([
                'class'=> 'table table-bordered table-striped table-responsive text-center datatable'
            ],true) !!}
        </div>
    </div>
    </div>
	{{-- lang --}}
	<div class="modal fade modal_create " id="langedit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" style="margin-top:40px;">
		<div class="modal-dialog" role="document">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="header"> {{_i('Trans To')}} : </h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<form  action="{{route('bank.store.translation')}}" method="post" class="form-horizontal"  id="lang_submit" data-parsley-validate="">
							{{method_field('post')}}
							{{csrf_field()}}
							<input type="hidden" name="id" id="id_data" value="">
							<input type="hidden" name="lang_id" id="lang_id_data" value="" >
							<div class="box-body">
								<div class="form-group row">
									<label for="" class="col-sm-2 control-label "> {{_i('Title')}} </label>
									<div class="col-md-10">
										<input type="text"  placeholder="{{_i('name')}}" name="name"  value=""
											class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" required="" id="titletrans" >
									</div>
								</div>

							</div>
							<!-- /.box-body -->
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
								<button type="submit" class="btn btn-primary" >
								{{_i('Save')}}
								</button>
							</div>
							<!-- /.box-footer -->
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
   {{-- end lang --}}

    @push('js')
        {!! $dataTable->scripts() !!}

		<script>
			$('body').on('click', '.lang_exdd', function (e) {

				e.preventDefault();
				var transRowId = $(this).data('id');

				var lang_id = $(this).data('lang');
				$.ajax({
					url: '{{route('bank.get.translation')}}',
					method: "get",
					"_token": "{{ csrf_token() }}",
					data: {
						'lang_id': lang_id,
						'transRow': transRowId,
					},
					success: function (response) {
						console.log(response);
						if (response.data == 'false'){
							$('#titletrans').val('');
							$('#editor1').val('');
						} else{
							$('#titletrans').val(response.data.title);
						}
					}
				});
				$.ajax({
					url: '{{route('admin.get.lang')}}',
					method: "get",
					data: {
						lang_id: lang_id,
					},
					success: function (response) {
						$('#header').empty();
						$('#header').text('Translate to : ' + response);
						$('#id_data').val(transRowId);
						$('#lang_id_data').val(lang_id);
					}
				});
			});

			$('body').on('submit', '#lang_submit', function (e) {
			e.preventDefault();
			let url = $(this).attr('action');
			$.ajax({
				url: url,
				method: "post",
				"_token": "{{ csrf_token() }}",
				data: new FormData(this),
				dataType: 'json',
				cache       : false,
				contentType : false,
				processData : false,
				success: function (response) {
					if (response.errors){
						$('#masages_model').empty();
						$.each(response.errors, function(index, value) {
							$('#masages_model').show();
							$('#masages_model').append(value + "<br>");
						});
					}
					if (response == 'SUCCESS'){
						$('.datatable').DataTable().draw(false);
						new Noty({
							type: 'success',
							layout: 'topRight',
							text: "{{ _i('Translated Successfully')}}",
							timeout: 2000,
							killer: true
						}).show();
						$('.modal.modal_create').modal('hide');
					}
				},
			});
		   });

		</script>
    @endpush
    <style>
        .table{
            display: table !important;
        }
    </style>


@endsection
