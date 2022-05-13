<input type="hidden" name="type" value="{{ $Discount->type ?? 'gift' }}">

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" {{$disabled}}  value="{{ $Discount->title }}" class='form-control'>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Date from') }} </label>
    <div class="col-sm-4">
        <input name="date_from" value='' {{$disabled}}  required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('to') }}
    </div>
    <div class="col-sm-4">

        <input name="date_to" value='' {{$disabled}}  required type="datetime-local" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" id="vol" value="{{ $Discount->limit }}" name="using_times" min="0" max="200"   oninput="$(this).next().html($(this).val())" {{$disabled}}>
        <span>{{ $Discount->limit }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" id="vol" value="{{ $Discount->user_times }}" name="user_times" min="0" max="50"   oninput="$(this).next().html($(this).val())" {{$disabled}} >
        <span>{{ $Discount->user_times }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input type="number" {{$disabled}}  name="bonusValue" class='form-control' value='{{ $Discount->value }}'>
    </div>
    <label><input {{$disabled}}  type="radio" {{ $Discount->calc_type == 'perc' ? 'checked' : '' }} name="bonus"
            value="perc"> %</label>
    <label>
		<input {{$disabled}}  type="radio" {{ $Discount->calc_type == 'net' ? 'checked' : '' }} name="bonus" value="net">
        {{ _i('SAR')}}</label>
</div>
{{-- 
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Exclude') }} </label>
    <div class="col-sm-4">
        <input class="form-check-input" name="exclude" type="checkbox" value="1"
            {{ $Discount->exclude == 1 ? 'checked' : '' }} id="defaultCheck1" {{$disabled}} >
        <label class="form-check-label custom_check" for="defaultCheck1">
            First Order Users
        </label>
    </div>
</div> --}}


@include("admin.discounts.edit.products")


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary" type="submit" {{$disabled}}  value="{{ _i('Save') }}">
    </div>
</div>
