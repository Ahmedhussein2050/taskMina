@extends('admin.layout.index',[
    'title' => _i('Reports'),
    'subtitle' => _i('Reports'),
    'activePageName' => _i('Reports'),
    'activePageUrl' => '',
    'additionalPageUrl' => '' ,
    'additionalPageName' => '',
] )

@push('js')
    <script>
    $(document).ready(function(){
        $("#type-report").change(function(){
            $(this).find("option:selected").each(function(){
                var optionValue = $(this).attr("value");
                if(optionValue){
                    $(".report").not("." + optionValue).hide();
                    $("." + optionValue).show();
                } else{
                    $(".report").hide();
                }
            });
        }).change();
    });
    </script>
@endpush
@section('content')
<div class="page-body">
    <div class="row">
        <div class="col-md-12 mb-3">
          <form method="post" id="reports-form">
                @csrf  
                <div class="dropdown-inverse dropdown open mr-3">
                    <select id="type-report" name="type-report" class="form-control form-control-primary">
                        <option value="all">{{_i('All')}}</option>
                        <option value="day">{{_i('Daily')}}</option>
                        <option value="week">{{_i('Weekly')}}</option>
                        <option value="month">{{_i('Monthly')}}</option>
                        <option value="year">{{_i('Yearly')}}</option>
                    </select>
                </div>
                <div id="report-day" class="dropdown-inverse dropdown open day report mr-3">
                    {{Form::date('date', \Carbon\Carbon::today(),['class' => 'form-control mb-2 mr-sm-2 mb-sm-0','id' => 'date'])}}
                    {{-- <select id="day" name="day" class="form-control form-control-primary">
                        @foreach (\App\Bll\Utility::allDays() as $key => $value)
                    <option value="{{$key}}">{{$value}}</option>    
                        @endforeach
                    </select> --}}
                </div>
                <div id="report-week" class="dropdown-inverse dropdown open week report">
                    <select id="week" name="week" class="form-control form-control-primary">
                        <option value="1">الأسبوع الحالي ({{Carbon\Carbon::now()->startOfWeek()->format('Y/m/d')}} / {{Carbon\Carbon::now()->endOfWeek()->format('Y/m/d')}})</option>
                        <option value="2">الأسبوع الماضي ({{\App\Bll\Utility::LastWeek()[0]}} / {{\App\Bll\Utility::LastWeek()[1]}})</option>
                    </select>
                </div>
                <div id="report-month" class="dropdown-inverse dropdown open month report">
                    <div class="report-filter-month">
                        <select id="month" name="month" class="form-control form-control-primary">
                            @foreach (\App\Bll\Utility::allMonths() as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>    
                            @endforeach
                        </select>
                    </div>
                    <div class="report-month-year">
                        <select id="month-year" name="month-year" class="form-control form-control-primary">
                            @foreach (\App\Bll\Utility::allyears() as $key => $value)
                            <option value="{{$key}}">{{$value}}</option>    
                                @endforeach
                        </select>
                    </div>
                </div>
                <div id="report-year" class="dropdown-inverse dropdown open year report">
                    <select id="year" name="year" class="form-control form-control-primary">
                        @foreach (\App\Bll\Utility::allyears() as $key => $value)
                        <option value="{{$key}}">{{$value}}</option>    
                        @endforeach
                    </select>
                </div>
                <input type="submit" class="btn btn-primary waves-effect waves-light ml-3" value="Submit">
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Sales')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <td>{{_i('اجمالى المبيعات')}}</td>
                                    <td>{{ $orders->sum('total') }}</td>
                                </tr>
                                <tr>
                                    <td>{{_i('تكاليف المنتجات')}}</td>
                                    <td>-----</td>
                                </tr>
                                <tr>
                                    <td>{{_i('الشحن')}}</td>
                                    <td>{{ $orders->sum('shipping_cost') }}</td>
                                </tr>
                                <tr>
                                    <td>{{_i('الضرائب')}}</td>
                                    <td>----</td>
                                </tr>
                                <tr>
                                    <td>{{_i('رسوم الدفع الاليكترونى')}}</td>
                                    <td>-----</td>
                                </tr>
                                <tr>
                                    <td>{{_i('صافى الربح')}}</td>
                                    <td>----</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Orders')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <span class="report-big-number">{{ $orders->count() }}</span>
                                    <span class="report-sub-text">{{_i('طلب')}}</span>
                                </tr>
                            </tbody>
                        </table>
                        <canvas id="Chart" width="280" height="280"></canvas>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('clints')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <span class="report-big-number">{{ $clints->count() }}</span>
                                    <span class="report-sub-text">{{_i('عميل')}}</span>
                                </tr>
                            </tbody>
                        </table>
                        <div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Countries')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        {{-- <div class="listcardes"> --}}
                        <ul class="scroll-list cards" style="margin-right: 70px;">

                            @foreach ($countries as $count)
                            <li>
                                <h6>{{ $count->title}}</h6>
                            </li>
                            @endforeach
                        </ul>
                        {{-- </div> --}}
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('visits')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <span class="report-big-number">{{ $visitors->count() }}</span>
                                    <span class="report-sub-text">{{_i('زياره')}}</span>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Clint Satisfaction')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <span class="report-big-number">80%</span>
                                    <span class="report-sub-text">{{_i('راضون')}}</span>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Best Seller')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    @foreach ( $best_products as $item)
                                    @foreach ($item as $item2)
                                    <td>{{ $item2->title }}</td>
                                    <td>16</td>
                                    @endforeach
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Best Clints Payment')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    @foreach ( $best_paymant as $item)
                                    @foreach ($item as $item2)
                                    <td>{{ $item2->name }}</td>
                                    <td>16</td>
                                    @endforeach
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Best Clints Ordered')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    @foreach ( $best_clints as $item)
                                    @foreach ($item as $item2)
                                    <td>{{ $item2->name }}</td>
                                    <td>16</td>
                                    @endforeach
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Payment way')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <ul class="scroll-list cards" style="margin-right: 70px;">
                            @foreach ($transaction_types as $tranc)
                            <li>
                                <h6>{{ $tranc->title}}</h6>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
        <div class="col-md-6">
            <!-- round card start -->
            <div class="card">
                <div class="card-header">
                    <h5>{{_i('Shipping Companies')}}</h5>
                    <div class="card-header-right">
                        <i class="icofont icofont-rounded-down"></i>
                        <i class="icofont icofont-close-circled"></i>
                    </div>
                </div>
                <div class="card-block">
                    <div class="row users-card">
                        <ul class="scroll-list cards" style="margin-right: 70px;">
                            @foreach ($shippingcompanies as $comp)
                            <li>
                                <h6>{{ $comp->title}}</h6>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Round card end -->
        </div>
    </div>
    @push('js')
    <script type="text/javascript">
        $(document).ready(function(){
        $('#day').val( moment().format('YYYY-MM-DD'));
        $('.form-control-primary').selectpicker();
        $('#day').daterangepicker({
              autoUpdateInput: false,
              singleDatePicker: true,
              showDropdowns: true,
              opens: 'center',
              locale: {
                  direction: 'rtl',
                  format: 'YYYY-MM-DD',
                  monthNames: [
                    "يناير",
                    "فبراير",
                    "مارس",
                    "إبريل",
                    "مايو",
                    "يونيو",
                    "يوليو",
                    "أغسطس",
                    "سبتمبر",
                    "أكتوبر",
                    "نوفمبر",
                    "ديسمبر"
                ],
                daysOfWeek: [
                   "أحد",
                   "إثنين",
                   "ثلاثاء",
                   "أربعاء",
                   "خميس",
                   "جمعة",
                   "سبت"
               ]
           },
            minDate: "2016-05-01",
            maxDate: moment(),
            startDate: moment()//.subtract(1, 'days')
        });
        $('#day').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        });
        });
        </script>
    @endpush
    @endsection