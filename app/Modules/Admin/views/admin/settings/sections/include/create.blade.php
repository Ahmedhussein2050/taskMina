
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
                    <div class="card-header">
                        <h5>{{ _i('Sections') }}</h5>
                        <form id="form_add" class="form-horizontal" action="{{ url('admin/settings/sections/store') }}"
                            method="POST" data-parsley-validate="" enctype="multipart/form-data">
                            @csrf
                            <div class="box-body">
                                <div class="form-group row " {{ $page_section == 'home' ? 'hidden' : ' ' }}>
                                    <label class="col-sm-3 col-form-label">{{ _i(' Category Master') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker categories" name="mastercategory"
                                            id="cate_id" data-live-search="true" data-actions-box="true"
                                            title='{{ _i('Select Categories') }}'
                                            {{ $page_section == 'home' ? '' : 'required' }}>

                                            @foreach ($parent_cats as $key => $val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ _i('Title') }} <span
                                            style="color: #F00;">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" class="form-control title" name="title" required=""
                                            placeholder="{{ _i('Place Enter Section Title') }}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Display Title') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="is_title_displayed" value="1"
                                                class='is_title_displayed'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">{{ _i('Description') }}</label>
                                    <div class="col-sm-9">
                                        <textarea class="form-control description" name="description"
                                            placeholder="{{ _i('Place Enter description') }}"></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class=" col-sm-3 col-form-label">{{ _i('Content Type') }} </label>
                                    <div class="col-sm-9">
                                        <select class="form-control type" name="type" id="select">
                                            <option selected disabled><?= _i('Select Type') ?></option>
                                            {{-- <option value="latest_products" selected>{{ _i('Latest Products') }}</option> --}}
                                            <option value="best_selling_products">{{ _i('Best Selling Products') }}
                                            </option>

                                            <option value="random_products">{{ _i('Random Products') }}</option>
                                            <option value="banner">{{ _i('Banner') }}</option>
                                            <option value="banner2">{{ _i('Banner2') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row categories">
                                    <label class="col-sm-3 col-form-label">{{ _i('Categories') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control selectpicker categories" name="categories[]"
                                            id="cate_id" data-live-search="true" multiple data-actions-box="true"
                                            title='{{ _i('Select Categories') }}'>

                                            @foreach ($categories as $key => $val)
                                                <option value="{{ $key }}">{{ $val }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row success_Products" hidden>
                                    <label class="col-sm-3 col-form-label">{{ _i('Products') }}</label>
                                    <div class="col-sm-9">
                                        <select class="form-control myselecttt" name="products[]" data-live-search="true"
                                            multiple>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row productsTotal">
                                    <label class=" col-sm-3 col-form-label">{{ _i('Total Products') }}</label>
                                    <div class="col-sm-9">
                                        <input type="number" min="1" value="10" class="form-control total" name="total"
                                            required placeholder="{{ _i('Place Enter Total Products') }}">
                                    </div>
                                </div>
                                <div class="form-group row image_video" hidden>
                                    <label class="col-sm-3 col-form-label" for="image">{{ _i('Image') }}</label>
                                    <div class="col-sm-9">
                                        <input type="file" name="image" class="btn btn-default image" accept="image/*">
                                        <span class="text-danger invalid-feedback">
                                            <strong>{{ $errors->first('image') }}</strong>
                                        </span>
                                    </div>
                                </div>
                                <div class="form-group row image_video" hidden>
                                    <label class="col-sm-3 col-form-label" for="video">{{ _i('Video') }}</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="video" class="form-control video"
                                            placeholder="{{ _i('Youtube Link') }}">
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
                                                <option value="{{ $banner->id }}">{{ $banner->title }}</option>
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
                                                <option value="{{ $banner->id }}">{{ $banner->title }}</option>
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
                                            placeholder="{{ _i('Place Enter Section Order') }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="checkbox">
                                        {{ _i('Publish') }}
                                    </label>
                                    <div class="checkbox-fade fade-in-primary col-sm-6">
                                        <label>
                                            <input type="checkbox" name="published" value="1" class='checkbox'>
                                            <span class="cr">
                                                <i class="cr-icon icofont icofont-ui-check txt-primary"></i>
                                            </span>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">

                                <button class="btn btn-info" type="submit" id="s_form_1"> {{ _i('Save') }} </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endsection


    @push('js')
        <script>
            $(document).ready(function() {
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

                $(document).on('change', '.type', function() {
                    var _val = $(this).val();
                    $('.products').hide();
                    $('.image_video').hide();
                    $('.banner').hide();
                    $('.banner2').hide();
                    $('.banner3').hide();
                    $('.services').hide();
                    $(".success_Products").hide();
                    $('.success_partners').hide();
                    $('.categories').prop('hidden', true);


					//clear all
					$("select[name='categories[]']").val("");
					$("select[name='categories[]']").selectpicker('refresh');

					$("select[name='products[]']").val("");
					$("select[name='products[]']").selectpicker('refresh');

					$("select[name='banners[]']").val("");
					$("select[name='banners[]']").selectpicker('refresh');

					$("select[name='image']").val("");
					$("select[name='video']").val("");
					$("select[name='banners']").val("");



                    if (_val == 'image_video') {
                        $('.image_video').removeAttr('hidden').show();

                    } else if (_val == 'banner') {
                        $('.banner').removeAttr('hidden').show();
                        $('.productsTotal').prop('hidden', true);

                    } else if (_val == 'banner2') {
                        $('.banner').removeAttr('hidden').show();
                        $('.banner2').removeAttr('hidden').show();

                    } else if (_val == 'banner3') {
                        $('.banner').removeAttr('hidden').show();
                        $('.banner2').removeAttr('hidden').show();
                        $('.banner3').removeAttr('hidden').show();


                    } else if (_val == 'services') {
                        $('.services').removeAttr('hidden').show();

                    } else if (_val == 'success_partners') {
                        $('.success_partners').removeAttr('hidden').show();

                    } else if (_val == 'random_products') {
                        $('.success_Products').removeAttr('hidden').show();
                        $('.productsTotal').prop('hidden', true);


                    } else if (_val == 'latest_products') {
                        $('.productsTotal').removeAttr('hidden').show();
                        $('.categories').removeAttr('hidden').show();

                    } else if (_val == 'best_selling_products') {
                        $('.productsTotal').removeAttr('hidden').show();
                        $('.categories').removeAttr('hidden').show();


                    } else if (_val == 'most_visited_products') {
                        $('.categories').removeAttr('hidden').show();
                        $('.productsTotal').removeAttr('hidden').show();


                    } else {
                        $('.products').removeAttr('hidden').show();

                    }
                })




                // $(document).on('change', '.type', function() {
                //     // console.log($(this).val());
                //     let type = $(this).val();
                //     if (type == 'banner' || type == 'banner2' || type == 'banner3' || type == 'image_video') {
                //         $('.productsTotal').hide();
                //     } else {
                //         $('.productsTotal').show();
                //     }
                // })


                // $(document).on('click', '.add-permissiont', function(e) {
                //     $.ajax({
                //         type: "GET",
                //         url: "{{ url('admin/settings/sections/autocomplete') }}",
                //         dataType: 'json',
                //         delay: 250,

                //         success: function(response) {
                //             //console.log(response.data);

                //             $.each(response.data, function(key, value) {
                //                 console.log(value);

                //                 $('#make_select1').append('<option>' + value.title +
                //                     '</option>')

                //             })

                //         },
                //         error: function() {

                //         }
                //     });
                // })



                // $('#model_select').selectpicker('refresh');
            });


            $(function() {
                $('#form_add').submit(function(e) {
                    //	debugger;
                    e.preventDefault();
                    $.ajax({
                        url: "{{ url('admin/settings/sections/store') . '/' . $page_section }}",
                        type: "POST",
                        "_token": "{{ csrf_token() }}",
                        data: new FormData(this),
                        dataType: 'json',
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function(response) {
                            //	debugger;

                            if (response.errors) {
                                $('#masages_model').empty();
                                $.each(response.errors, function(index, value) {
                                    $('#masages_model').show();
                                    $('#masages_model').append(value + "<br>");
                                });
                            }
                            if (response == 'SUCCESS') {
                                new Noty({
                                    type: 'success',
                                    layout: 'topRight',
                                    text: "{{ _i('Saved Successfully') }}",
                                    timeout: 2000,
                                    killer: true
                                }).show();


                                $('#lang_add').val("");
                                $('#title_add').val("");
                                $('#link_add').val("");
                                $('#image_add').val("");
                                $('#checkbox').val("");
                                $('#description_add').val("");
                            }
                        }
                    });
                });
            });
        </script>
    @endpush
