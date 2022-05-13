<div class="table-responsive">
	<table id="reportsTable"
		class="table  table-striped table-bordered display responsive nowrap"
		style="width:100%">
		<thead>
			<tr>
				<th>{{ _i('Date') }}</th>
				<th>{{ _i('Status') }}</th>
				<th>{{ _i('Comment') }}</th>

			</tr>
		</thead>
		<tbody>

			@foreach ($order->state as $status)
				<tr>

					<td>{{ $status->pivot->created_at }} </td>
					<td>{{ $status->data->where('lang_id', getLang())->first()->title }}
					</td>
					<td>{{ $status->pivot->comment }}</td>

				</tr>
			@endforeach


		</tbody>

	</table>
</div>
