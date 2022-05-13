@if ($type == 'Low_Stock')
    <div class="card">
        <div class="card-header">
            <h5>{{ _i('Stock') }}</h5>
            <div class="card-header-right">
                <i class="icofont icofont-rounded-down"></i>
                <i class="icofont icofont-refresh"></i>
                <i class="icofont icofont-close-circled"></i>
            </div>
        </div>
        <div class="card-block">
            <section class="task-panel tasks-widget">
                <div class="panel-body">
                    @if (count($notStock) > 0)
                        <div class="task-content scrolling-pagination">

                            @foreach ($notStock as $item)
                                <div class="to-do-label delete_{{ $item->id }}">
                                    <div class="checkbox-fade fade-in-primary">

                                        @include("admin.notificationsAll.include.text")

                                    </div>
                                </div>
                            @endforeach
                            <div class="text-center">
                                {{-- {{ $notStock->links() }} --}}
                                {{ $notAll->appends(['type' => 'Low_Stock'])->links() }}
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
