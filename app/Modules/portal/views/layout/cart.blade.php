@if (auth()->check())
    @php

        $count = App\Models\AbandonedCart::where('user_id', auth()->user()->id)->count();
    @endphp
    <div class="cart-wrapper">
        <a href="{{ route('cart') }}" id="cart">
            <i class="fas fa-shopping-basket"></i> <span class="badge cartcount">{{ $count }} </span>

        </a>
    </div>
@endif
