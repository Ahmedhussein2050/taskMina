@extends('layout.index')

@section('main')
	<nav aria-label="breadcrumb" class="py-3">
		<div class="container">
			<ol class="breadcrumb">
				<li class="breadcrumb-item"><a href="{{route('home')}}">{{ _i('Home') }}</a></li>
				<li class="breadcrumb-item active" aria-current="page">{{ _i('Reset password') }}</li>
			</ol>
		</div>
	</nav>

	<section class="forms-page-wrapper">
		<div class="container">
			<div class="row">
				<div class="col-md-8 offset-md-2">
					<div class="p-3 rounded25 shadow">

						<!-- COPY FROM HERE TO ASIDE NAV -->
						<div class="wrapper">
							<header class="p-3  border-bottom d-flex justify-content-between">
								<span class="fz20 font-weight-bold text-color1">{{ _i('Reset password') }}</span>
								<span class="fz25 font-weight-bold text-color1 "><i class="fa fa-user"></i></span>
							</header>

							<div class="inner-items nice_scroll">
								@if(isset($error))
								<div class="alert alert-danger">{{ _i('The link has expired') }}</div>
								@else
								<form method='post' action='{{route('reset')}}' id='register-form'>
									@csrf
									<input type="hidden" class="form-control" name='email' value='{{ $email }}'>
									<input type="hidden" class="form-control" name='token' value='{{ $token }}'>
									<div class="form-group">
										<label>{{ _i('Password') }}</label>
										<input type="password" class="form-control" name='password'>
									</div>
									<div class="form-group">
										<label>{{ _i('Password confirmation') }}</label>
										<input type="password" class="form-control" name='password_confirmation'>
									</div>

									<footer class="fixed-footer-buttons">
										<button type="submit" class="btn btn-color1 mt-3 py-2 w-100">{{ _i('Submit') }}</button>
									</footer>
								</form>
								@endif
							</div>
						</div>
						<!-- END OF COPYING HERE -->
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection
@push('js')
	<script type="text/javascript">
	$('body').on('submit', '#register-form', function (e) {
		e.preventDefault();
		var url = $(this).attr('action');
		$.ajax({
			url: url,
			method: "post",
			"_token": "{{ csrf_token() }}",
			data: new FormData(this),
			dataType: 'json',
			cache       : false,
			contentType : false,
			processData : false,
			error: function(response)
			{
				var errors = '';
				console.log(response.responseJSON.errors);
				$.each(response.responseJSON.errors, function( index, value ) {
					errors = errors + value + "<br>";
				});
				Swal.fire({
				  icon: 'error',
				  title: 'Oops...',
				  html: errors,
				})
			},
			success: function (response) {

				if (response == 'error'){
					Swal.fire({
					  icon: 'error',
					  title: '{{ _i('Token Not Found.') }}',
					  timer: 3000
					})
				}
				else if (response == 'success'){
					Swal.fire({
					  icon: 'success',
					  title: '{{ _i('Password Updated Success.') }}',
					  timer: 3000
					})
					window.location.href='{{ route('home', app()->getLocale()) }}';
				}
			},
		});
	});
	</script>
@endpush
