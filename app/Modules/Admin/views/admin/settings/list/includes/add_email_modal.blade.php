<div class="modal fade bd-example-modal-lg" id="add-email-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Add New Item') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form id="add-email-form" class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none">
					@csrf
					<div class="j-unit">
						<div class="j-input">
							<label class="j-icon-left" for="email">
								<i class="icofont icofont-ui-check"></i>
							</label>
							<input type="text" id="name" name="name" placeholder="{{ _i('Name') }}" required>
						</div>
						<span class="text-danger">
							<strong id="email-error"></strong>
						</span>
					</div>
					<div class='m-b-25'>
						<label for="lists"></label>
						<select name="lists"   class="selectpicker form-control" id="lists" title='{{ _i('Please Select List') }}'>
								@foreach($lists as $list)
									<option value="{{ $list->id }}">{{ $list->name }}</option>
								@endforeach
						</select>
					</div>

					{{-- <div class='m-b-25'>
						<label for="type"></label>
						<select name="type" class="selectpicker type form-control" id="type" title='{{ _i('Please Select Type') }}'>
									<option value="category">{{_i('Category')}}</option>
									<option value="link">{{_i('Link')}}</option>
						</select>
					</div> --}}
                    {{-- <div class='m-b-25 category_field'>
						<label for="category_id"></label>
                        <select name="category_id" class="selectpicker   form-control"   title='{{ _i('Please   SelectCategory') }}'>
                           @foreach ($categories as $cat)
                           <option value='{{ $cat->id  }}'>{{ $cat->title  }}</option>

                           @endforeach

                         </select>
                     </div> --}}

                    <div class="j-unit link_field">
                        <div class="j-input">
                            <label class="j-icon-left" for="email">
                                <i class="icofont icofont-link"></i>
                            </label>
                            <input type="text" id="link" name="link" placeholder="{{ _i('link') }}" required>
                        </div>
                        <span class="text-danger">
							<strong id="email-error"></strong>
						</span>
                    </div>


                </form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">{{ _i('Close') }}</button>
				<button type="submit" form="add-email-form" class="btn btn-primary">{{ _i('Save') }}</button>
			</div>
		</div>
	</div>
</div>

@push('css')
	<link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/demo.css')}}">
	<link rel="stylesheet" href="{{asset('AdminFlatAble/pages/j-pro/css/j-pro-modern.css')}}">
	<style>
		.j-pro {
			border: none;
		}
		.j-pro .j-primary-btn, .j-pro .j-file-button, .j-pro .j-secondary-btn {
			background: #1abc9c;
		}
		.j-pro .j-primary-btn:hover, .j-pro .j-file-button:hover, .j-pro .j-secondary-btn:hover {
			background: #1abc9c;
		}
		.j-pro input[type="text"]:focus, .j-pro input[type="password"]:focus, .j-pro input[type="email"]:focus, .j-pro input[type="search"]:focus, .j-pro input[type="url"]:focus, .j-pro textarea:focus, .j-pro select:focus {
			border: #1abc9c solid 2px !important;
		}
		.j-pro input[type="text"]:hover, .j-pro input[type="password"]:hover, .j-pro input[type="email"]:hover, .j-pro input[type="search"]:hover, .j-pro input[type="url"]:hover, .j-pro textarea:hover, .j-pro select:hover {
			border: #1abc9c solid 2px !important;
		}
		.card .card-header span {
			color: #fff;
		}
		.j-pro .j-tooltip, .j-pro .j-tooltip-image {
			background-color: #1abc9c;
		}
		.j-pro .j-tooltip-right-top:before {
			border-color: #1abc9c transparent;
		}
	</style>
	<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.2.2.4.min.js')}}"></script>
	<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.maskedinput.min.js')}}"></script>
	<script src="{{asset('AdminFlatAble/pages/j-pro/js/jquery.j-pro.js')}}"></script>

@endpush

@push('js')
    <script>



        $('select[name=type]').change(function(){
            console.log('dfcedc')
            if($(this).val()=='link') {
                console.log('link')
                $('.category_field').hide();
                $('.link_field').show();
            } else if($(this).val()=='category') {
                $('.category_field').show();
                $('.link_field').hide();
            }
            else{
                $('.link_field').hide();
                $('.category_field').hide();
            }
        });
    </script>


    @endpush
