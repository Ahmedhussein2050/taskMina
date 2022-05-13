<input type="hidden" name="type" value="voucher">
<input type="hidden" name="user_times" value="1">

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input type="text" name="title" class='form-control' value="{{ old('title') }}"  required>
    </div>

    <label class="col-sm-2 col-form-label"> {{ _i('User Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" name="limit" class='form-control' value="{{ (old('limit'))?:1 }}" required min="1">
    </div>
</div>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Reason') }} </label>
    <div class="col-sm-10">
        <textarea name="reason" class='form-control'>{{ old('reason') }}</textarea>
    </div>
</div>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Start Date') }} </label>
    <div class="col-sm-4">
        <input name="start_date" value="{{ old('start_date') }}" required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('End Date') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" value="{{ old('end_date') }}" required type="datetime-local" class="form-control">
    </div>
</div>



@include('admin.offer.forms.voucherItr')


<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
    </div>
</div>
