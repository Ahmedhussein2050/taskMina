<?php

namespace App\DataTables;

use App\Bll\Lang;

use App\Modules\Admin\Models\Products\Product;
use Yajra\DataTables\Services\DataTable;

class ProductsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {

//dd($query->get());
            return datatables($query->where('lang_id',Lang::getSelectedLangId()))
                ->addColumn('image', function ($query) {
                    $url = asset($query->image);
                    return '<img src='.$url.' border="0" class="img-responsive img-rounded" style="width:80px; height:80;" align="center" />';
//                return '<img src='.$url.' border="0" width="100px" height="80px" class="img-rounded" align="center" />';
                })
                ->addColumn('delete', 'admin.products.btn.delete')
                ->rawColumns([
                    'delete',
                    'image'
                ]);


    }

    /**
     * Get query source of dataTable.
     *

     */
    public function query(Product $model)
    {

        return $model->query()->leftJoin('product_details', 'product_details.product_id', 'products.id')
            ->select('products.*', 'product_details.title as title','product_details.lang_id as lang_id')
            ->orderByDesc('products.id');


//        return countries::query()->orderByDesc('id');
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
                            [10,25,50,100,-1],[10,25,50,trans('admin.all_record')]
                        ],
                        'buttons' => [
                            [
//                                'text' => '<i class="ti-plus"></i> ' . _i('add new country'),
//                                'className' => 'btn btn-primary create',
//                                'action' => 'function( e, dt, button, config){
//                                             window.location = "";
//                                         }',
                            ],
                            ['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="ti-printer"></i>'],
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
                        //                "language" =>  self::lang(),
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
//            ['name'=>'id','data'=>'id','title'=> _i('ID')],
            ['name'=>'product_details.title','data'=>'title','title'=> _i('title')],
            ['name'=>'sku','data'=>'sku','title'=> _i('SKU')],
            ['name'=>'refid','data'=>'refid','title'=> _i('REF ID')],
            ['name'=>'created_at','data'=>'created_at','title'=> _i('created_at')],
    //            ['name'=>'start_date','data'=>'start_date','title'=> _i('start_date')],
    //            ['name'=>'end_date','data'=>'end_date','title'=> _i('end_date')],
    //            ['name'=>'flyer_period','data'=>'period','title'=> _i('flyer_period')],
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
        return 'countries_' . date('YmdHis');
    }
}
