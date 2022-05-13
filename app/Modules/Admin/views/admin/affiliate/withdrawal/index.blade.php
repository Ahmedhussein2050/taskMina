@extends('admin.layout.index',[
	'title' => _i('Withdrawal'),
	'subtitle' => _i('Withdrawal'),
	'activePageName' => _i('Withdrawal'),
	'activePageUrl' => '',
	'additionalPageUrl' => '' ,
	'additionalPageName' => '',
] )

@section('content')
	@push('css')
		<style>
			.star-ratings-css {
				unicode-bidi: bidi-override;
				color: #c5c5c5;
				font-size: 25px;
				height: 25px;
				width: 100px;
				margin: 0 auto;
				position: relative;
				padding: 0;
				text-shadow: 0px 1px 0 #a2a2a2;
			}
			.star-ratings-css-top {
				color: #e7711b;
				padding: 0;
				position: absolute;
				z-index: 1;
				display: block;
				top: 0;
				right: 0;
				overflow: hidden;
			}
			.star-ratings-css-bottom {
				padding: 0;
				display: block;
				z-index: 0;
			}
			.star-ratings-sprite {
				background: url("{{ asset('images/star-rating-sprite.png') }}") repeat-x;
				font-size: 0;
				height: 21px;
				line-height: 0;
				overflow: hidden;
				text-indent: -999em;
				width: 110px;
				margin: 0 auto;
			}
			.star-ratings-sprite-rating {
				background: url("{{ asset('images/star-rating-sprite.png') }}") repeat-x;
				background-position: 0 100%;
				float: left;
				height: 21px;
				display: block;
			}
		</style>
	@endpush
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
					'class'=> 'table table-bordered table-striped table-responsive text-center'
				],true) !!}
			</div>
		</div>
	</div>

	<div class="modal fade" id="reply-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ _i('Reply To Comment') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method='post' action='' id='reply-form'>
					@csrf
					<div class="modal-body">
						<label class='label label-default comment'></label>
						<textarea class="form-control" name="comment" required></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success modal-reply-btn" data-url=''>{{ _i('Reply') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Comment') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method='post' action='' id='edit-form'>
					@csrf
					@method('PATCH')
					<div class="modal-body">
						<textarea id="comment" class="form-control" name="comment" required></textarea>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-info modal-edit-btn" data-url=''>{{ _i('Update') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>

	<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">{{ _i('Delete record') }}</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<form method='post' action='' id='delete-form'>
					@csrf
					@method('DELETE')
					<div class="modal-body">
						{{ _i('Are you sure you want to delete this record ?') }}
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-danger modal-delete-btn" data-url=''>{{ _i('Delete') }}</button>
					</div>
				</form>
			</div>
		</div>
	</div>
	@push('js')
		{!! $dataTable->scripts() !!}
		<script type="text/javascript">
			var url = '';
			var table = window.LaravelDataTables["dataTableBuilder"];
			$(document).on('click', '.affiliate-update-rejected, .affiliate-update-paid', function(e){
				e.preventDefault();
				url = $(this).data('url');
				var $this = $(this);
				var status;
				if( $this.hasClass('affiliate-update-rejected') )
				{
					status = 'rejected'
				}
				else if( $this.hasClass('affiliate-update-paid') )
				{
					status = 'paid'
				}
				$.ajax({
					url: url,
					method: "patch",
					data: {
						_token: '{{ csrf_token() }}',
						status: status
					},
					success: function (response) {
						if (response.status == 'success'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Updated Successfully !')}}",
								timeout: 2000,
								killer: true
							}).show();
							table.ajax.reload();
						}
					}
				});
				
			})
			$(document).on('click', '.delete-btn', function(e){
				e.preventDefault();
				url = $(this).data('url');
			})
			$('body').on('submit','#delete-form',function (e) {
				e.preventDefault();
				$.ajax({
					url: url,
					method: "delete",
					data: {
						_token: '{{ csrf_token() }}',
					},
					success: function (response) {
						if (response.status == 'success'){
							new Noty({
								type: 'error',
								layout: 'topRight',
								text: "{{ _i('Deleted Successfully')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('#delete-modal').modal('hide');
							table.ajax.reload();
						}
					}
				});
			})
			$(document).on('click', '.edit-btn', function(e){
				e.preventDefault();
				url = $(this).data('url');
				var comment = $(this).data('comment');
				$('#comment').val(comment);
			})
			$('body').on('submit','#edit-form',function (e) {
				e.preventDefault();
				$.ajax({
					url: url,
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Updated Successfully !')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('#edit-modal').modal('hide');
							table.ajax.reload();
						}
					}
				});
			});
			$(document).on('click', '.reply-btn', function(e){
				e.preventDefault();
				url = $(this).data('url');
				var comment = $(this).data('comment');
				$('.comment').html(comment);
			})
			$('body').on('submit','#reply-form',function (e) {
				e.preventDefault();
				$.ajax({
					url: url,
					type: "POST",
					"_token": "{{ csrf_token() }}",
					data: new FormData(this),
					dataType: 'json',
					cache       : false,
					contentType : false,
					processData : false,
					success: function(response) {
						if (response == 'SUCCESS'){
							new Noty({
								type: 'success',
								layout: 'topRight',
								text: "{{ _i('Replied Successfully !')}}",
								timeout: 2000,
								killer: true
							}).show();
							$('#reply-modal').modal('hide');
							table.ajax.reload();
						}
					}
				});
			});
		</script>
	@endpush
	<style>
		.table{
			display: table !important;
		}
		.row,#jobtypes_table_wrapper{
			width: 100% !important;
		}
	</style>
@endsection