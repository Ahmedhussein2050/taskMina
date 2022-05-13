<ul class="top-level-menu">
	<li>
		<a href="javascript:void(0)" class="first_link">{{ _i('Options') }}</a>
		<ul class="second-level-menu">
			<li>
				<a href="javascript:void(0)"><i
						class="icofont icofont-group"></i> {{ _i('Lists') }}</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id="0">{{ _i('All Lists') }}</a>
					</li>
					@if(count($lists) > 0)
						@foreach($lists as $list)
							<li>
								<a href="javascript:void(0)" class="groups reload-datatable" data-type="group" data-id="{{ $list->id }}">
									{{ $list->name }}
								</a>
							</li>
						@endforeach
					@endif
				</ul>
			</li>





		</ul>
	</li>
</ul>


@push('css')
	<style>
		.first_link:after {
			content: "\e64b";
			font-family: themify;
			margin-left: 10px;
		}
		.third-level-menu {
			position: absolute;
			top: 0;
			left: -250px;
			width: 150px;
			list-style: none;
			padding: 0;
			margin: 0;
			display: none;
		}
		.third-level-menu > li {
			height: 30px;
			width: 250px;
			background: #5dd5c4;
		}
		.third-level-menu > li:hover {
			background: #CCCCCC;
		}
		.second-level-menu {
			position: absolute;
			top: 30px;
			right: 0;
			width: 150px;
			list-style: none;
			padding: 0;
			margin: 0;
			display: none;
		}
		.second-level-menu > li {
			position: relative;
			height: 30px;
			background: #5dd5c4;
		}
		.second-level-menu > li:hover {
			background: #CCCCCC;
		}
		.top-level-menu {
			list-style: none;
			padding: 0;
			margin: 0;
		}
		.top-level-menu > li {
			position: relative;
			float: left;
			height: 30px;
			width: 100px;
			margin-right: 15px;
			background: #5dd5c4;
			border-radius: 50px;
		}
		.top-level-menu > li:hover {
			background: #CCCCCC;
		}
		.top-level-menu li:hover > ul {
			/* On hover, display the next level's menu */
			display: inline-block;
			z-index: 99999;
		}
		/* Menu Link Styles */

		.top-level-menu a /* Apply to all links inside the multi-level menu */
		{
			font: bold 14px Arial, Helvetica, sans-serif;
			color: #FFFFFF;
			text-decoration: none;
			padding: 0 0 0 10px;

			/* Make the link cover the entire list item-container */
			display: block;
			line-height: 30px;
		}
		.top-level-menu a:hover {
			color: #000000;
		}
	</style>
@endpush
@push('js')
	<script>
		$('.send').on('click', function () {
			var type = $(this).data('type');
			$('.type').val(type);
		});
	</script>
@endpush
