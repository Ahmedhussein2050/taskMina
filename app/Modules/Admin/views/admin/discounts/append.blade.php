<?php
$gid = request()->group_id != null ? request()->group_id[0] : ''; ?>
@foreach ($result as $item)
    @php
	if (request()->promo_id != null || isset($promo_id))
        $promotor = \App\Promotors::where('user_id', $item['user_id'])->first();

    @endphp
    <div class="col-lg-6 col-xl-3 col-md-6 data_{{ $item['id'] }}" data-gid={{ $gid }}>
        @if (request()->promo_id != null || isset($promo_id))
            <input type="hidden" name="promo_id[]" value="{{ $promotor->id }}">

        @else
            <input type="hidden" name="user_id[]" value="{{ $item['id'] }}">
        @endif
        <div class="card rounded-card user-card">
            <div class="card-block">
                <div class="img-hover">
                    @if ($item['image'] != null)
                        <img class="img-fluid img-circle" src="{{ URL::asset('/uploads/users/' . $item['image']) }}"
                            alt="round-img">
                    @else
                        <img class="img-fluid img-circle"
                            src="{{ URL::asset('admin_dashboard/assets/images/user.png') }}" alt="round-img">
                    @endif

                </div>
                <div class="user-content">
                    <h4 class="">{{ $item['name'] }}</h4>
                    <h6 class="">{{ $item['email'] }}</h6>
                    <h5 class="">
                        @if (request()->promo_id != null || isset($promo_id))
                            {{ $promotor->membership_id }}
                        @else
                            {{ $item['membership_id'] }}
                        @endif

                    </h5>
                    <div>
                        <button class='btn btn-primary btn-outline-primary waves-effect waves-light m-r-15 btn-delete '
                            data-id="{{ $item['id'] }}"
                            data-url='{{ route('admin.discount.delete', $item['id']) }}'><i class='fa fa-trash'></i>
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endforeach
