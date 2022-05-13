<div class="form-group row">
    <div class="col-sm-2">
        {{ _i('Title') }}
    </div>
    <div class="col-sm-3">
        {{ _i('Description') }}
    </div>

    <div class="col-sm-2">

        {{ _i('Amount From') }}

    </div>
    <div class="col-sm-2">
        {{ _i('Amount To') }}
    </div>
    <div class="col-sm-2">
        {{ _i('Bonus') }}
    </div>
    <div class="col-sm-1"></div>
</div>

@if (is_array(old('bonus')))
    @for ($i = 0; $i < count(old('bonus')); $i++)

        <div class="form-group row">
            @include("admin.offer.forms.include.row",["index" => $i])
            @if ($i == 0)
                <div class="col-sm-1">
                    <button id="plusVou" class="btn btn-success"><i class="ion-plus-round"></i></button>
                </div>
            @else
                <button type="button" class=" remove-tr col-sm-1 btn btn-danger"><i class="ion-minus"></i></button>
            @endif
        </div>
    @endfor
@else
    <div class="form-group row">
        @include("admin.offer.forms.include.row")
        <div class="col-sm-1">
            <button id="plusVou" class="btn btn-success"><i class="ion-plus-round"></i></button>
        </div>
    </div>
@endif

<div class="form-group row" id="get_vou_data">

</div>

@push('js')

    <script>
        $('#plusVou').click(function(event) {
            event.preventDefault();

            $('#get_vou_data').append(
                `
					<div class="form-group row">
						@include("admin.offer.forms.include.row")
                    <button type="button"  class=" remove-tr col-sm-1 btn btn-danger"><i class="ion-minus"></i></button>
					</div>
                `
            );
        })
        $(document).on('click', '.remove-tr', function() {
            $(this).parent('div').remove();
        });
    </script>

@endpush
