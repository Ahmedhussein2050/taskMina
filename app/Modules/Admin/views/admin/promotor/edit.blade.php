<div class="modal fade" id="edit-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">{{ _i('Edit Promotor') }}</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method='post' action='' id='edit-form'>
				@csrf

				<div class="modal-body">
					 <input type="text" name="namee" id="name" value="" class="form-control" required>
				</div>
				<div class="modal-body">
					<input type="email" name="emaill" id="email" value="" class="form-control" required>
			   </div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-info modal-edit-btn"   form='edit-form'>{{ _i('Update') }}</button>
				</div>
			</form>
		</div>
	</div>
</div>
