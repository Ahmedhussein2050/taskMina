<input type="hidden" name="type" value="voucher">
<input type="hidden" name="user_times" value="1">

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span
                style="color: #F00;">*</span></label>
    <div class="col-sm-6">
        <input type="text" name="title"  {{ $disabled }} value="{!! $offer->title->{getLangCode()} !!}" class='form-control' required>
    </div>

    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Limit') }} <span
                style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" min="0"  {{ $disabled }} name="using_times" value="{{$offer->offer_limit}}" class='form-control' required>
    </div>
</div>
<div class="form-group row">
    <label for="title2" class="col-sm-2 col-form-label"> {{ _i('Reason') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">

		<textarea name="reason" {{ $disabled }} class='form-control' required>{!! $offer->description->{getLangCode()} !!}</textarea>
    </div>
</div>



<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Start Date') }} </label>
    <div class="col-sm-4">
        <input name="start_date" {{ $disabled }} value="{{date('Y-m-d\TH:i',strtotime($offer->start_date))}}" required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('End Date') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" {{ $disabled }} value="{{date('Y-m-d\TH:i',strtotime($offer->end_date))}}" required type="datetime-local" class="form-control">
    </div>
</div>



@include('admin.offer.edit.editVoucherItr')


<div class="form-group row ">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit"  {{ $disabled }} value="{{ _i('Save') }}">
    </div>
</div>


