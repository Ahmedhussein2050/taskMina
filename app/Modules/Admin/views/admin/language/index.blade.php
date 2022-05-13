@extends('admin.layout.index',[
'title' => $title,
'activePageName' => $title,
'activePageUrl' => '',
'additionalPageUrl' => url('/admin/language') ,
'additionalPageName' => _i('Add'),
] )

@section('content')
    <div class="row">
        <div class="col-sm-12 mbl">
            <span class="pull-left">
                  <a href="{{url('admin/language/create')}}" data-toggle="modal" data-target="#create" class="btn btn-primary create add-permission">
                        <i class="ti-plus"></i>{{_i('create new language')}}
                    </a>
            </span>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h5> {{ _i('Permission List') }} </h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-refresh"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="dt-responsive table-responsive text-center">
                        <table id="permission_table"  class="table table-striped table-bordered nowrap text-center">
                            <thead>
                            <tr role="row">
                                <th  > {{_i('ID')}}</th>
                                <th  > {{_i('Language name')}}</th>
                                <th  > {{_i('Language code')}}</th>
                                <th  > {{_i('Language flag')}}</th>
                                <th  > {{_i('created_at')}}</th>
                                <th  > {{_i('updated_at')}}</th>
                                <th  > {{_i('Controll')}}</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="create" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{_i('Add Language')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form  action="{{url('/admin/language')}}" method="post" class="form-horizontal"  id="demo-form" data-parsley-validate="">
                        @csrf
                        <div class="form-group row"></div>
                        <div class="box-body">
                            <div class="form-group row">
                                <label for="" class="col-md-12 col-form-label"> {{_i('Name')}} </label>
                                <div class="col-md-12">
                                    <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" required="" >
                                    @if ($errors->has('title'))
                                        <span class="text-danger invalid-feedback" >
                                            <strong>{{ $errors->first('title') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-12 col-form-label"> {{_i('Code')}} </label>
                                <div class="col-md-12">
                                    <input type="text" name="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" required="" >
                                    @if ($errors->has('code'))
                                        <span class="text-danger invalid-feedback" >
                                            <strong>{{ $errors->first('code') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="" class="col-md-12 col-form-label"> {{_i('Flag')}} </label>
                                <div class="col-md-12">
                                    <input type="text" name="flag" class="form-control{{ $errors->has('flag') ? ' is-invalid' : '' }}" required="" >
                                    @if ($errors->has('flag'))
                                        <span class="text-danger invalid-feedback" >
                                            <strong>{{ $errors->first('flag') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- /.box-body -->
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
                            <button type="submit" class="btn btn-primary" >
                                {{_i('Add')}}
                            </button>
                        </div>
                        <!-- /.box-footer -->
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> {{_i('Update language')}} </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="editmodel">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
                    <button type="button" class="btn btn-primary" id="editform">{{_i('Save')}}</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script  type="text/javascript">
        $(function() {
            $('#permission_table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{url('admin/language/dataTable')}}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'title', name: 'title'},
                    {data: 'code', name: 'code'},
                    {data: 'flag', name: 'flag'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'action', name: 'action', orderable: true, searchable: true}
                ],
                columnDefs: [
                    { targets: 3,
                      render: function(imagename) {
                        return '<img src="{{asset('/')}}images/' + imagename + '">'
                      }
                    }   
                ]
            });
        });

        $(document).ready(function () {
            $('body').on('click','.add-permission',function (e) {
                e.preventDefault();
            });
            $('body').on('click','.edit',function (e) {
                e.preventDefault();
                var id = $(this).data('id');
                var title = $(this).data('title');
                var code = $(this).data('code');
                var flag = $(this).data('flag');
                var html = `<form  action="{{url('admin/language/update')}}" method="post" class="form-horizontal"  id="formedit" data-parsley-validate="">
                    @csrf
                    {{method_field('put')}}
                    <input type='hidden' name='id' value=${id}>
                    <div class="box-body">
                        <div class="form-group row">
                            <label for="" class="col-md-12 col-form-label  "> {{_i('Name')}} </label>
                            <div class="col-md-12">
                                <input type="text" name="title" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" value="${title}"  placeholder="Permission Name" required="" >
                                @if ($errors->has('title'))
                                <span class="text-danger invalid-feedback" >
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-12 col-form-label  "> {{_i('Code')}} </label>
                            <div class="col-md-12">
                                <input type="text" name="code" class="form-control{{ $errors->has('code') ? ' is-invalid' : '' }}" value="${code}"  placeholder="Permission Name" required="" >
                                @if ($errors->has('code'))
                                <span class="text-danger invalid-feedback" >
                                    <strong>{{ $errors->first('code') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="" class="col-md-12 col-form-label  "> {{_i('Flag')}} </label>
                            <div class="col-md-12">
                                <input type="text" name="flag" class="form-control{{ $errors->has('flag') ? ' is-invalid' : '' }}" value="${flag}"  placeholder="Permission Name" required="" >
                                @if ($errors->has('flag'))
                                <span class="text-danger invalid-feedback" >
                                    <strong>{{ $errors->first('flag') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    </form>`;
                $('#editmodel').empty();
                $('#editmodel').append(html);
            });
            $('body').on('click','#editform',function (e) {
                e.preventDefault();
                $('#formedit').submit();
            })
            $('#permission_table').on('click', '.btn-delete[data-remote]', function (e) { 
                e.preventDefault();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                var url = $(this).data('remote');
                // confirm then
                $.ajax({
                    url: url,
                    type: 'DELETE',
                    dataType: 'json',
                    data: {method: '_DELETE', submit: true}
                }).always(function (data) {
                    $('#permission_table').DataTable().draw(false);
                });
            });
        });
    </script>
@endpush