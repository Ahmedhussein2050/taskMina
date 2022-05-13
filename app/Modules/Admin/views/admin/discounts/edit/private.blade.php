<input {{$disabled}} type="hidden" name="type" value="{{ $Discount->type ?? 'private' }}">


<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label" > {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input {{$disabled}} type="text" name="title" {{$disabled}} value="{{ $Discount->title }}" class='form-control'>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Promotor') }} <span
            style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        {{-- @dd( $Discount->promotors->pluck("user_id")) --}}

        {!! Form::select('promotor_id', $promotors->pluck('name', 'id'), $Discount->promotors->pluck('id'), ['class' => 'select2 m-b-10 select2-multiple myselect', 'multiple' => 'multiple',$disabled=> ""]) !!}


    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('commission') }}
        <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input {{$disabled}} type="number" name="commissionValue" class='form-control' value='{{ $Discount->commission }}'>
    </div>
    <label>
        <input {{$disabled}} type="radio" {{ $Discount->commission_type == 'perc' ? 'checked' : '' }} name="commission"
            value="perc"> %</label>
    <label> <input {{$disabled}} type="radio" {{ $Discount->commission_type == 'net' ? 'checked' : '' }} name="commission"
            value="net"> {{ get_default_currency()->code }}</label>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Date from') }} </label>
    <div class="col-sm-4">
        <input {{$disabled}} name="date_from" value='{{ date('m/d/Y h:m A', strtotime($Discount->start_date)) }}' required
            type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('to') }}
    </div>
    <div class="col-sm-4">

        <input {{$disabled}} name="date_to" value='{{ date('m/d/Y h:m A', strtotime($Discount->end_date)) }}' required
            type="datetime-local" class="form-control">
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-10">
        <input {{$disabled}} type="range" id="vol" value="{{ $Discount->limit }}" name="using_times" min="0" max="200"
            oninput="$(this).next().html($(this).val())">
        <span>{{ $Discount->limit }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-10">
        <input {{$disabled}} type="range" id="vol" value="{{ $Discount->user_times }}" name="user_times" min="0" max="50"
            oninput="$(this).next().html($(this).val())">
        <span>{{ $Discount->user_times }}</span>
    </div>
</div>

<div class="form-group row">


    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input {{$disabled}} type="number" name="bonusValue" class='form-control' value='{{ $Discount->value }}'>
    </div>


    <label>
        <input {{$disabled}} type="radio" {{ $Discount->calc_type == 'perc' ? 'checked' : '' }} name="bonus" value="perc"> %
    </label>

    <label><input {{$disabled}} type="radio" {{ $Discount->calc_type == 'net' ? 'checked' : '' }} name="bonus"
            value="net"> {{ get_default_currency()->code }}</label>

</div>


<div class="form-group row">

    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Exclude') }} </label>
    <div class="col-sm-4">
        <input {{$disabled}} class="form-check-input" name="exclude" type="checkbox" value="1"
            {{ $Discount->exclude == 1 ? 'checked' : '' }} id="defaultCheck1">
        <label class="form-check-label custom_check" for="defaultCheck1">
            First Order Users
        </label>
    </div>
</div>


@include("admin.discounts.edit.tabs")


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input {{$disabled}} class="btn btn-primary" type="submit" value="{{ _i('Save') }}">
    </div>
</div>
