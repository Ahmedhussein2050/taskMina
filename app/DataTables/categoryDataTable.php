<?php

namespace App\DataTables;


use App\Bll\Lang;
use App\Modules\Admin\Models\Products\Category;

use Yajra\DataTables\Services\DataTable;

class categoryDataTable extends DataTable
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
         return datatables($query)
//            ->addColumn('edit', function($query){
//                return '<a href="category/'.$query->id.'/edit" class="btn btn-icon waves-effect waves-light btn-primary" title="Edit">
//                            <i class="fa fa-edit"></i> </a>';
//            })
            ->addColumn('delete', 'admin.category.btn.delete')
            ->addColumn('name', function($query){
                return '<span style="color: '.$query->color.';">'.$query->name.'</span>';
            })
            ->rawColumns([
                'delete',
                'name',
            ]);
    }

    /**
     * Get query source of dataTable.
     *

     */
    public function query(Category $category)
    {

        $cat = $category
                    ->select('categories.*', 'categories_data.title', 'categories_data.lang_id')
                    ->join('categories_data', 'categories_data.category_id', 'categories.id')
                    ->where('categories_data.lang_id', Lang::getSelectedLangId())
                    ->orderBy('categories.id', 'DESC')->get()
//            ->where('categories.type', 'main_category')
                    ;
        return $cat;

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
                            [10,25,50,100,-1],[10,25,50,_i('All Records')]
                        ],
                        'buttons' => [
                            [
                                'text' => '<i class="ti-plus"></i> ' . _i('add new Category'),
                                'className' => 'btn btn-lg  btn-success create',
                            ],
                            // ['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="ti-printer"></i>'],
                            // ['extend' => 'excel','className' => 'btn btn-success' , 'text' => '<i class="fa fa-file"></i> ' . trans('admin.EXCEL')]
                        ]
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
            ['name'=>'title','data'=>'title','title'=> _i('title')],
            ['name'=>'level','data'=>'level','title'=> _i('level')],
//            ['name'=>'edit','data'=>'edit','title'=>'edit','printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
            ['name'=>'delete','data'=>'delete','title'=>_i('Edit & Delete'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
        ];
    }


    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'category_' . date('YmdHis');
    }
}
