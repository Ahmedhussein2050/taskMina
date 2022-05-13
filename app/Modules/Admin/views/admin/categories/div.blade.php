<div class="form-group parent" data-cat-id="category.id" data-fordelete="{{ $id }}">
	<div class="input-group mb-3">
		<div class="btn collapseToggle btn-secondary p-2"><i class="ti-angle-double-up m-0"></i></div>
		<input type="text" value="{{ $category->title }}"
			class="form-control input mainCategoryName  @if($category->lang_id != \App\Bll\Lang::getSelectedLangId()) is-invalid @endif" data-category_id="{{ $id }}"
			name="parentCategory[{{ $id }}]" required="" >
		<input type="hidden" class="p_sort my_sort" id='sort_{{ $id }}'
			value="{{ $category->number }}" name='parent_sort[{{ $id }}]'>

		<input type="hidden" class="type" name="type" value="{{ $id }}">
		<div class="input-group-append">
			<button type="button" class="btn btn-default up"
				onclick="moveMasterUp(this,{{ $id }})"><i
					class="ti-angle-up"></i></button>
			<button type="button" class="btn btn-default down"
				onclick="moveMasterDown(this,{{ $id }})"><i
					class="ti-angle-down"></i></button>
			<button type="button" data-del='1' class="btn btn-danger delete"
				onclick="categorydel(this,{{ $id }})"><i
					class="ti-close"></i></button>
			<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
				title="{{ _i('Translation') }}">
				<span class="ti ti-settings"></span>
			</button>
			<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; ">
				@foreach ($languages as $lang)
					<li><a href="#" data-toggle="modal" data-target="#langedit"
							class="lang_ex" data-id="{{ $id }}"
							data-lang="{{ $lang->id }}"
							style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a>
					</li>
				@endforeach
			</ul>

			<button class="btn btn-primary btn-sm add-category-v2" data-id="{{ $id }}"
				onclick="addCategoryV2(event,this)">
				<i class="ti ti-plus"></i>
			</button>
			<a href="{{ route('category.features', $id) }}"
				class="btn btn-info btn-sm">
				<i class="ti  ti-wand"></i>
			</a>

			<button class="btn btn-info btn-sm " onclick="saveMainCategoryV2(event,this)">
				<i class="ti ti-save"> </i>
			</button>
		</div>
		@empty($category->image)
			<label for="file-upload-{{ $id }}"
				class="custom-file-upload btn btn-default mr-1">
				<i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
			</label>
		@else
			<div class="dropdown mr-1" hidden>
				<button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
					data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					{{ _i('Change image') }}
				</button>
				<div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
					<a class="dropdown-item" href="#">{{ _i('View image') }}</a>
					<a class="dropdown-item" href="#"><label
							for="file-upload-{{ $id }}">{{ _i('Change image') }}</label></a>
				</div>
			</div>
			<label for="file-upload-{{ $id }}"
				class="custom-file-upload btn btn-default mr-1 category-image-label">
				<img src="{{ asset($category->image) }}" alt="" class='category-image'>
			</label>
		@endempty
		<input id="file-upload-{{ $id }}" name='parent_images[{{ $id }}]'
			type="file" accept='image/*' class='file-upload ajax-upload'
			data-id='{{ $id }}'>
	</div>
</div>
