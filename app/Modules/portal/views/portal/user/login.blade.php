@extends('layout.index')

@section('main')
<section class="forms-page-wrapper my-5">
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="p-3 rounded25 shadow">

                    <div class="wrapper">
                        <div class="p-3 mb-4 border-bottom d-flex justify-content-between">
                            <span class="fz20 fw-bold text-color1">Login</span>
                            <span class="fz25 fw-bold text-color1 "><i class="fa fa-user"></i></span>
                        </div>


                        <form method='post' action='{{route('login')}}' id='register-form'  data-parsley-validate>
                            @csrf
                            <div class="form-group">
                                <label>{{ _i('Email address') }}</label>
                                <input type="email" class="form-control" name="email" id="email">
                            </div>

                            <div class="form-group">
                                <label>{{ _i('Password') }}</label>
                                <input type="password" class="form-control" name="password">
                            </div>

                            <div class="d-flex justify-content-between gap-3 py-3">
                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                                    <label class="form-check-label" for="exampleCheck1">{{ _i('Remember me') }}</label>
                                </div>

                                <a href="{{route('password.forgot')}}" class="form-text text-color1 fw-bold ">{{ _i('Forgot password') }}?</a>

                            </div>

                            <footer class="fixed-footer-buttons">
                                <button type="submit" class="btn btn-color1 mt-3 py-2 w-100 ">{{ _i('Login') }}  </button>
                                 <a href="{{ route('register.index') }}" class="btn btn-color1-outlined mt-3 py-2 w-100">{{ _i('Register') }}</a>
                                 <a href="{{route('google.redirect')}}" class="btn btn-color1-outlined mt-3 py-2 w-100 google-btn"><i class="fa fa-google"></i> {{ _i('Login With Google') }}</a>
                                </footer>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('js')

     <script src="https://cdnjs.cloudflare.com/ajax/libs/jscroll/2.4.1/jquery.jscroll.min.js"></script>
	<script type="text/javascript">


	$(document).ready(function(){
		$('#register-form').on('submit', function (e) {
			e.preventDefault();
 			$(".img_loading").html('<h5>{{_i("Loading")}} ......</h5>');
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
						if (response == 'success'){
							Swal.fire({
								icon: 'success',
								title: '{{ _i('Successfully Logged In') }}',
								timer: 1500
							})
							window.location="{{url('/')}}";
						}else{
							if (response.error ){
								Swal.fire({
									icon: 'error',
									title: response.error,
								})
								console.log('worked');

								$(".img_loading").html('{{_i('Login')}}');
							}
							if (response.activate) {
								Swal.fire({
									icon: 'error',
									title: response.activate,
									confirmButtonText: "{{_i('Re-send Activiation')}}",
								}).then(function (isConfirm) {
									if (isConfirm) {

									}
								});


								$(".img_loading").html('{{_i('Login')}}');
							}
						}
					},
				});

		});

	});
	</script>
@endpush
