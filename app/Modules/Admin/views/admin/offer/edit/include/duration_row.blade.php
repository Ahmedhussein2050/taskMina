@foreach ($Offer_duration as $key => $value)
    <div class="form-group row dataa" id="get_new_data-{{ $key+1 }}">
        <div class="col-sm-3">
            <div class="input-group">
                <input class="form-control" {{ $disabled }} id="test" data-i="{{ $key+1 }}" type="text" value="{{ $value->min_commition }}"
                    name="minumim[]">
                <span class="input-group-addon" id="basic-addon3">%</span>
            </div>
        </div>
        <div class="col-sm-3">
			<div class="input-group">
            <input class="form-control" {{ $disabled }} type="text" id="test2"value="{{ $value->max_commition }}"
                name="maximum[]">
				<span class="input-group-addon" id="basic-addon3">%</span>
            </div>
        </div>
        <div class="col-sm-3">
			<div class="input-group">
            <input class="form-control" {{ $disabled }} type="text" value="{{ $value->bonus }}" name="bonus[]"><span class="input-group-addon" id="basic-addon3">%</span>
		</div>
        </div>
        @if ($loop->index == 0)
            <div class="col-1">
                <button id="plus" {{ $disabled }} class="form-control "><i class="ion-plus-round"></i></button>

            </div>
			<div class="col-sm-1">

				<button onclick="myFunction({{ $key+1 }})"   type="button" class="btn btn-primary"><span class="ti ti-settings"></span></button>
			   </div>
        @else
            <div class="col-1">
                <button type="button" {{ $disabled }} class="form-control remove-tr"><i
                        class="ion-minus"></i></button>
            </div>
			<div class="col-sm-1">

				<button onclick="myFunction({{ $key+1 }})"  type="button" class="btn btn-primary"><span class="ti ti-settings"></span></button>
			</div>
        @endif
    </div>
@endforeach
