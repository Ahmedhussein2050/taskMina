<ul class="top-level-menu">
	<li>
		<a href="javascript:void(0)" class="first_link">{{ _i('Options') }}</a>
		<ul class="second-level-menu">
			{{-- GROUP FILTER --}}
			<li>
				<a href="javascript:void(0)">
					<i class="icofont icofont-group"></i> {{ _i('Groups') }}</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="groups reload-datatable" data-type="all" data-id="all">
							{{ _i('All Groups') }}
						</a>
					</li>
					@if(count($groups) > 0)
					@foreach($groups as $group)
					<li>
						<a href="javascript:void(0)" class="groups reload-datatable" data-type="group"
							data-id="{{ $group->id }}">{{ $group->title }}</a>
					</li>
					@endforeach
					@endif
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)"><i class="icofont icofont-male"></i>
					{{ _i('Genders') }}</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="gender reload-datatable" data-type="all" data-id="all">
							{{ _i('All Users') }}
						</a>
					</li>
					<li>
						<a href="javascript:void(0)" class="gender reload-datatable" data-type="gender" data-id="male">
							{{ _i('Male') }}
						</a>
					</li>
					<li>
						<a href="javascript:void(0)" class="gender reload-datatable" data-type="gender" data-id="female">
							{{ _i('Female') }}
						</a>
					</li>
				</ul>
			</li>

			{{-- <li>
				<a href="javascript:void(0)">
					<i class="icofont icofont-score-board"></i>
					{{ _i('City') }}
				</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="city reload-datatable" data-type="all"
							data-id="all">{{ _i('All Users') }}
						</a>
					</li>
					@if(!empty($City))
					@foreach($City as $item)
					<li>
						<a href="javascript:void(0)" class="city reload-datatable" data-type="city"
							data-id="{{ $item->id }}">{{ $item->title }}
						</a>
					</li>
					@endforeach
					@endif
				</ul>
			</li> --}}

			<li>
				<a href="javascript:void(0)">
					<i class="icofont icofont-cart"></i>
					{{ _i('purchases') }}
				</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="purchase reload-datatable" data-type="all" data-id="all">{{ _i('All Users') }}</a>
					</li>
					<li>
						<a href="javascript:void(0)" class="purchase reload-datatable" data-type="purchase" data-id="Most">{{ _i('Most Buy') }}</a>
					</li>
					<li>
						<a href="javascript:void(0)" class="purchase reload-datatable" data-type="purchase" data-id="less">{{ _i('Least Buy') }}</a>
					</li>
				</ul>
			</li>

			<li>
				<a href="javascript:void(0)">
					<i class="ti-email"></i> {{ _i('Send') }}
				</a>
				<ul class="third-level-menu">
					<li>
						<a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#send-email"
							data-type="email">{{ _i('Send Email') }}</a>
					</li>
					<li>
						<a href="javascript:void(0)" class="send" data-toggle="modal" data-target="#send-sms"
							data-type="sms">{{ _i('Send Sms') }}</a>
					</li>
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

	.third-level-menu>li {
		height: 30px;
		width: 250px;
		background: #5dd5c4;
	}

	.third-level-menu>li:hover {
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

	.second-level-menu>li {
		position: relative;
		height: 30px;
		background: #5dd5c4;
	}

	.second-level-menu>li:hover {
		background: #CCCCCC;
	}

	.top-level-menu {
		list-style: none;
		padding: 0;
		margin: 0;
	}

	.top-level-menu>li {
		position: relative;
		float: left;
		height: 30px;
		width: 100px;
		margin-right: 15px;
		background: #5dd5c4;
		border-radius: 50px;
	}

	.top-level-menu>li:hover {
		background: #CCCCCC;
	}

	.top-level-menu li:hover>ul {
		/* On hover, display the next level's menu */
		display: inline-block;
		z-index: 99999;
	}

	.top-level-menu a

	/* Apply to all links inside the multi-level menu */
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
