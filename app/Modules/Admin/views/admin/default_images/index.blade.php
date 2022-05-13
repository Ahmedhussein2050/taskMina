@extends('admin.layout.index',
[
	'title' => _i('Default Images'),
	'subtitle' => _i('Default Images'),
	'activePageName' => _i('Default Images'),
	'activePageUrl' => route('default.images.index'),
	'additionalPageName' =>  _i('Settings'),
	'additionalPageUrl' => route('admin.home')
])
@section('content')
<div class="box-body">
	<div class="row">
		<div class="col-md-3 col-lg-3">
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Favicon') }}</h5>
					</div>
					<div class="card-block">
						<div>
							<img src="{{$images->favicon}}" style="width: 100px;height: 100px;cursor: pointer;">
						</div>
					</div>
					<form action="{{route('admin.default.images.edit' , ['favicon' , $images->id])}}" enctype="multipart/form-data" method="post">
						{{ csrf_field() }}
						<input hidden  type="file" name="image">
					</form>
				</div>
		</div>
		<div class="col-md-3 col-lg-3">
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Header') }}</h5>
					</div>
					<div class="card-block">
						<div>
							<img src="{{$images->header}}" style="width: 100px;height: 100px;cursor: pointer;">
						</div>
					</div>
					<!-- <h5>Change Image</h5> -->
					<form action="{{route('admin.default.images.edit' , ['header' , $images->id])}}" enctype="multipart/form-data" method="post">
						{{ csrf_field() }}
						<input hidden  type="file" name="image">
					</form>
				</div>
		</div>
		<div class="col-md-3 col-lg-3">
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Footer') }}</h5>
					</div>
					<div class="card-block">
						<div>
							<img src="{{$images->footer}}" style="width: 100px;height: 100px;cursor: pointer;">
						</div>
					</div>
					<!-- <h5>Change Image</h5> -->
					<form action="{{route('admin.default.images.edit' , ['footer' , $images->id])}}" enctype="multipart/form-data" method="post">
						{{ csrf_field() }}
						<input hidden  type="file" name="image">
					</form>
				</div>
		</div>
		<div class="col-md-3 col-lg-3">
				<div class="card">
					<div class="card-header">
						<h5>{{ _i('Not found') }}</h5>
					</div>
					<div class="card-block">
						<div>
							<img src="{{$images->not_found}}" style="width: 100px;height: 100px;cursor: pointer;">
						</div>
					</div>
					<!-- <h5>Change Image</h5> -->
					<form action="{{route('admin.default.images.edit' , ['not_found' , $images->id])}}" enctype="multipart/form-data" method="post">
						{{ csrf_field() }}
						<input hidden  type="file" name="image">
					</form>
				</div>
		</div>
	</div>
</div>
@endsection
@push('js')
<script>
	$('img').click(function() {
		$(this).parent().parent().parent().find('input[type="file"]').trigger('click');
	});
	$('input[type="file"]').change(function() {
		$(this).parent().submit();
	});
</script>
@endpush
