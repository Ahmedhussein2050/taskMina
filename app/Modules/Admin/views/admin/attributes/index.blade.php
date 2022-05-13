@extends('admin.layout.index',[
'title' => _i('Attributes') ,
'subtitle' => _i('Attributes') ,
'activePageName' => _i('Attributes') ,
'activePageUrl' => route('category.attributes'). '?id=' . request()->input('id'),
'additionalPageName' => '',
'additionalPageUrl' => '' ,
])

@section('content')
    <!-- Page-body start -->
    <div class="page-body">
        <div class="row">
            <div class="col-sm-12">
                <a href="#" class='btn btn-primary btn-sm mb-2' data-toggle='modal' data-target='#attribute-Modal'>
                    <i class="fa fa-plus"></i>
                </a>
                <div class="card">
                    <div class="card-header">
                        <h5> {{ _i('Attribute') }}</h5>
                    </div>
                    <div class="card-block">
                        <div class="table-responsive dt-responsive">
                            <table id="datatable" class="table table-striped table-bordered nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ _i('name') }}</th>
                                        {{-- <th>{{ _i('Placeholder') }}</th>
                                        <th>{{ _i('Type') }}</th> --}}
                                        <th>{{ _i('Require') }}</th>
                                        <th>{{ _i('Created_at') }}</th>
                                        <th>{{ _i('Options') }}</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('admin.attributes.modal')
        @include('admin.attributes.create')
    </div>
    <!-- Page-body end -->
@endsection
@push('js')
    <script>
        var url_string = window.location.href;
        var url_temp = new URL(url_string);
        var code = url_temp.searchParams.get("id");
        let url = "{{ route('category.attributes') }}?id=" + code;
        var table = $('#datatable').DataTable({
            order: [],
            processing: true,
            serverSide: true,
            ajax: url,
            columns: [{
                    data: 'id',
                    name: 'id'
                },
                {
                    data: 'title',
                    name: 'title'
                },
                // {
                //     data: 'placeholder',
                //     name: 'placeholder'
                // },
                // {
                //     data: 'type',
                //     name: 'type'
                // },
                {
                    data: 'require',
                    name: 'require'
                },
                {
                    data: 'created_at',
                    name: 'created_at'
                },
                {
                    data: 'options',
                    name: 'options',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        $(document).on('change', '[data-types]', function(e) {
            let type = $(this).val();
            console.log(type);
            if (type == 'select') {
                $('div[data-options]').show();
                $('[data-require]').prop('required', true);
            } else {
                $('div[data-options]').hide();
                $('[data-require]').prop('required', false);
                $('[data-value]').val("");
            }
        });

        $(document).on('click', 'button[data-add]', function(e) {
            e.preventDefault();
            let behavior = $(this).data('add');
            let count = $('div[data-group=row]').length;
            if (behavior == 'plus') {
                let html = `<div class="form-group row" data-group="row">`;
                @foreach ($languages as $lang)
                    html = html + `<label for="" class="col-sm-1 control-label"> {{ $lang->code }} </label>
                    <div class="col-sm-4">
                        <input type="text" name="option[${count + 1}][{{ $lang->code }}]" value="" class="form-control"
                            data-value="option" />
                    </div>`
                @endforeach
                html = html + `<div class="col-sm-1 float-right">
                                    <button class="btn btn-sm btn-danger" data-add="minus">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    </div>
                                </div>`;
                $('[data-group=options-group]').append(html);
            }
            if (behavior == 'minus') {
                $(this).parent('div').parent('div').remove();
            }
        });

        $(document).on('submit', '#add-form', function(e) {
            e.preventDefault();
            let url = "{{ route('category.attributes.save') }}"
            $.ajax({
                url: url,
                method: "POST",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.fail == false) {
                        $('.modal').modal('hide');
                        $('#datatable').DataTable().draw(false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "{{ _i('Saved Successfully') }}",
                            showConfirmButton: false,
                            timer: 5000
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ _i('Error Happened') }}",
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
            });
        });

        $(document).on('click', '[data-url]', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    $('.modal').modal('hide');
                    $('#datatable').DataTable().draw(false);
                    if (response.fail == false) {
                        $('.modal').modal('hide');
                        $('#datatable').DataTable().draw(false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: "{{ _i('Deleted Successfully') }}",
                            showConfirmButton: false,
                            timer: 5000
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ _i('Error Happened') }}",
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
            }).always(function(data) {
                $('#datatable').DataTable().draw(false);
            });
        });

        $(document).on('click', '[data-action=edit]', function(e) {
            let id = $(this).data('id');
            $.ajax({
                url: "{{ route('category.attribute.edit') }}",
                method: 'POST',
                data: {
                    id: id,
                },
                success: function(response) {
                    if (response.fail == false) {
                        $('[data-edit=id]').val(response.attribute.id);
                        let html = '';
                        html = html + `
                            <label for="title">{{ _i('Attribute Name') }}</label>
                            <div class="form-group row">`;
                        let title = ``;
                        $.each(response.attribute.data, function(key, element) {
                            let lang = response.languages.find(obj => {
                                return obj.id == element.lang_id
                            })
                            title = title + `
                                <label for="" class="col-sm-2 control-label "> ${lang.code} </label>
                                <div class="col-sm-4">
                                    <input type="text" name="title[${lang.id}]" value="${element.title}"
                                        class="form-control" required id="title">
                                </div>`;
                        });
                        html = html + title + `</div>`;
                        html = html + `

                            <div class="form-group row">`;
                        let placeholder = ``;
                        $.each(response.attribute.data, function(key, element) {
                            let lang = response.languages.find(obj => {
                                return obj.id == element.lang_id
                            });
                        });
                        html = html + placeholder + `</div>`;
                        let temp1 = '';
                        let temp2 = '';
                        if (response.attribute.required == 1) {
                            temp1 = 'checked';
                        }
                        if (response.attribute.front == 1) {
                            temp2 = 'checked';
                        }
                        let required = `<div class="col-sm-6">
                                <input type="checkbox" value="1" name="required" class="js-switch" ${temp1}/>
                                <label for="required">{{ _i('Required') }}</label>
                            </div>`;
                        // let front = `<div class="col-sm-6">
                        //         <input type="checkbox" value="1" name="front" class="js-switch" ${temp2}/>
                        //         <label for="front">{{ _i('Appear at Front') }}</label>
                        //     </div>`;
                        html = html + required  ;
                        $('[data-edit=body]').empty().append(html);
                    } else {
                        e.preventDefault();
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: "{{ _i('Error Happened') }}",
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $('#datatable').DataTable().draw(false);
                    }
                }
            });
        });

        $(document).on('submit', '#edit-form', function(e) {
            e.preventDefault();
            let url = "{{ route('category.attribute.update') }}";
            $.ajax({
                url: url,
                method: "post",
                data: new FormData(this),
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function(response) {
                    if (response.fail == false) {
                        $('#attribute-edit').modal('hide');
                        $('#datatable').DataTable().draw(false);
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                },
            });
        });

        $(document).on('click', '[data-action=options]', function(e) {
            let id = $(this).data('id');
            let url = "{{ route('attribute.get.options') }}"
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id: id,
                },
                success: function(response) {
                    if (response.fail == false) {
                        $('input[data-edit=option-id]').val(id);
                        let html = ``;
                        $.each(response.options, function(key, element) {
                            html = html + `<div class="form-group row" data-group="row-edit">`;
                            $.each(element.data, function(temp, option) {
                                let lang = response.languages.find(obj => {
                                    return obj.id == option.lang_id;
                                })
                                html = html + `<label for="" class="col-sm-1 control-label">${lang.code}</label>
                                    <div class="col-sm-4">
                                        <input type="text" data-lang="${lang.code}" name="option_edit[${key}][${lang.code}]" class="form-control" data-require="true" data-value="option" data-order="${key}" value="${option.title}"/>
                                    </div>`;
                            });
                            html = html + `<div class="col-sm-2 float-right">
                                            <button class="btn btn-sm btn-danger" data-manage="remove" data-id="${element.id}">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                            <button class="btn btn-sm btn-primary" data-id="${element.id}" data-manage="submit" data-key="${key}">
                                                <i class="fa fa-check"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>`;
                        });
                        $('[data-edit=options]').empty().append(html);
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                }
            });
        });

        $(document).on('click', '[data-manage]', function(e) {
            e.preventDefault();
            let behavior = $(this).data('manage');
            if (behavior == 'add') {
                let count = $('div[data-group=row-edit]').length;
                let html = `<div class="form-group row" data-group="row-edit">`;
                @foreach ($languages as $lang)
                    html = html + `<label for="" class="col-sm-1 control-label"> {{ $lang->code }} </label>
                    <div class="col-sm-4">
                        <input type="text" data-lang="{{ $lang->code }}" data-order="${count + 1}"
                            name="option_edit[${count + 1}][{{ $lang->code }}]" value="" class="form-control" data-value="option" />
                    </div>`
                @endforeach
                html = html + `<div class="col-sm-2 float-right">
                                        <button class="btn btn-sm btn-danger" data-manage="remove" data-id="new">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button class="btn btn-sm btn-primary" data-id="new" data-manage="submit" data-key="${count + 1}">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </div>
                                </div>`;
                $('[data-edit=options]').append(html);
            }
            if (behavior == 'submit') {
                let submit_key = $(this).data('key');
                let submit_id = $(this).data('id');
                let attribute_id = $('input[data-edit=option-id]').val();
                var options = $('input[data-order=' + submit_key + ']');
                let data = {};
                $.each(options, function(index, element) {
                    let lang_code = $(this).data('lang');
                    data[lang_code] = $(this).val();
                });
                let url = "";
                if (submit_id == 'new') {
                    url = "{{ route('attribute.option.store') }}";
                } else {
                    url = "{{ route('attribute.option.update') }}"
                }
                $.ajax({
                    url: url,
                    method: 'POST',
                    '_token': "{{ csrf_token() }}",
                    data: {
                        values: data,
                        option_id: submit_id,
                        id: attribute_id,
                    },
                    success: function(response) {
                        if (response.fail == false) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 5000
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: response.message,
                                showConfirmButton: false,
                                timer: 5000
                            });
                        }
                    }
                });
            }
            if (behavior == 'remove') {
                let remove_id = $(this).data('id');
                let button = $(this);
                if (remove_id == 'new') {
                    $(this).parent('div').parent('div').remove();
                } else {
                    let url = "{{ route('attribute.option.delete') }}";
                    $.ajax({
                        url: url,
                        method: 'POST',
                        '_token': "{{ csrf_token() }}",
                        data: {
                            id: remove_id,
                        },
                        success: function(response) {
                            if (response.fail == false) {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'success',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                                button.parent('div').parent('div').remove();
                            } else {
                                Swal.fire({
                                    position: 'top-end',
                                    icon: 'error',
                                    title: response.message,
                                    showConfirmButton: false,
                                    timer: 5000
                                });
                            }
                        }
                    });
                }
            }
        });

        $(document).on('click', '[data-button=icon]', function(e) {
            let id = $(this).data('id');
            $("[data-form=icon-id]").val(id);
            let icon = $(this).data('icon');
            console.log(icon);
            if (icon !== '' || icon != null || icon !== undefined || icon !== '{{ asset('') }}') {
                $("[data-from=icon-perview]").html(`<img src="${icon}" class="img-responsive" alt=""/>`);
            } else {
                $('[data-from=icon-perview]').empty();
            }
        });

        $(document).on('submit', '[data-form=icon]', function(e) {
            e.preventDefault();
            let url = $(this).attr('action');
            $.ajax({
                url: url,
                method: 'POST',
                '_token': "{{ csrf_token() }}",
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    if (response.fail == false) {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'success',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                        $('#datatable').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            position: 'top-end',
                            icon: 'error',
                            title: response.message,
                            showConfirmButton: false,
                            timer: 5000
                        });
                    }
                }
            });
        });
    </script>
@endpush
