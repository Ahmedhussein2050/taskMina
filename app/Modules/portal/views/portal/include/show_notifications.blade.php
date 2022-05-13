@extends('layout.index')
@section('title', _i('My Notifications'))

@section('main')
    @if (count($notfications) > 0)
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body ">
                        <div class="col-md-12">
                            <div>
                                <div class="row p-4 no-gutters  center">
                                    <div class="col-sm-12 col-md-4">
                                        <h4 class="font-light mb-0" id="notiftotal"><i
                                                class="ti-email mr-2"></i><span class="notCount">{{ $notfications->total() }}</span>
                                            {{ _i('Notifications') }}</h4>
                                    </div>

                                </div>
                                <!-- Mail list-->
                                <div class="table-responsive col-md-9 center">
                                    <table class="table email-table no-wrap table-hover v-middle mb-0 font-14 nott">
                                        <tbody>
                                            <!-- row -->
                                            @foreach ($notfications as $noti)
                                                <tr id="deletee-{{ $noti->id }}">

                                                    @php
                                                        $data = json_encode($noti->notificationType($noti));
                                                    @endphp

                                                    <td>
                                                        <a href="#" data-id="{{ $noti->id }}" class="read">
                                                            <span
                                                                class="mb-0 text-muted notydata{{ $noti->id }} @if ($noti->read_at == null) text-color1 @endif">{{ json_decode($data)->title }}</span>
                                                        </a>
                                                    </td>
                                                    {{-- <td>
                                                        <a href="#" data-id="{{ $noti->id }}">
                                                            @if ($noti->read_at == null)
                                                                <span
                                                                    class="text-dark notydata{{ $noti->id }} font-weight-bold ">
                                                                    {{ json_decode($data)->body }}</span>
                                                            @else
                                                                <span class="text-dark notydata{{ $noti->id }}">
                                                                    {{ json_decode($data)->body }}</span>
                                                            @endif

                                                        </a>
                                                    </td> --}}

                                                    <td class="text-muted">{{ $noti->created_at }}</td>

                                                    <td> <button href="#" class="delete-item trash" id="trash"
                                                            data-id="{{ $noti->id }}"
                                                            data-date="{{ $noti->created_at }}"><i
                                                                class="fa fa-trash"></i>
                                                        </button></td>
                                                </tr>
                                            @endforeach

                                        </tbody>
                                    </table>
                                    <div class="text-center mt-3">
                                        {{ $notfications->links() }}
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="text-center  mt-3">
            <span>{{ _i('No Notifications Found ') }}</span>
        </div>
    @endif
@endsection
@push('js')
    <script>
        $('.nott .trash').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('notification.trash') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(res) {
                    console.log( id);

                    $("#deletee-"+id).remove();
                    $("#delete-"+id).remove();
                    var count = $(".notCount").html();
                    console.log(count)
                    $(".notCount").html(count - 1);
                }
            })
        })
        $('.nott .read').click(function(e) {
            e.preventDefault();
            var id = $(this).data('id');
            var url = "{{ route('notification.read') }}";
            $.ajax({
                url: url,
                type: 'GET',
                data: {
                    id: id,
                },
                success: function(res) {

                    $(".notydata" + id).removeClass("text-color1");

                }
            })
        })
    </script>
@endpush
