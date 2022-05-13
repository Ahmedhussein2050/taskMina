<div class="notifications-dropdown">
    @if (auth()->check())
        <a href="#" id="notifications">
            <div class="cart-text"><i class="fa fa-bell"></i>
                <div class="cart-badge notCount">
                    {{ \App\Bll\Utility::showNotifications()->count() }}
                </div>
            </div>
        </a>

        <div class="notification-wrapper">

            <div class="inner-items slimscroll">
                @forelse (\App\Bll\Utility::showNotifications()->take(10)->get() as $not)
                    <div class="single-notification-item" id="delete-{{ $not->id }}">

                        <div class="d-flex align-self-center justify-content-between ">
                            @php
                                $data = json_encode($not->notificationType($not));
                            @endphp
                            <a href="#" class="read" data-id="{{ $not->id }}">
                                <h6
                                    class="text-dark notydata{{ $not->id }} @if ($not->read_at == null) text-color1 @endif">
                                    {{ json_decode($data)->title }}
                                </h6>
                                <small class="text-muted">{{ $not->created_at }}</small>
                            </a>

                            <button href="#" class="delete-item trash" id="trash" data-id="{{ $not->id }}"
                                data-date="{{ $not->created_at }}"><i class="fa fa-trash"></i>
                            </button>

                        </div>
                    </div>

                @empty
                    <h5 class="text-center">{{ _('you dont have notifications') }}</h5>
                @endforelse
            </div>
            @if (\App\Bll\Utility::showNotifications()->get()->isNotEmpty())
                <a href="{{ route('showNotification') }}"
                    class="btn btn-color1 mt-3 py-2 w-100">{{ _i('All notifications') }}</a>
            @endif

        </div>
    @endif
</div>
@push('js')
    <script>
        $('.notification-wrapper .trash').click(function(e) {
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

                    $("#delete-" + id).remove();
                    var count = $(".notCount").html();
                    console.log(count)
                    $(".notCount").html(count - 1);
                }
            })
        })
        $('.notification-wrapper .read').click(function(e) {
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
