<?php

namespace App\DataTables;

use App\Bll\Utility;
use App\Models\product\discount_code;
use App\Offer;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class OfferDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('delete', 'admin.offer.btn.delete')

            ->addColumn('cover', function ($query) {
                $url = asset($query->cover);
                return '<img src='.$url.' border="0" class="img-responsive img-rounded" align="center" style="width:80px; height:80;" align="center" />';
            })

            ->editColumn('status', function($query) {
                if ($query->status == 0){
                    return '<div class="badge badge-warning">'. _i('Disabled') .'</div>';
                }else {
                    return '<div class="badge badge-info">'. _i('Enabled') .'</div>';
                }
            })
            ->editColumn('type', function($query) {
                if ($query->type == 'link'){
                    return '<div class="badge badge-inverse-primary">'. _i('Link') .':  '.$query->link.'</div>';
                }else {
                    return '<div class="badge badge-inverse-info">'. _i('Code')  .' :  '.$query->code.'</div>';
                }
            })
            ->addColumn('created_at', function ($query) {
                return date('d M y h:i A', strtotime($query->created_at));
            })
            ->rawColumns([
                'delete',
                'type',
                'status',
                'created_at',
                'cover',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\DiscountCode $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Offer $model)
    {
        return $model->query()
            ->leftJoin('offers_data', 'offers_data.offer_id','offers.id')
            //->where('discount_codes_items.discount_id', 'discount_codes.id')
            ->select('offers.*','offers_data.title as title' ,'offers_data.label as label')

            ->where('lang_id',getLang())
            ->groupBy('offers.id');
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters([
                'dom' => 'Blfrtip',
                'lengthMenu' => [
                    [10,25,50,100,-1],[10,25,50, _i('all records')]
                ],
                'buttons' => [
                    [
                        'text' => '<i class="ti-plus"></i> ' . _i('add new Offer'),
                        'className' => 'btn btn-lg  btn-success create',
                    ],
                ],
                "initComplete" => "function () {
                this.api().columns([]).every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup', function () {
                        var val = $.fn.dataTable.util.escapeRegex($(this).val());

                        column.search(val ? val : '', true, false).draw();
                    });
                });
                }",
            ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            ['name'=>'offers_data.title','data'=>'title','title'=>_i('Title')],
            ['name'=>'cover','data'=>'cover','title'=> _i('cover')],

            ['name'=>'offers_data.label','data'=>'label','title'=> _i('label')],
//            ['name'=>'discount','data'=>'discount','title'=> _i('discount')],
//            ['name'=>'count','data'=>'count','title'=> _i('Count')],
            ['name'=>'status','data'=>'status','title'=> _i('Status')],
            ['name'=>'type','data'=>'type','title'=> _i('Type')],
            ['name'=>'created_at','data'=>'created_at','title'=>_i('created_at')],
            ['name'=>'delete','data'=>'delete','title'=> _i('Edit/Delete') ,'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'DiscountCode_' . date('YmdHis');
    }
}
