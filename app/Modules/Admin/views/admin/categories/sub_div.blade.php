
<div class="form-group child" data-fordelete="{{ $child->id }}"
    style="@if (session('adminlang') == "en")padding-left:{{ $padding }}px !important; @else padding-right:{{ $padding }}px!important; @endif ">
    {{-- <lable style="width: 7%"> {{$child->parent_id}} : --}}
    {{-- {{\App\Category::find($child->parent_id)->translation ?\App\Category::find($child->parent_id)->translation->title : ''}} --}}
    {{-- </lable> --}}
	<input type="hidden" class="p_sort my_sort" id='sort_{{ $child->id }}'
			value="{{ $child->number }}" name='parent_sort[{{ $child->parent_id }}]'>
    <div class="input-group mb-3 subCategory">
        <input style="height:  40px" type="text" value='{{ $child->title  }}'
            class="form-control @if($child->lang_id != \App\Bll\Lang::getSelectedLangId()) is-invalid @endif" name="category[{{ $child->parent_id }}][{{ $child->id }}]" required=""
            >
        <input type="hidden" class="c_sort my_sort" value="{{ $child->number }}"
            name="sort[{{ $child->id }}][{{ $child->id }}]">
        <div class="input-group-append" id="child.id" style="width: 50%">
            <button class="btn btn-default up" type="button" onclick="up(this,{{ $child->id }})"><i
                    class="ti-angle-up"></i></button>
            <button class="btn btn-default down" type="button" onclick="down(this,{{ $child->id }})"><i
                    class="ti-angle-down"></i></button>
            <button class="btn btn-danger delete" type="button" data-del='1'
                onclick="subdel(this, {{ $child->id }})"><i class="ti-close"></i></button>
            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"
                title="{{ _i('Translation') }}">
                <span class="ti ti-settings"></span>
            </button>
            <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; ">
                @foreach ($languages as $lang)
                    <li><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex"
                            data-id="{{ $child->id }}" data-lang="{{ $lang->id }}"
                            style="display: block; padding: 5px 10px 10px;">{{ $lang->title }}</a></li>
                @endforeach
            </ul>
            <button class="btn btn-primary btn-sm add-category-v2" data-id="{{ $child->id }}"
                onclick="addCategoryV2(event,this)">
                <i class="ti ti-plus"></i>
            </button>
            <a href="{{ route('category.features', $child->id) }}" class="btn btn-info btn-sm">
                <i class="ti  ti-wand"></i>
            </a>
            @empty($child->image)
                <label for="file-upload-{{ $child->id }}" class="custom-file-upload btn btn-default mr-1">
                    <i class="fa fa-cloud-upload"></i> {{ _i('Image') }}
                </label>
            @else
                <label for="file-upload-{{ $child->id }}"
                    class="custom-file-upload btn btn-default mr-1 category-image-label">
                    <img src="{{ asset($child->image) }}" alt="" class='category-image'>
                </label>
            @endempty
            <input id="file-upload-{{ $child->id }}" name='sub_images[{{ $child->id }}]' type="file"
                accept='image/*' class='file-upload ajax-upload' data-id='{{ $child->id }}'>

        </div>
	</div>
</div>
