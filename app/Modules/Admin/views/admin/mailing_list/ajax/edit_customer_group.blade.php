<form id="update_form" method='post' class="j-pro" enctype="multipart/form-data" data-parsley-validate="" style="box-shadow:none; background: none" data-action='{{ route('customers.group.update', $user->id) }}'>
	@csrf
	@method('PATCH')
	<div class="j-unit">
		<div class="j-input">
			<label class="j-icon-left" for="name">
				<i class="icofont icofont-ui-check"></i>
			</label>
			<input type="text" id="name" name="name" placeholder="name" required value='{{ $user->name }}' disabled>
		</div>
	</div>
	<div>
		<label for="groups"></label>
		<select name="groups[]" multiple class="selectpicker form-control" id="groups" required>
			<option disabled>{{ _i('Select') }}</option>
			@if(count($groups) > 0)
				@foreach($groups as $group)
					<option value="{{ $group->id }}" {{ in_array($group->id, $user_groups) ? 'selected' : '' }}>{{ $group->title }}</option>
				@endforeach
			@else
				{{ _i('NO Users') }}
			@endif
		</select>
	</div>
</form>