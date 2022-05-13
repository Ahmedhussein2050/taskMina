<div class="form-group row">
    <div class="col-sm-2">
        {{ _i('Title') }}
    </div>
    <div class="col-sm-3">
        {{ _i('Description') }}
    </div>

    <div class="col-sm-2">

        {{ _i('From') }}

    </div>
    <div class="col-sm-2">

        {{ _i('To') }}

    </div>
    <div class="col-sm-2">

        {{ _i('Bonus') }}

    </div>
    <div class="col-sm-1"></div>

</div>
@foreach ($offer_codes as $item)

    <div class="form-group row ">
        <div class="col-sm-2">
            @foreach ($langs as $lang)
                <input class="form-control" type="text" required="" {{ $disabled }}
                    name="Titleitr[{{ $lang['code'] }}][]" value="{{ $item->title->{$lang['code']} }}">
            @endforeach
        </div>
        <div class="col-sm-3">
            @foreach ($langs as $lang)
                <input class="form-control" {{ $disabled }} type="text" required=""
                    name="description[{{ $lang['code'] }}][]" value="{{ $item->description->{$lang['code']} }}">
            @endforeach


        </div>

        <div class="col-sm-2">
            <div class="input-group">

                <input class="form-control" type="number" min="1" {{ $disabled }}
                    value="{{ $item->min_amount }}" name="minimum[]">
                <span class="input-group-addon" id="basic-addon3">
                    {{ get_default_currency()->code }}

                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">

                <input class="form-control" type="number" min="1" name="maximum[]" {{ $disabled }}
                    value="{{ $item->max_amount }}">
                <span class="input-group-addon" id="basic-addon3">
                    {{ get_default_currency()->code }}

                </span>
            </div>
        </div>
        <div class="col-sm-2">
            <div class="input-group">
                <input class="form-control" type="number" min="1" name="bonus[]" {{ $disabled }}
                    value="{{ $item->bonus }}">
                <span class="input-group-addon" id="basic-addon3">
                    {{ get_default_currency()->code }}

                </span>
            </div>
        </div>
        @if ($loop->index == 0)
            <div class="col-sm-1">
                <button id="plusVou" class="btn btn-success" {{ $disabled }}><i
                        class="ion-plus-round"></i></button>
            </div>
        @else

            <button type="button" style="" class=" btn btn-success remove-tr" {{ $disabled }}><i
                    class="ion-minus"></i></button>
        @endif

    </div>

@endforeach
<div class="form-group row" id="get_vou_data">

</div>
@push('js')

    <script>
        $('#plusVou').click(function(event) {
            event.preventDefault();

            $('#get_vou_data').append(
                `
                <div class="form-group row" >
                @include("admin.offer.forms.include.row")

                    <button type="button"  class="btn btn-danger remove-tr"><i class="ion-minus"></i></button>
                </div>
                `
            );
        })
        $(document).on('click', '.remove-tr', function() {
            $(this).parent('div').remove();
        });
    </script>

@endpush
