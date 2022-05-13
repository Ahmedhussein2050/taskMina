<input type="hidden" name="type" value="voucher-user-free">
<input type="hidden" name="user_times" value="1">
<input type="hidden" id="idurl" name="id" value="{{ $offer->id  }}">


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
                        <input type="text" required name="title[{{ $item['code'] }}]"  value="{!! $offer->title->{$item->code} !!}" class='form-control '>

                    </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-2 col-form-label"> {{ _i('Description') }}
                </label>

                <div class="col-sm-10">
                <textarea name="description[{{ $item['code'] }}]" class='form-control'> {!! $offer->description->{$item->code} !!}</textarea>
                </div>
                </div>
            </div>
        @endforeach

    </div>

</div>

<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('User Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input type="number" name="user_limit"  class='form-control' value="{{$offer->user_times}}" required min="1">
    </div>
</div>
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Reason') }} </label>
    <div class="col-sm-10">
        <textarea name="reason" class='form-control' {{ $disabled }}>{{$offer->reason }}</textarea>
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
    <div class="col-sm-10">
		<div class="input-group">
		<input class="form-control" type="number"  min="1" name="bonus"  value="{{ $offer->bonus }}">
		<span class="input-group-addon" id="basic-addon3">
			{{ get_default_currency()->code }}

		</span>
		</div>

    </div>
</div>

@include('admin.offer.edit.member')

{{-- <div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
    </div>
</div> --}}
