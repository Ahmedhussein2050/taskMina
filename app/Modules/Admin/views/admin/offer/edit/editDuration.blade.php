<input type="hidden" name="type" value="duration">


<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" {{ $disabled }} class='form-control' value="{!! $offer->title->{getLangCode()} !!}"
            required>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Date from') }} </label>
    <div class="col-sm-4">
        <input name="date_from" {{ $disabled }} value="{{ date('Y-m-d\TH:i', strtotime($offer->start_date)) }}"
            required type="datetime-local" class="form-control">
    </div>
    <div class="col-sm-1">
        {{ _i('to') }}
    </div>
    <div class="col-sm-4">

        <input name="date_to" required {{ $disabled }} type="datetime-local" class="form-control"
         value="{{ date('Y-m-d\TH:i', strtotime($offer->end_date)) }}">

    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" {{ $disabled }} name="using_times" min="0" max="200"
            value="{{ $offer->offer_limit }}" oninput="$(this).next().html($(this).val())">
        <span>{{ $offer->offer_limit }}</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" id="vol" {{ $disabled }} name="user_times" min="0" max="50"
            value="{{ $offer->user_times }}" oninput="$(this).next().html($(this).val())">
        <span>{{ $offer->user_times }}</span>
    </div>
</div>
<div class="form-group row">
    <div class="col-sm-3">
        <label class="form-check-label custom_check" for="defaultCheck1">
            {{ _i('Min Commission') }}
        </label>
    </div>
    <div class="col-sm-3">
        <label class="form-check-label custom " for="defaultCheck1">
            {{ _i('Max Commission') }}
        </label>
    </div>
    <div class="col-sm-3">
        <label class="form-check-label custom_check" for="defaultCheck1">
            {{ _i('Bonus') }}
        </label>
    </div>
</div>
@include("admin.offer.edit.include.duration_row")
<div class="" id="get_new_data">

</div>


<input class="btn btn-primary  btn-block mt-2" type="submit" value="{{ _i('Save') }}">

@push('js')
    <script>
		var i= 1;
		function myFunction(i) {

		var input1 =  $('#get_new_data-'+i).find("#test").val();
		var input2 =  $('#get_new_data-'+i).find("#test2").val();
        //console.log(input1);
		var url ="{{ route('admin.commition.index')}}"+"?from="+input1 +"&to="+input2+"&view=1";

		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
       width=600,height=400,left=-1000,top=-1000`;

        open(url, 'test', params)
		}
        $('#plus').click(function(event) {
            event.preventDefault();
            // i++;
			  var id=$('.dataa').last().find('#test').data('i');
			  var dd=id+i;

            $('#get_new_data').append(
               ` <div class="form-group row  " id="get_new_data-`+dd+`">
			@include("admin.offer.forms.include.duration_row",["add"=>false])
			<div class="col-sm-1">
				<button type="button"  class=" remove-tr  btn btn-danger"><i class="ion-minus"></i></button>
				   </div>

			 <div class="col-sm-1">

            <button onclick="myFunction(`+dd+`)" id="commession" type="button" class="btn btn-primary"><span class="ti ti-settings"></span></button>
            </div>
		</div>

			` );
        })
        $(document).on('click', '.remove-tr', function() {
            $(this).parent('div').parent().remove();
        });
    </script>
@endpush
