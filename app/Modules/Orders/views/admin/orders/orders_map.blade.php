@extends('admin.layout.index',
[
	'title' => _i('Show Order'),
	'subtitle' => _i('Show Order'),
	'activePageName' => _i('Show Order'),
	'activePageUrl' => '',
	'additionalPageName' =>  _i('Orders'),
	'additionalPageUrl' => route('admin.orders.index')
])
<style type="text/css">
	#map_canvas {
		height: 300px;
		width: 100%
	}
</style>
@push('js')


@endpush
	@push('css')
		<link rel="stylesheet" href="{{asset('css/custom.css')}}">
		<style>
			.dropdown-menu {
				z-index: 9999;
			}
		</style>
	@endpush

@section('content')
	<div class="row">
{{--		<label class="col-sm-2 col-form-label">{{_i('address')}}</label>--}}

		<div class="form-group col-sm-10">
			<div id="googleMap" style="width: 100%; height: 500px;"></div>
		</div>
	</div>


@endsection
@push('js')
	<script type="text/javascript"  src="//maps.googleapis.com/maps/api/js?v=3.exp&sensor=false&key={{config('app.key_script')}}&language=ar"></script>
	<script type="text/javascript">

		var locationArray = @json($orders_for_map);
		console.log(locationArray) ;
        const  map = new google.maps.Map(document.getElementById('googleMap'), {
			zoom: 3,
			center: new google.maps.LatLng(26.8357675, 30.7956597),
			mapTypeId: google.maps.MapTypeId.ROADMAP
		});


		var infowindow = new google.maps.InfoWindow();

		var marker, i;

		for (i = 0; i < locationArray.length; i++) {
			marker = new google.maps.Marker({
				position: new google.maps.LatLng(locationArray[i].city.lat, locationArray[i].city.lng),
				map: map,

			});


            google.maps.event.addListener(marker, 'click', (function (marker, i) {

                var content  =JSON.stringify(locationArray[i].count);

                console.log(content);
                var infowindow = new google.maps.InfoWindow({
                    content: content
                });

                return function () {
                    infowindow.open(map, marker);
                }
            })(marker, i));
        }
	</script>
@endpush
