@php

$myresult = \App\User::whereIn('id', function ($q) {
    $q->select('user_id')->from('offer_codes');
})
    ->get()
    ->toArray();

$groups = App\Models\Group::all();

if ($discount != null && $discount->type == 'general') {
    $promotors = \App\Models\Discounts\Promotors::where('status', 'active')->get();
    $members = \App\User::whereNotIn('id', $promotors->pluck('user_id'))->get();

    $abandoned_carts = App\Models\AbandonedCart::join('users', 'users.id', '=', 'abandoned_carts.user_id')
        ->select('users.id', 'users.name', 'abandoned_carts.user_id')
        ->whereNotIn('users.id', $promotors->pluck('user_id'))
        ->distinct()
        ->get();
} else {
    # code...
    $members = \App\User::all();
    $abandoned_carts = App\Models\AbandonedCart::join('users', 'users.id', '=', 'abandoned_carts.user_id')
        ->select('users.id', 'users.name', 'abandoned_carts.user_id')
        ->distinct()
        ->get();
}

@endphp
<div class="row">
    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label"> {{ _i('Members') }} <span
                style="color: #F00;">*</span></label>
        <div class="col-sm-10">
            <select name="member_id[]" class="select2 m-b-10 select2-multiple myselect member_id" multiple="multiple"
                data-placeholder="Select an Option">
                @foreach ($members as $member)
                    <option value="{{ $member->id }}">{{ $member->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label"> {{ _i('Groups') }} <span
                style="color: #F00;">*</span></label>
        <div class="col-sm-10">
            <select name="group_id[]" class="select2 m-b-10 select2-multiple myselect group_id" multiple="multiple"
                data-placeholder="Select an Option">
                @foreach ($groups as $group)
                    <option value="{{ $group->id }}">{{ $group->title }}</option>
                @endforeach

            </select>
        </div>
    </div>

    <div class="form-group row">
        <label for="title" class="col-sm-2 col-form-label"> {{ _i('Abandon Cart') }} <span
                style="color: #F00;">*</span></label>
        <div class="col-sm-10">
            <select name="aband_id" class="select2 m-b-10 select2-multiple myselect aband_id" multiple="multiple"
                data-placeholder="Select an Option">
                @foreach ($abandoned_carts as $abandonedCart)
                    <option value="{{ $abandonedCart->id }}">{{ $abandonedCart->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-sm-12 mb-3">

        <span class="pull-right ">
            <a href="#" class=" deleteAll text-danger" type="button">
                <span><i class="icofont icofont-ui-delete  text-danger"></i>
                    {{ _i('Remove All') }} </span>
            </a>
        </span>
    </div>

    <div class="clearfix"></div>


</div>
<form method='post' action='{{ route('discounts.storeUserData') }}' class='form-group'>
    @csrf
    <input type="hidden" value="" name="discount_id">

    <div class="row">
        <div class="row users-card" id="appendToThis">
            @if ($discount != null && $discount->type == 'general')
                @php
                    $promo_result = \App\User::join('promotors', 'users.id', 'promotors.user_id')
                        ->whereIn('promotors.id', function ($q) use ($Discount_id) {
                            $q->select('promotor_id')
                                ->from('discount_promotors')
                                ->where('discount_id', $Discount_id);
                        })
                        ->get()
                        ->toArray();
                    //dd($promo_result);
                @endphp


                @include('admin.discounts.append', ['result'=>$promo_result,"promo_id"=> true])
            @endif
        </div>

        <div class="col-md-12">
            <input class="btn btn-primary btn-block" type="submit" value="{{ _i('Save') }}">

        </div>
    </div>


</form>
@push('js')
    <script type="text/javascript">
        $(function() {
            $('.myselect').select2();

            $('.member_id').on('select2:selecting', function(e) {
                var url = "{{ route('discounts.ajaxmember') }}";
                var id = [e.params.args.data.id];
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(data) {


                        $("#appendToThis").append(data);

                    }
                });

            });
            $('.group_id').on('select2:selecting', function(e) {
                var url = "{{ route('discounts.ajaxmember') }}";
                var group_id = [e.params.args.data.id];
                $.ajax({
                    url: url +
                        "{{ $discount != null && $discount->type == 'general' ? '?promo=1' : '' }}",
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        group_id: group_id
                    },
                    success: function(data) {
                        $("#appendToThis").append(data);
                    }
                });

            });
            $('.promo_id').on('select2:selecting', function(e) {
                var url = "{{ route('discounts.ajaxmember') }}";
                var id = [e.params.args.data.id];
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        promo_id: id
                    },
                    success: function(data) {
                        $("#appendToThis").append(data);
                    }
                });

            });
            $('.aband_id').on('select2:selecting', function(e) {
                var url = "{{ route('discounts.ajaxmember') }}";
                var aband_id = [e.params.args.data.id]; //$(this).val();
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        aband_id: aband_id
                    },
                    success: function(data) {
                        $("#appendToThis").append(data);
                    }
                });

            });

            $('.promo_id').on('select2:unselecting', function(e) {
                id = e.params.args.data.id;
                $(".data_" + id).remove();


            });
            $('.group_id').on('select2:unselecting', function(e) {
                id = e.params.args.data.id;
                $('div[data-gid=' + id + ']').remove();


            });
            $('.aband_id').on('select2:unselecting', function(e) {
                id = e.params.args.data.id;
                $(".data_" + id).remove();

            });
            $('.member_id').on('select2:unselecting', function(e) {
                id = e.params.args.data.id;
                $(".data_" + id).remove();

            });

        });

        $('body').on('click', '.btn-delete[data-url]', function(e) {
            e.preventDefault();
            var url = $(this).data('url');
            var id = $(this).data('id');
            $(".data_" + id).remove();

        });

        $('body').on('click', '.deleteAll', function(e) {
            e.preventDefault();
            $("#appendToThis").children().remove();
        });
    </script>

@endpush
