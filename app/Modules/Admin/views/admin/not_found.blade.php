@extends('admin.layout.index',
[
'title' => _i('Shipping'),
'subtitle' => _i('New shipping company'),
'activePageName' => _i('Shipping'),
'activePageUrl' => route('shipping.index'),
'additionalPageName' => _i('Settings'),
'additionalPageUrl' => route('settings.index') ,
])

@section('content')
<style>
    .table-card .row-table span,
    .table-card .row-table h5 {
        white-space: nowrap;
    }

</style>
<section class="content">
    <!-- Small boxes (Stat box) -->
   <div class="card">
                    <div class="card-header">
                        <h5>{{_i("Error Found")}}</h5>
                        <span>{{_i("The page you are looking for is not found")}}</span>
                        <div class="card-header-right">
                            <i class="icofont icofont-rounded-down"></i>
                            <i class="icofont icofont-refresh"></i>
                            <i class="icofont icofont-close-circled"></i>
                        </div>
                    </div>
                    <div class="card-block">
                        <div class="row">
                            
                        </div>
                    
                    </div>
                </div>
</section>
@endsection