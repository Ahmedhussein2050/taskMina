@php
	$system =old('system');
	$sms =old('sms');
	$emails =old('email');

@endphp
<input type="hidden" name="type" value="free">
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" value="{{old('title')}}" class='form-control' required>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Date from') }} </label>
    <div class="col-sm-4">
        <input name="date_from" value="{{old('date_from')}}" required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('to') }}
    </div>
    <div class="col-sm-4">

        <input name="date_to" value="{{old('date_to')}}" required type="datetime-local" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range"  value="{{old('using_times') ?? "25" }}" name="using_times" min="0" max="200" oninput="$(this).next().html($(this).val())">
		<span>{{old('using_times') ?? "25" }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" value="{{old('user_times') ?? "1" }}" name="user_times" min="0" max="50" oninput="$(this).next().html($(this).val())">
		<span>{{old('user_times') ?? "1" }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input type="number" name="bonusValue" value="{{old('bonusValue')}}" class='form-control' required="">
    </div>

    <label>
        <input type="radio" name="bonus" {{ old('bonus') == 'perc' ? 'checked' : '' }} value="perc" checked="checked">
        <i class="helper"></i>%
    </label>

    <label>
        <input type="radio" name="bonus" {{ old('bonus') == 'net' ? 'checked' : '' }} value="net">
        <i class="helper"></i>{{ _i('SAR') }}
    </label>

</div>
 <div class="form-group row">
    <label  class="col-sm-2 col-form-label"> {{ _i('Exclude') }} </label>
    <div class="col-sm-4">
        <input class="form-check-input" name="exclude" type="checkbox" {{ old('exclude') == '1' ? 'checked' : '' }} value="1" id="defaultCheck2">
        <label class="form-check-label custom_check" for="defaultCheck2">
           {{_i("First Order Users")}}
        </label>
    </div>
</div>

@include("admin.discounts.forms.tabs")

<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary" type="submit" value="{{ _i('Save') }}">
    </div>
</div>
