@extends('admin.layout.index',[
'title' => _i('Products'),
'subtitle' => _i('Products'),
'activePageName' => _i('Products'),
'activePageUrl' => '',
'additionalPageUrl' => '' ,
'additionalPageName' => '',
] )

@section('content')
    <!-- Page-header end -->
    <!-- Page-body start -->
    <div class="page-body">
        <!-- Blog-card start -->
        <div class="card">

            <div class="card-title">
                <h5>{{ _i('Edit Product') }}</h5>
            </div>

            <div class="card-block">
                <form id="edit_form" action="{{ route('products.update', $product->id) }}" method="POST"
                    class="form-horizontal" enctype="multipart/form-data" data-parsley-validate=""
                    style="box-shadow:none; background: none">
                    @csrf
                    @foreach ($attributes as $attribute)
                        <div class="row form-group" data-content="attributes">

                            <label for=""
                                class="col-sm-2 col-form-label {{ $attribute->required == 1 ? 'text-danger' : '' }} ">
                                {{ $attribute->Data->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()? $attribute->Data->where('lang_id', App\Bll\Lang::getSelectedLangId())->first()->title: $attribute->Data->first()->title }}{{ $attribute->required == 1 ? '*' : '' }}</label>
                            {{-- <div class="col-sm-2 col-form-label"> --}}
                            <select class="form-control selectpicker attribute  col-sm-8" data-live-search="true"
                                name="attribute[{{ $attribute->id }}]" {{ $attribute->required == 1 ? 'reqtired' : '' }}>
                                <option value="">{{ _i('Select Option') }}</option>
                                @foreach ($attribute->Options as $option)
                                    <option value="{{ $option->id }}" {{$option->value && $option->value->option_id == $option->id ?'selected' : '' }}>{{ $option->translation->title }}</option>
                                @endforeach
                            </select>
                            {{-- </div> --}}
                        </div>
                    @endforeach

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="price">
                            <i class="icofont icofont-ui-v-card"></i>
                            {{ _i(' Price:') }}
                        </label>
                        <input class="form-control col-sm-8" value="{{ $product->price }}" type="text" step=".01"
                            id="price" name="price" placeholder="Price" required>
                        <span class="text-danger">
                            <strong id="price-error"></strong>
                        </span>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="price">
                            <i class="icofont icofont-ui-v-card"></i>
                            {{ _i('Related Products') }}
                        </label>
                        <input class="form-control col-sm-8" value="{{ $product->related }}" type="text" id="related" name="related" placeholder="{{_i('Related Products')}}" required>
                        <span class="text-danger">
                            <strong id="related-eerror"></strong>
                        </span>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label" for="tags">
                            <i class="icofont icofont-ui-clip-board"></i>
                            {{ _i(' Tags:') }}
                        </label>
                        <textarea placeholder="{{ _i('tags') }}" id="tags1" class="form-control col-sm-8"
                            name="tags">{{ $product->tags }}</textarea>

                        <span class="text-danger">
                            <strong id="tags-error"></strong>
                        </span>
                    </div>
                    @foreach ($categories as $levelCategories)
                        <div class="form-group row">
                            <label for="" class="col-sm-2 col-form-label">
                                {{ _i('Choose category:') }}
                            </label>
                            <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                                name="category[]">
                                <option disabled selected value="-1">
                                    {{ 'Categories from level: ' . $levelCategories->first()->level }}</option>
                                @foreach ($levelCategories as $category)
                                    <?php
                                    $title = '';
                                    if ($category->data) {
                                        if ($category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()) {
                                            $title = $category->data->where('lang_id', \App\Bll\Lang::getSelectedLangId())->first()->title;
                                        }

                                        # code...
                                    } else {
                                        $title = $category->data->first()['title'];
                                    } ?>
                                    <option value="{{ $category->id }}"
                                        {{ $cats->where('level', $category->level)->first()? ($cats->where('level', $category->level)->first()->id == $category->id? 'Selected': ''): '' }}>
                                        {{ $title ?: 'title not translated' }}</option>
                                @endforeach
                            </select>
                            <span class="text-danger">
                                <strong id="category_id-error"></strong>
                            </span>
                        </div>
                    @endforeach

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            {{ _i('Choose Brand:') }}
                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                            name="brand_id">
                            <option disabled selected value="-1">
                                {{ _i('Brand: ') }}</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}"
                                    {{ $brand->id == $product->brand_id ? 'Selected' : '' }}>
                                    {{ $brand->name ?: 'name not translated' }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="brand_id-error"></strong>
                        </span>
                    </div>
                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            {{ _i('Choose Class:') }}
                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                            name="class_id">
                            <option disabled selected value="-1">
                                {{ _i('Class: ') }}</option>
                            @foreach ($classifications as $class)
                                <option value="{{ $class->id }}"
                                    {{ $class->id == $product->classification_id ? 'Selected' : '' }}>
                                    {{ $class->title ?: 'title not translated' }}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">
                            <strong id="class_id-error"></strong>
                        </span>
                    </div>

                    <div class="form-group row">
                        <label for="" class="col-sm-2 col-form-label">
                            {{ _i('Choose:') }}
                        </label>
                        <select class="form-control selectpicker category_id col-sm-8" data-live-search="true"
                            name="status">
                            <option disabled selected value="-1">
                                {{ _i('Availability: ') }}</option>
                            <option
                                value="available" {{$product->hidden == 0? 'Selected': ''}}>{{ _i('Available') }}</option>
                            <option
                                value="unavailable" {{$product->hidden == 1? 'Selected': ''}}>{{ _i('Unavailable') }}</option>
                        </select>
                        <span class="text-danger">
                            <strong id="status-error"></strong>
                        </span>
                    </div>
                    <div class="form-group row">
                        <label for="exclusive" class="col-sm-2 col-form-label">
                            <i>{{ _i('Exclusive:') }}</i>
                        </label>
                        <input type="checkbox" id="exclusive" name="exclusive" class="my-2"
                            placeholder="exclusive" value="1" {{ $product->exclusive == 1 ? 'checked' : '' }}>
                        <span class="text-danger">
                            <strong id="exclusive-error"></strong>
                        </span>
                    </div>
                    <div class="text-danger">
                        <strong id="create_prod_errors"></strong>
                    </div>
                    <div class="row">
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('SKU') }}">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i>{{ _i('SKU:') }}</i>
                            </label>
                            <div class="form-group">
                                <input value="{{ $product->sku }}" type="text" class="form-control cost mr-2"
                                    id="skuEdit" name="sku" required="" placeholder="{{ _i('SKU') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top"
                            title="{{ _i('REF ID') }}">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i>{{ _i('REF ID:') }}</i>
                            </label>
                            <div class="form-group">
                                <input value="{{ $product->refid }}" type="text" class=" form-control price mr-2"
                                    id="refidEdit" name="refid" required="" placeholder="{{ _i('REF ID') }}">
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <div class="j-unit">

                        <div class="col-md-6 pr-0" data-toggle="tooltip" data-placement="top" title="{{ _i('Image') }}">
                            <label for="exclusive" class="col-sm-2 col-form-label">
                                <i>{{ _i('Image:') }}</i>
                            </label>
                            <div class="form-group">
                                <input type="file" class="form-control cost mr-2" name="image" id="image"
                                    placeholder="{{ _i('Photo') }}">
                                <img class="img-fluid" src="{{ asset($product->image) }}" alt="">
                                <div class="clearfix"></div>
                            </div>
                        </div>

                    </div>
                    <div class="j-unit">
                        <div class="j-input">
                            <label class="j-icon-left" for="title">
                                <i class="icofont icofont-ui-video-play"></i>
                            </label>
                            <textarea placeholder="{{ _i('Video') }}" id="video" class="form-control" name="video"></textarea>
                        </div>
                        <span class="text-danger">
                            <strong id="description-error"></strong>
                        </span>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">{{ _i('Save') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).on('submit', '#edit_form', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                }
            });
            $.ajax({
                url: url,
                method: "post",
                datatype: 'json',
                data: new FormData(this),
                contentType: false,
                processData: false,
                success: function(res) {
                    if (res.errors) {
                        if (res.errors) {
                            if (res.errors.title) {
                                $('#title-error').html(res.errors.title[0]);
                            }
                            if (res.errors.category_id) {
                                $('#category_id-error').html(res.errors.category_id[0]);
                            }
                            if (res.errors.status) {
                                $('#status-error').html(res.errors.status[0]);
                            }
                            if (res.errors.sku) {
                                $('#create_prod_errors').html(res.errors.sku[0])
                            }
                            if (res.errors.refid) {
                                $('#create_prod_errors').html(res.errors.refid[0])
                            }
                        }
                    }
                    if (res === 'success') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Updated Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                    }
                }
            });
        })
    </script>
@endpush
