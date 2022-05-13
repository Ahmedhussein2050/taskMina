<?php

namespace App\DataTables;

use App\Models\countries;
use App\User;
use Yajra\DataTables\Services\DataTable;

class countriesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        if(request()->segment(1) == 'master'){
            return datatables($query->where('lang_id',getLang()))
                ->addColumn('logo', function ($query) {
                    $url = asset($query->logo);
                    return '<img src='.$url.' border="0" class="img-responsive img-rounded" align="center" />';
//                return '<img src='.$url.' border="0" width="100px" height="80px" class="img-rounded" align="center" />';
                })
                ->addColumn('delete', 'master.country.btn.delete')
                ->rawColumns([
                    'delete',
                    'logo'
                ]);
        }else{
            return datatables($query->where('lang_id',getLang()))
                ->addColumn('logo', function ($query) {
                    $url = asset($query->logo);
                    return '<img src='.$url.' border="0" class="img-responsive img-rounded" style="width:80px; height:80;" align="center" />';
//                return '<img src='.$url.' border="0" width="100px" height="80px" class="img-rounded" align="center" />';
                })
                ->addColumn('delete', 'admin.country.btn.delete')
                ->rawColumns([
                    'delete',
                    'logo'
                ]);
        }

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(countries $model)
    {
        return $model->query()->leftJoin('countries_data', 'countries_data.country_id', 'countries.id')
            ->select('countries.id as id', 'countries.code as code', 'countries_data.title as title','countries.created_at as created_at','countries.logo as logo')
            ->orderByDesc('countries.id');
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
            ['name'=>'countries_data.title','data'=>'title','title'=> _i('title')],
            ['name'=>'code','data'=>'code','title'=> _i('code')],
            ['name'=>'logo','data'=>'logo','title'=> _i('logo')],
            ['name'=>'created_at','data'=>'created_at','title'=> _i('created_at')],
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
