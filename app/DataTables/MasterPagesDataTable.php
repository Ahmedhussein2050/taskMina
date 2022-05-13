<?php

namespace App\DataTables;

use App\Help\Utility;
use App\Models\Pages\Page;
use App\Models\Pages\PageData;
use App\Models\Language;
use Yajra\DataTables\Services\DataTable;

class MasterPagesDataTable extends DataTable
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
            
            ->editColumn('published', function($query) {
                return $query->published == 1 ? _i('Published') : _i('Not Published');
            })
            ->addColumn('edit', function($query){
                $html = '<a href="#" data-toggle="modal" data-target="#get_link" data-link="'.url($query->code.'/pages/'.$query->id).'" class="btn btn-default get_link"  title="' . _i("Show Link") . '">
                   <i class="ti-link"></i></a>  &nbsp;'.'';
                $html .= '<a href="'. url('master/pages/'.$query->id.'/edit') .'" id="item_id_' . $query->id . '" class="btn btn-primary"  title="' . _i("Edit") . '">
                   <i class="ti-pencil-alt"></i></a>  &nbsp;'.'
                   <form class=" delete"  action="'.url("master/pages/".$query->id) .'"  method="POST" id="deleteRow"  
                   style="display: inline-block; right: 50px;" > 
                   <input name="_method" type="hidden" value="DELETE">
                   <input type="hidden" name="_token" value="' . csrf_token() . '">
                   <button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="ti-trash"></i></span></button>
                    </form>
                   </div>';

                $langs = Language::get();
                $options = '';
                foreach ($langs as $lang) {
                    if ($lang->id != $query->lang_id){
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$query->id.'" data-lang="'.$lang->id.'"
                    style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
                    }
                }
                $html = $html.'
                <div class="btn-group">
                  <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
                    <span class="ti ti-settings"></span>
                  </button>
                  <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
                    '.$options.'
                  </ul>
                </div> ';

                return $html;
            })

            //->addColumn('delete', 'admin.articles.article.btn.delete')
            ->rawColumns([
                'edit',
                'delete',
                'show',
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query( )
    {
        $query = Page::join('pages_data' ,'pages_data.page_id','pages.id')
                ->leftJoin("languages","languages.id","pages_data.lang_id")
            ->select('pages.*','pages_data.page_id','pages_data.lang_id','pages_data.source_id',
                'pages_data.title','pages_data.content',"languages.code")->where('pages_data.source_id' , null);
                
        
            return $query->whereNull('store_id');
        
    }


//    public static function lang(){
//        $langJson = [
//            "title"=> _i('title'),
//            "sZeroRecords"=> trans('admin.sZeroRecords'),
//            "sEmptyTable"=> trans('admin.sEmptyTable'),
//            "sInfoFiltered"=> trans('admin.sInfoFiltered'),
//            "sSearch"=> trans('admin.sSearch'),
//            "sUrl"=> trans('admin.sUrl'),
//            "sInfoThousands"=> trans('admin.sInfoThousands'),
//            "sLoadingRecords"=> trans('admin.sLoadingRecords'),
//            "oPaginate"=> [
//                "sFirst"=> trans('admin.sFirst'),
//                "sLast"=> trans('admin.sLast'),
//                "sNext"=> trans('admin.sNext'),
//                "sPrevious"=> trans('admin.sPrevious')
//            ],
//            "oAria"=> [
//                "sSortAscending"=> trans('admin.sSortAscending'),
//                "sSortDescending"=> trans('admin.sSortDescending')
//            ]
//        ];
//        return $langJson;
//    }



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
                    [10,25,50,100,-1],[10,25,50,_i('all record')]
                ],
                'buttons' => [
                    [
                        'text' => '<i class="ti-plus"></i> '._i('Add Page').' ',
                        'className' => 'btn btn-primary create',
                        'action' => 'function( e, dt, button, config){
                        window.location = "'.url('master/pages/create').'";}',
                    ],
                    ['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="ti-printer"></i>'],
                    ['extend' => 'excel','className' => 'btn btn-success' , 'text' => '<i class="fa fa-file"></i> ' . _i('admin.EXCEL')],
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
            ['name'=>'id','data'=>'id','title'=>_i('ID')],
            ['name'=>'title','data'=>'title','title'=>_i('Title')],
            // ['name'=>'img_url','data'=>'img_url','title'=>_i('Image')],
            // ['name'=>'category_id','data'=>'category_id','title'=>_i('Category Name')],
            ['name'=>'published','data'=>'published','title'=>_i('Published')],
            //['name'=>'created_at','data'=>'created_at','title'=>_i('Create Time')],
            ['name'=>'edit','data'=>'edit','title'=>_i('Controll'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
           // ['name'=>'delete','data'=>'delete','title'=>_i('Delete'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
            //['name'=>'show','data'=>'show','title'=>_i('show'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'pages_' . date('YmdHis');
    }
}
