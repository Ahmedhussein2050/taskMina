@extends('admin.layout.index',[
	'title' => _i('Payment Gateways'),
	'subtitle' => _i('Payment Gateways'),
	'activePageName' => _i('Payment Gateways'),
	'activePageUrl' => route('paymentGetways.index'),
	'additionalPageName' => _i('Settings'),
	'additionalPageUrl' => route('settings.index') ,
] )
@section('content')




 <div class="page-body">
 <div class="row">
	 @foreach($getways as $getway)
			<div class="col-md-12 col-xl-4">
				<div class="card counter-card-1">
					<div class="card-block-big d-flex justify-content-between">
						<div>
							<h3>
								<div>{{ $getway->name }}</div>


							</h3>
							<div class="col-md-12">
							<img src="{{ asset($getway->image) }}" alt="{{ $getway->name }}" class="img-fluid">
							</div>


							<div>
								<button type="button" class="btn btn-primary col-md-12 mt-2" data-toggle="modal" data-target="#example-{{$getway->id}}">
									{{_i('Change Logo') }}
								</button>
							</div>
						</div>

					</div>
				</div>
			</div>
		    <div class="modal fade" id="example-{{$getway->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
			 <div class="modal-dialog" role="document">
				 <div class="modal-content">
					 <div class="modal-header">
						 <h5 class="modal-title" id="exampleModalLabel">{{_i('Update Logo')}}</h5>
						 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							 <span aria-hidden="true">&times;</span>
						 </button>
					 </div>
					 <form action="{{route('paymentGetways.update')}}" method="post" enctype="multipart/form-data">
					 <div class="modal-body">

							 @csrf
						 <input type="file" name="image" >
						 <input type="hidden" name="id" value="{{$getway->id}}">
							 <div class="row col-md-6">
					     	 <img src="{{ asset($getway->image) }}" alt="{{ $getway->name }}" class="img-fluid">
							 </div>
					 </div>
					 <div class="modal-footer">
						 <button type="button" class="btn btn-secondary" data-dismiss="modal">{{_i('Close')}}</button>
						 <button type="submit" class="btn btn-primary">{{_i('Save')}}</button>
					 </div>
					 </form>
				 </div>
			 </div>
		 </div>
		 @endforeach


 </div>
 </div>








@endsection
