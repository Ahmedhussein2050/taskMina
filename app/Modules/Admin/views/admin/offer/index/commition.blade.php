

@extends( (request()->query('view')) ? 'admin.layout.popup' : 'admin.layout.index', [
	'title' => _i('Commition'),
	'subtitle' => _i('Commission'),
	'activePageName' => _i('Commission'),
	'activePageUrl' => route('admin.commition.index'),
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

    <div class="page-body">


        <div class="card blog-page">
			<form action="" method="get">
					{{-- @csrf --}}
				@if (request()->query('view'))
				   <input type="hidden" name="view" value="1">
				@endif
				<div class="form-group row">
					<div class="col-sm-2">
					</div>
					<div class="col-sm-3">

						<label for="title" class="  col-form-label"> {{ _i('Minimum') }} </label>
					</div>

					<div class="col-sm-3">

						<label for="title" class=" col-form-label"> {{ _i('Maximum') }} </label>
					</div>
				</div>
				<div class="form-group row">
					<label for="title" class="col-form-label ml-4"> {{ _i('Commission') }} </label>
					<div class="col-sm-3">

						<input name="from" required type="text" class="form-control" value="{{ request()->query('from') }}" >
					</div>

					<div class="col-sm-3">

						<input name="to"   type="text" class="form-control" value="{{ request()->query('to') }}" >
					</div>
					<div class="col-sm-2">
						<input class="btn btn-primary  " type="submit" value="{{ _i('Search') }}">
					</div>
					{{-- <div class="col-sm-2">
						<a href="{{ route('admin.commition.index') }}" class="btn btn-danger  " >{{ _i('All') }}</a>
					</div> --}}
				</div>
		    </form>

            <div class="card-block ">
                <table class=" table table-bordered table-striped table-responsive text-center" id="order_dataa"
                    width="100%">
                    <thead>

                        <tr role="row">
							<th>{{ _i('Image') }}</th>
                            <th>{{ _i('Title') }}</th>
                            <th>{{ _i('Price') }}</th>
							<th>{{ _i('Cost') }}</th>
                            <th>{{ _i('Commission') }}</th>

                        </tr>

                    </thead>
                </table>
            </div>
        </div>
    </div>
    @push('js')
        @include('admin.layout.message')

        <script type="text/javascript">
            var table;

            table = $('#order_dataa').DataTable({

                "order": [],
                "dom": "Blfrtip",
                "buttons": [{
                        "extend": "print",
                        "className": "btn btn-primary",
                        "text": "<i class=\"ti-printer\"><\/i>"
                    },


                ],
                "responsive": true,
                "processing": true,
                "serverSide": true,
                ajax: {

                },
                columns: [
					{
                        data: 'image'
                    },
					{
                        data: 'title'
                    },
                    {
                        data: 'price'
                    },
					{
                        data: 'cost'
                    },
                    {
                        data: 'commition'
                    },


                ],

            });
            //}


        </script>
    @endpush
    <style>
        .table {
            display: table !important;
        }

        .row {
            width: 100% !important;
        }

    </style>
@endsection
