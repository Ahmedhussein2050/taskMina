@extends('layout.index')
@section('title', _i('My Balance'))

@section('main')
    <div class="inner-page-wrapper">
        <section class="my-orders-page my-5">
            <div class="container">
                <div class="white-wrapper">
                    @include('portal.user.account.partial')
                </div>

                <div class="user-panel-wrapper my-3">
                    <div class="white-wrapper">
                        <div class="d-md-flex justify-content-between gap-3 align-items-center px-4 py-3">
                            <div class="balance-info">
                                <div class="badge bg-color2">{{ _i('Balance') }} : {{ $balances->sum('balance') }}
                                    {{ _i('SAR') }}</div>
                            </div>
                            <button class="btn badge bg-color1" data-bs-toggle="modal"
                                data-bs-target="#recharge-my-balance">{{ _i('Recharge balance') }}
                            </button>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ _i('Amount') }}</th>
                                    <th>{{ _i('Status') }}</th>
                                    <th>{{ _i('Type') }}</th>
                                    <th>{{ _i('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($balances as $key => $balance)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>
                                            <label>
                                                {{ $balance->balance }} {{ _i('SAR') }}</label>
                                        </td>

                                        <td>
                                            <label class="badge bg-success">{{ _i('Paid') }}</label>
                                        </td>
                                        <td>
                                            <label>{{ _i('Pay') }}</label>
                                        </td>
                                        <td>
                                            {{ $balance->created_at }}
                                        </td>
                                    </tr>
                                @empty
                                    <h4 class="text-center"> {{ _i('Your Balane is empty') }}</h4>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="modal fade bootstrap-modal" id="recharge-my-balance" tabindex="-1">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ _i('Recharge my balance') }}</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="recharge-my-balance-form" method="post" action="{{ route('balancePayment') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ticket-subject" class="col-form-label">{{ _i('Amount') }} :</label>
                                    <input type="text" name="amount" class="form-control withdrawal-amount">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="ticket-subject" class="col-form-label">{{ _i('Current amount') }} :
                                    </label>
                                    <input type="text" class="form-control main-currency-amount" readonly=""
                                        value="{{ $balances->sum('balance') }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">{{ _i('Pay method') }}</label>
                                    <select name="method" class="form-select custom-select recharge-select">
                                        <option value="1">Tab</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="ticket-body" class="col-form-label">{{ _i('Details') }} : </label>
                            <textarea class="form-control" name="details" rows="4"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ _i('Close') }}</button>
                    <button type="submit" class="btn btn-primary recharge-my-balance-btn" form="recharge-my-balance-form">
                        {{ _i('Send request') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

@endsection
