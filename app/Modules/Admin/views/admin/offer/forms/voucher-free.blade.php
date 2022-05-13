<input type="hidden" name="type" value="voucher-free">


@php
	$title =old('title');
	$desc =old('description');

@endphp
<div class="col-lg-12 col-xl-12">
    <ul class="nav nav-tabs  tabs" role="tablist">
        @foreach ($langs as $item)
            <li class="nav-item">
                <a class="nav-link @if ($loop->first) active @endif"
                    data-toggle="tab" href="#home{{ $item->id }}"  role="tab">{{ $item->title }}</a>
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
                        <input type="text" required value="{{(isset($title))? $title[$item->code] : ''}}" name="title[{{ $item['code'] }}]"   class='form-control '>

                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-2 col-form-label"> {{ _i('Description') }}
                    </label>

                    <div class="col-sm-10">
                        <textarea required="" name="description[{{ $item['code'] }}]" class='form-control'>{{(isset($desc))? $desc[$item->code] : ''}}</textarea>
                    </div>
                </div>
            </div>
        @endforeach

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


<div class="form-group row">
    <label class="col-sm-2 col-form-label"> {{ _i('Bonus') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
		<div class="input-group">
		<input class="form-control" type="number"  min="1" name="bonus"  value="{{ old('bonus') }}">
		<span class="input-group-addon" id="basic-addon3">
			{{ get_default_currency()->code }}

		</span>
		</div>

    </div>
	<label class="col-sm-2 col-form-label"> {{ _i('Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" name="using_times" class='form-control' value="{{ old('using_times')?:1 }}" required min="1">
    </div>
    <label class="col-sm-2 col-form-label"> {{ _i('User Limit') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-2">
        <input type="number" name="user_limit" class='form-control' value="{{ old('user_limit')?:1 }}" required min="1">
    </div>
</div>



<div class="form-group row">
    <div class="col-sm-12 text-right">
        <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
    </div>
</div>
