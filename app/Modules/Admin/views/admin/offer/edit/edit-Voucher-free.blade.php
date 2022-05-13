<input type="hidden" name="type" value='voucher-free'>
<input type="hidden" name="user_times" value="1">


<div class="col-lg-12 col-xl-12">
    <ul class="nav nav-tabs  tabs" role="tablist">
        @foreach ($langs as $item)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif"
                    data-toggle="tab" href="#home{{ $item->id }}" role="tab">{{ $item->title }}</a>
            </li>
        @endforeach
    </ul>
    <!-- Tab panes -->
    <div class="tab-content tabs card-block">
        @foreach ($langs as $item)
            <div class="tab-pane @if ($loop->first) active @endif"
                id="home{{ $item->id }}" role="tabpanel">
                <div class="form-group row">

                    <label for="title" class="col-sm-2 col-form-label"> {{ _i('title') }}
                    </label>

                    <div class="col-sm-10">
                        <input type="text" {{ $disabled }} required name="title[{{ $item['code'] }}]"
                            {{ $disabled }} value="@php
                                if (!empty($offer->title->{$item->code})) {
                                    echo $offer->title->{$item->code};
                                }
                            @endphp" class='form-control '>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> {{ _i('Description') }}
                    </label>

                    <div class="col-sm-10">
                        <textarea name="description[{{ $item['code'] }}]" {{ $disabled }}
                            class='form-control'>@php
                                if (!empty($offer->description->{$item->code})) {
                                    echo $offer->description->{$item->code};
                                }
                            @endphp</textarea>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Reason') }} </label>
    <div class="col-sm-10">
        <textarea name="reason" class='form-control' {{ $disabled }}>{{ $offer->reason  }}</textarea>
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


<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
		<div class="input-group">
		<input class="form-control" type="number"  min="1" name="bonus"  value="{{ $offer->bonus }}">
		<span class="input-group-addon" id="basic-addon3">
			{{ get_default_currency()->code }}

		</span>
		</div>

    </div>

    <label class="col-sm-2 col-form-label"> {{ _i('User Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" name="user_limit" class='form-control' value="{{$offer->user_times}}" required min="1">
    </div>
	<label class="col-sm-2 col-form-label"> {{ _i('Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" name="using_times" class='form-control' {{ $disabled }}  value="{{$offer->offer_limit}}" required min="1">
    </div>
</div>



<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
    </div>
</div>
