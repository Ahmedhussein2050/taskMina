@extends('admin.layout.index',
[
'title' => _i('Sections'),
'subtitle' => _i('Sections'),
'activePageName' => _i('Sections'),
'activePageUrl' => route('section.index', 'home_sections'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index')
])

@section('content')
    <div class="box-body">
        <div class="row">
            <div class="col-sm-12">

                <div class="card">
                    <div class="modal-body">
                        <form method="post" id="edit_form" class="form-horizontal"  data-parsley-validate=""
                            enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group row " {{ $section->page == 'home' ? 'hidden' : '' }}>
                                    <label class="col-sm-3 col-form-label">{{ _i(' Category Master') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker categories" name="mastercategory"
                                            id="cate_id" data-live-search="true" data-actions-box="true"
                                            title='{{ _i('Select Categories') }}'
                                            {{ $section->page == 'home' ? '' : 'required' }}>

                                            @foreach ($parent_cats as $key => $val)
                                                @if ($master != null && $master->category_id == $key)
                                                    <option value="{{ $key }}" selected>{{ $val }}
                                                    </option>
                                                @else
                                                    <option value="{{ $key }}">{{ $val }}</option>
                                                @endif
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Display Title') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="is_title_displayed"
                                                {{ $section->is_title_displayed == 1 ? 'checked' : '' }}
                                                value="{{ $section->is_title_displayed }}" class='is_title_displayed'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
                                    <div class="col-sm-9">
                                        <select class="form-control type" name="type" disabled>
                                            <option selected disabled><?= _i('Select Type') ?></option>
                                            <option value="latest_products"
                                                {{ $section->type == 'latest_products' ? 'selected' : '' }}>
                                                {{ _i('Latest Products') }}</option>
                                            <option value="best_selling_products"
                                                {{ $section->type == 'best_selling_products' ? 'selected' : '' }}>
                                                {{ _i('Best Selling Products') }}
                                            </option>
                                            <option value="most_visited_products"
                                                {{ $section->type == 'most_visited_products' ? 'selected' : '' }}>
                                                {{ _i('Most Visited Products') }}
                                            </option>
                                            <option value="random_products"
                                                {{ $section->type == 'random_products' ? 'selected' : '' }}>
                                                {{ _i('Random Products') }}</option>
                                            <option value="image_video"
                                                {{ $section->type == 'image_video' ? 'selected' : '' }}>
                                                {{ _i('Image + Video') }}</option>
                                            <option value="banner" {{ $section->type == 'banner' ? 'selected' : '' }}>
                                                {{ _i('Banner') }}</option>
                                            <option value="services"
                                                {{ $section->type == 'services' ? 'selected' : '' }}>
                                                {{ _i('Services') }}</option>
                                            <option value="success_partners"
                                                {{ $section->type == 'success_partners' ? 'selected' : '' }}>
                                                {{ _i('Success partners') }}</option>
                                            @if ($section->page == 'home')
                                                <option value="banner"
                                                    {{ $section->type == 'banner' ? 'selected' : '' }}>
                                                    {{ _i('Banner') }}</option>
                                                <option value="banner2"
                                                    {{ $section->type == 'banner2' ? 'selected' : '' }}>
                                                    {{ _i('Banner2') }}</option>
                                                <option value="banner3"
                                                    {{ $section->type == 'banner3' ? 'selected' : '' }}>
                                                    {{ _i('Banner3') }}</option>
                                            @endif

                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row products">
                                    <label class="col-sm-3 col-form-label">{{ _i('Categories') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker categories" name="categories[]" multiple
                                            data-actions-box="true" title='{{ _i('Select Categories') }}'>
                                            @foreach ($categories as $key => $val)
                                                @if (in_array($key, $SectionCategory))
                                                    <option value="{{ $key }}" selected>{{ $val }}
                                                    </option>
                                                @else
                                                    <option value="{{ $key }}">{{ $val }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row success_Products" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Products') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control myselecttt" name="products[]" data-live-search="true"
                                            multiple>
                                            @foreach ($section->sectionProducts as $product)
                                                @if ($product->detailes != null && $product)
                                                    <option value="{{ $product->id }}" selected>
                                                        {{ $product->detailes->title ?? '' }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row productsTotal "
                                    {{ $section->type == 'random_products' ? 'hidden' : '' }}>
                                    <label class=" col-sm-3 col-form-label"><?= _i('Total Products') ?></label>
                                    <div class="col-sm-9">
                                        <input type="number" min="1" class="form-control total" name="total" required=""
                                            placeholder="{{ _i('Place Enter Total Products') }}"
                                            value="{{ $section->total }}">
                                    </div>
                                </div>
                                <div class="form-group row image_video" hidden>
                                    <label class="col-sm-3 col-form-label" for="image">{{ _i('Image') }}</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image" class="btn btn-default image col-md-6"
                                            accept="image/*">
                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                        <img src="{{ asset($section->image) }}" style="width:136px" alt="">
                                    </div>

                                </div>
                                <div class="form-group row image_video" hidden>
                                    <label class="col-sm-3 col-form-label" for="video">{{ _i('Video') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="video" class="form-control video"
                                            placeholder="{{ _i('Youtube Link') }}"
                                            value="{{ $section->video ?? '' }}">
                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('video') }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row banner" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker banners" name="banners[]"
                                            data-actions-box="true" title='{{ _i('Select Banners') }}'>
                                            @foreach ($banners as $banner)
                                                @if ($bannerss->first() != null && $bannerss->first()->banner_id == $banner->id)
                                                    <option value="{{ $banner->id }}" selected>{{ $banner->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $banner->id }}">{{ $banner->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Banner 2 --}}
                                <div class="form-group row banner2" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker banners" name="banners[]"
                                            data-actions-box="true" title='{{ _i('Select Banners') }}'>
                                            @foreach ($banners as $banner)
                                                @if ($bannerss->skip(1)->first() != null && $bannerss->skip(1)->first()->banner_id == $banner->id)
                                                    <option value="{{ $banner->id }}" selected>{{ $banner->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $banner->id }}">{{ $banner->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- Banner 3 --}}

                                <div class="form-group row banner3" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Banners') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker banners" name="banners[]"
                                            data-actions-box="true" title='{{ _i('Select Banners') }}'>
                                            @foreach ($banners as $banner)
                                                @if ($bannerss->skip(2)->first() != null && $bannerss->skip(2)->first()->banner_id == $banner->id)
                                                    <option value="{{ $banner->id }}" selected>{{ $banner->title }}
                                                    </option>
                                                @else
                                                    <option value="{{ $banner->id }}">{{ $banner->title }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row services" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Services') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker banners" name="banners[]" multiple
                                            data-actions-box="true" title='{{ _i('Select Banners') }}'>
                                            @foreach ($banners as $banner)
                                                <option value="{{ $banner->id }}">{{ $banner->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row services" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Services') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker services" name="services[]" multiple
                                            data-actions-box="true" title='{{ _i('Select services') }}'>
                                            @foreach ($services as $service)
                                                <option value="{{ $service->id }}">{{ $service->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row success_partners" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Success partners') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker partners" name="success_partners[]"
                                            multiple data-actions-box="true" title='{{ _i('Select Partners') }}'>
                                            @foreach ($success_partners as $partner)
                                                <option value="{{ $partner->id }}">{{ $partner->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class=" col-sm-3 col-form-label"><?= _i('Display Order') ?></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control display_order" name="display_order"
                                            placeholder="{{ _i('Place Enter Section Order') }}"
                                            value="{{ $section->display_order }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Publish') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="published"
                                                {{ $section->published == 1 ? 'checked' : '' }}
                                                value="{{ $section->published }}" class='checkbox'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <input type="hidden" name="section_id" class='section_id' value="{{ $section->id }}">

                            </div>
                            <div class="modal-footer">
                                <button class="btn btn-info" type="button" id="test">
                                    {{ _i('Save') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script>
        var typee = '{{ $section->type }}';
        console.log(typee);
        $(document).ready(function(e) {

            $('.myselecttt').select2({
                minimumInputLength: 2,
                placeholder: "{{ _i('Select products') }}",
                ajax: {
                    url: "{{ url('admin/settings/sections/autocomplete') }}",

                    data: function(params) {
                        var query = {
                            q: params.term,
                        }
                        return query;
                    },

                    dataType: 'json',
                    delay: 250,
                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                console.log(item);

                                return {
                                    text: item.title + ' >> ' + item.cat,
                                    id: item.product_id,
                                }
                            })
                        };
                    },
                    cache: true,
                }


            });
            if (typee == 'image_video') {
                $('.image_video').removeAttr('hidden').show();
                $('.products').hide();
                $('.banner').hide();
                $('.services').hide();
                $('.success_partners').hide();
                $('.productsTotal').prop('hidden', true);

            } else if (typee == 'banner') {
                $('.banner').removeAttr('hidden').show();


                $('.products').hide();
                $('.image_video').hide();
                $('.services').hide();
                $('.success_partners').hide();
                $('.productsTotal').prop('hidden', true);


            } else if (typee == 'random_products') {
                $('.success_Products').removeAttr('hidden').show();
                $('.products').hide();
                $('.image_video').hide();
                $('.services').hide();
            } else if (typee == 'banner3') {
                $('.banner').removeAttr('hidden').show();
                $('.banner2').removeAttr('hidden').show();
                $('.banner3').removeAttr('hidden').show();
                $('.productsTotal').prop('hidden', true);

                console.log(typee);

                $('.products').hide();
                $('.image_video').hide();
                $('.services').hide();
                $('.success_partners').hide();
            } else if (typee == 'banner2') {
                $('.banner').removeAttr('hidden').show();
                $('.banner2').removeAttr('hidden').show();
                //console.log(typee);
                $('.productsTotal').prop('hidden', true);

                $('.products').hide();
                $('.image_video').hide();
                $('.services').hide();
                $('.success_partners').hide();
            } else if (typee == 'services') {
                $('.services').removeAttr('hidden').show();
                $('.products').hide();
                $('.image_video').hide();
                $('.banner').hide();
                $('.success_partners').hide();
            } else if (typee == 'success_partners') {
                $('.success_partners').removeAttr('hidden').show();
                $('.products').hide();
                $('.image_video').hide();
                $('.banner').hide();
                $('.services').hide();
            } else {
                $('.products').removeAttr('hidden').show();
                $('.image_video').hide();
                $('.banner').hide();
                $('.services').hide();
                $('.success_partners').hide();
            }



        });

        function showImg(input) {
            var filereader = new FileReader();
            filereader.onload = (e) => {
                console.log(e);
                $("#old_img").attr('src', e.target.result).width(100).height(100);
            };
            console.log(input.files);
            filereader.readAsDataURL(input.files[0]);
        }

        // $(function() {
        $(document).on('click', '#test', function(e) {
            e.preventDefault();
            var form = document.querySelector('#edit_form');
            var formdata =new FormData(form)
            $.ajax({
                url: "{{ url('admin/settings/sections/update') }}",
                method: "post",
               "_token": "{{ csrf_token() }}",
                data: formdata,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response == 'SUCCESS') {
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: "{{ _i('Saved Successfully') }}",
                            timeout: 2000,
                            killer: true
                        }).show();
                        //  location.reload();

                    }
                }
            });
        });
        // });
    </script>
@endpush
