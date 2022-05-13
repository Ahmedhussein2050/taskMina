<input type="hidden" name="type" value="duration">
<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Title') }} <span style="color: #F00;">*</span></label>
    <div class="col-sm-10">
        <input type="text" name="title" class='form-control' value="{{ old('title') }}" required>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Date from') }} </label>
    <div class="col-sm-4">
        <input name="start_date" required type="datetime-local" class="form-control" value="{{ old('date_from') }}">
    </div>
    <div class="col-sm-1">
        {{ _i('to') }}
    </div>
    <div class="col-sm-4">

        <input name="end_date" required type="datetime-local" class="form-control" value="{{ old('date_to') }}">
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing Using Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" name="using_times" min="0" max="200" oninput="$(this).next().html($(this).val())" value="{{ old('date_from') }}">
        <span>100</span>
    </div>
</div>

<div class="form-group row">
    <label for="title" class="col-sm-2 col-form-label"> {{ _i('Allowing User Times') }}
    </label>
    <div class="col-sm-10">
        <input type="range" id="vol" value="1" name="user_times" min="0" max="50"
            oninput="$(this).next().html($(this).val())">
        <span>1</span>
    </div>
</div>

<div class="form-group row">
    <div class="col-sm-3">
        <label class="form-check-label custom_check" for="defaultCheck1">
            {{ _i(' Min  Commission') }}
        </label>
    </div>
    <div class="col-sm-3">
        <label class="form-check-label custom_check" for="defaultCheck1">
            {{ _i('Max  Commission') }}
        </label>
    </div>
    <div class="col-sm-3">
        <label class="form-check-label custom_check" for="defaultCheck1">
            {{ _i(' Bonus') }}
        </label>
    </div>

</div>
{{-- @include("admin.offer.forms.include.duration_row", ["add"=>true ]) --}}
@if (is_array(old('minumim')))


    @for ($i = 0; $i < count(old('minumim')); $i++)

        <div class="form-group row">
            @include("admin.offer.forms.include.duration_row",["index" => $i])

            @if ($i == 0)
                <div class="col-sm-1">
                    <button id="plus" class="btn btn-success"><i class="ion-plus-round"></i></button>
                </div>
            @else
			<button type="button" class=" remove-tr btn btn-danger"><i class="ion-minus"></i></button>
         @endif

        </div>
    @endfor
@else
    <div class="form-group row" id="get_new_data-1">
        @include("admin.offer.forms.include.duration_row")
        <div class="col-sm-1">
            <button id="pluss" class="btn btn-success"><i class="ion-plus-round"></i></button>
        </div>
	 <div class="col-sm-1">

		  <button onclick="myFunction(1)" id="commession" type="button" class="btn btn-primary"><span class="ti ti-settings"></span></button>
 		</div>

    </div>
@endif
<div class="form-group row" id="get_new_dataa">

</div>

<input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">
@push('js')
   <script>

	    var i= 1;
		function myFunction(i) {

		var input1 =  $('#get_new_data-'+i).find("#test").val();
		var input2 =  $('#get_new_data-'+i).find("#test2").val();

		var url ="{{ route('admin.commition.index')}}"+"?from="+input1 +"&to="+input2;
		// window.open(url);
		let params = `scrollbars=no,resizable=no,status=no,location=no,toolbar=no,menubar=no,
       width=0,height=0,left=-1000,top=-1000`;

        open(url, 'test', params)
		}
		 $('#pluss').click(function(event) {
            event.preventDefault();
             i++;

            $('#get_new_dataa').append(
                `
				<div class="form-group row  " id="get_new_data-`+i+`">
						@include("admin.offer.forms.include.duration_row")
                    <button type="button"  class=" remove-tr  btn btn-danger"><i class="ion-minus"></i></button>
					<div class="col-sm-1">
						<button onclick="myFunction(`+i+`)" id="commession" type="button" class="btn btn-primary"><span class="ti ti-settings"></span></button>

				   </div>

				</div>
			`
            );
        })

	// $('body').on('click', '#exampleModal', function (e) {


	// 	var input1 =$('#test').val();
	// 	var input2 =$('#test2').val();
	// 	var url ="{{ route('admin.commition.index')}}"+"?from="+input1 +"&to="+input2;
    //     $('#comm_id').attr('href', url)
	// 	// alert(input1);
	// });

        $(document).on('click', '.remove-tr', function() {
            $(this).parent('div').remove();
        });
    </script>
@endpush
