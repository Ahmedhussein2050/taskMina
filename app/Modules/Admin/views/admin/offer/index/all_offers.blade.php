@extends('admin.layout.index',[
'title' => _i(' All Offers'),
'subtitle' => _i('All Offers'),
'additionalPageName' => _i('Offer'),
'additionalPageUrl' => route('admin.offer.index')
])
@section('content')
    <div class="flash-message">
        @foreach (['danger', 'warning', 'success', 'info'] as $msg)
            @if (Session::has($msg))
                <p class="alert alert-{{ $msg }}">{{ Session::get($msg) }}</p>
            @endif
        @endforeach
    </div>
    <div class="row">
        @foreach ($categories as $item)
            <div class="col-md-12 col-xl-4">
                <div class="card counter-card-1">
                    <div class="card-block-big">
                        <div>
                            @if ($item->code == 'oneFree')
                                @php
                                    $link = '../offers?type=oneFree';
                                @endphp

                            @elseif( $item->code == 'duration' )
                                @php
                                    $link = '../offers?type=duration';
                                @endphp
                            @elseif($item->code == 'extra' )
                                @php
                                    $link = '../offers?type=extra';
                                @endphp
                            @elseif( $item->code == 'voucher' )
                                @php
                                    $link = '../offers?type=voucher';
                                @endphp
                            @elseif( $item->code == 'voucher-user-free' )
                                @php
                                    $link = '../offers?type=voucher-user-free';
                                @endphp
                            @elseif( $item->code == 'voucher-free' )
                                @php
                                    $link = '../offers?type=voucher-free';
                                @endphp

                            @endif
                            <a href="{{ $link }}">
                                <h3>{{ $item->code }} </h3>
                            </a>
                            <p>{{ $item->title }}</p>

                        </div>
                        <i class="icofont icofont-comment"></i>
                    </div>
                </div>
            </div>
        @endforeach
        <div class="col-md-12 col-xl-4">
            <div class="card counter-card-1">
                <div class="card-block-big">
                    <div>

                        <a href="{{ route('admin.commition.index') }}">
                            <h3> {{ _i('Products Commissions') }} </h3>
                        </a>
                        <p> </p>
                    </div>
                    <i class="icofont icofont-comment"></i>
                </div>
            </div>
        </div>
    </div>
@endsection
