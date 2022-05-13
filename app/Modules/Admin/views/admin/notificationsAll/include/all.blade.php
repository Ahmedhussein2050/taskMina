@if ($type == 'notAll')
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('ِAll') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
{{--        {{dd(auth()->user()->unreadNotifications()->paginate(5))}}--}}
        <div class="card-block">
            <section class="task-panel tasks-widget">
                <div class="panel-body">
                    @if (count($notAll) > 0)
                        <div class="task-content scrolling-pagination">

                            @foreach ($notAll as $item)
                                <div class="to-do-label delete_{{ $item->id }}">
                                    <div class="checkbox-fade fade-in-primary">
                                       @include("admin.notificationsAll.include.text")
                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center">
                                {{-- {{ $notAll->links() }} --}}
                                {{ $notAll->appends(['type' => 'notAll'])->links() }}
                            </div>
                        </div>

                    @else
                        <div style="text-align: center;">
                            <h3>{{ _i('Not Found') }}</h3>
                        </div>

                    @endif

                </div>
            </section>

        </div>

    </div>
@endif
