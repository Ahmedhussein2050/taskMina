<div class="col-md-8">
    <div class="card user">
        <div class="card-header">
            <h5>{{ _i('Status Order') }}</h5>
        </div>
        <table class=" table table-bordered table-striped   text-center" id="order_data" width="100%">
            <thead>
                <th>{{ _i('ID') }}</th>
                <th>{{ _i('Status') }}</th>
                <th>{{ _i('Description') }}</th>
                <th>{{ _i('Date') }}</th>
            </thead>
            <tbody>
                @foreach ($order->track()->latest()->get() as $text)
                    <tr>

                        <td>{{ $text->id }}</td>
                        <td>{{ $text->statusData->title }}</td>
                        <td>{{ $text->comment }}</td>
                        <td>{{ $text->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
