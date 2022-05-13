<div class="col-sm-2">

    @php

        if (isset($index)) {
            $title2 = old('Titleitr');
            $desc = old('description');
        }
    @endphp

    @foreach ($langs as $item)

        <input class="form-control" placeholder="{{ $item->title }}" type="text" required=""
            name="Titleitr[{{ $item->code }}][]" value="{{ isset($title2) ? $title2[$item->code][$index] : '' }}">
    @endforeach


</div>
<div class="col-sm-3">
    @foreach ($langs as $item)
        <input class="form-control" placeholder="{{ $item->title }}" type="text" required=""
            name="description[{{ $item->code }}][]" value="{{ isset($desc) ? $desc[$item->code][$index] : '' }}">
    @endforeach


</div>

<div class="col-sm-2">

    <div class="input-group">
        <input class="form-control" type="number" required="" min="1" id="test" name="minimum[]"
            value="{{ isset($index) ? old('minimum')[$index] : '' }}">
        <span class="input-group-addon" id="basic-addon3">
            {{ get_default_currency()->code }}

        </span>
    </div>
</div>
<div class="col-sm-2">
    <div class="input-group">

        <input class="form-control" type="number" required="" min="1" name="maximum[]"
            value="{{ isset($index) ? old('maximum')[$index] : '' }}">
        <span class="input-group-addon" id="basic-addon3">
            {{ get_default_currency()->code }}

        </span>
    </div>
</div>
<div class="col-sm-2">
    <div class="input-group">

        <input class="form-control" type="number" required="" min="1" name="bonus[]"
            value="{{ isset($index) ? old('bonus')[$index] : '' }}">
        <span class="input-group-addon" id="basic-addon3">
            {{ get_default_currency()->code }}

        </span>
    </div>
</div>
