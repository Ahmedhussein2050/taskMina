@extends('admin.layout.index',[
'title' => _i('Store Style'),
'subtitle' => _i('Store Style'),
'activePageName' => _i('Store Style'),
'activePageUrl' => route('admin.style.index'),
] )
@section('header')

@endsection
@section('content')
    <div class=" user-profile">
        <div class="page-body">
            <div class="row">
                <div class="col-sm-12 ">
                    <div class="card">
                        <div class="card-block">
                            <div class="card-body">
                                <form method="post" action="{{ route('admin.styles.save') }}" id="form_id"
                                    data-parsley-validate="" class="style-form">
                                    @csrf
                                    <div class="row  ">

                                        <div class="col-md-12 row">
                                            <div class="form-group col-sm-3   ">
                                                <label class="control-label">{{ _i(' style name') }}</label>
                                                <input type="text" name="name" value="" class="form-control" id="name"
                                                    required>

                                            </div>
                                            <div class="form-group col-sm-3   ">
                                                <label class="control-label">{{ _i('Date From') }}</label>
                                                <input type="date" name="from" value="" class="form-control" id="from"
                                                    required>

                                            </div>
                                            <div class="form-group col-sm-3 ">
                                                <label class="control-label">{{ _i('Date To') }}</label>
                                                <input type="date" name="to" value="" class="form-control" id="to"
                                                    required>

                                            </div>
                                            <div class="form-group mt-3 ">
                                                <label>{{ _i('Active') }}</label>
                                                <input type="checkbox" name="active" value="1" class="form-control" id="">

                                            </div>
                                        </div>

                                        @include('admin.styles.partial')


                                        <div class="box-footer">
                                            <button type="button" class="btn btn-primary Preview " name="preview"
                                                value="preview" id="preview">{{ _i('Preview') }}</button>

                                            <button type="submit" class="btn btn-primary save " form="form_id" name="save"
                                                id="save" value="save">{{ _i('Save') }}</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        window.ParsleyConfig = {
            errorsWrapper: '<div></div>',
            errorTemplate: '<div class="  alert-danger parsley" role="alert"></div>',
            errorClass: 'has-error',
            successClass: 'has-success'
        };

        $(document).on('click', '#preview', function(e) {
            e.preventDefault();

            var url = "{{ route('admin.styles.save') }}";

            // Check for colors
            if ($('#header_background_color' + '_check').is(":checked")) {
                var header_background_color = null;
            } else {
                var header_background_color = $('#header_background_color').val();
            }

            // 
            if ($('#header_font_color' + '_check').is(":checked")) {
                var header_font_color = null;
            } else {
                var header_font_color = $('#header_font_color').val();
            }

            // 
            if ($('#header_icon_color' + '_check').is(":checked")) {
                var header_icon_color = null;
            } else {
                var header_icon_color = $('#header_icon_color').val();
            }

            // 
            if ($('#category_background_color' +'_check').is(":checked")) {
                var category_background_color = null;
            } else {
                var category_background_color = $('#category_background_color').val();
            }

            // 
            if ($('#category_font_color' +'_check').is(":checked")) {
                var category_font_color = null;
            } else {
                var category_font_color = $('#category_font_color').val();
            }

            // 
            if ($('#category_background_color_hover' +'_check').is(":checked")) {
                var category_background_color_hover = null;
            } else {
                var category_background_color_hover = $('#category_background_color_hover').val();
            }

            // 
            if ($('#category_font_color_hover' +'_check').is(":checked")) {
                var category_font_color_hover = null;
            } else {
                var category_font_color_hover = $('#category_font_color_hover').val();
            }

            // 
            if ($('#product_add_font_color' +'_check').is(":checked")) {
                var product_add_font_color = null;
            } else {
                var product_add_font_color = $('#product_add_font_color').val();
            }

            // 
            if ($('#product_out_background_color' +'_check').is(":checked")) {
                var product_out_background_color = null;
            } else {
                var product_out_background_color = $('#product_out_background_color').val();
            }

            // 
            if ($('#product_out_font_color' +'_check').is(":checked")) {
                var product_out_font_color = null;
            } else {
                var product_out_font_color = $('#product_out_font_color').val();
            }

            // 
            if ($('#footer_background_color' +'_check').is(":checked")) {
                var footer_background_color = null;
            } else {
                var footer_background_color = $('#footer_background_color').val();
            }

            // 
            if ($('#footer_font_color' +'_check').is(":checked")) {
                var footer_font_color = null;
            } else {
                var footer_font_color = $('#footer_font_color').val();
            }

            // 
            if ($('#store_color' +'_check').is(":checked")) {
                var store_color = null;
            } else {
                var store_color = $('#store_color').val();
            }

            // 
            if ($('#product_background_color' +'_check').is(":checked")) {
                var product_background_color = null;
            } else {
                var product_background_color = $('#product_background_color').val();
            }
            
            var font = $('#font').val();

            $.ajax({
                url: url,
                type: "post",
                data: {
                    header_background_color: header_background_color,
                    header_font_color: header_font_color,
                    header_icon_color: header_icon_color,
                    category_background_color: category_background_color,
                    category_font_color: category_font_color,
                    category_background_color_hover: category_background_color_hover,
                    category_font_color_hover: category_font_color_hover,
                    product_out_background_color: product_out_background_color,
                    product_out_font_color: product_out_font_color,
                    footer_background_color: footer_background_color,
                    footer_font_color: footer_font_color,
                    product_background_color: product_background_color,
                    store_color: store_color,
                    font: font,
                },
                dataType: 'json',
                cache: false,


                success: function(res) {

                    if (res == 'success') {
                        window.open("{{ route('preview', app()->getLocale()) }}");
                    }

                }
            })
        });
    </script>
    <script src="http://parsleyjs.org/dist/parsley.js"></script>
@endpush
