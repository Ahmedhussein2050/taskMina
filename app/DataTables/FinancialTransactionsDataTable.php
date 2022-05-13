<?php


namespace App\DataTables;


use App\Bll\Utility;
use App\Models\product\bank_transfer;
use App\Models\product\orders;
use App\Models\product\transaction_types;
use App\Transaction;
use App\User;
use Yajra\DataTables\Services\DataTable;

class FinancialTransactionsDataTable  extends DataTable
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
            ->addColumn('user' , function($query){
                $order = orders::where('id' , $query->order_id)->where('store_id' , Utility::getStoreId())->first();
                $user = User::where('id' , $order->user_id)->where('store_id' , Utility::getStoreId())->first();
                return $user["name"]." ".$user["lastname"];
            })
            ->addColumn('transaction_type' , function($query){
                if($query->bank_id != null){
                    $bank = bank_transfer::where('id' , $query->bank_id)->where('store_id' , Utility::getStoreId())->first();
                    return $bank["title"];
                }else{
                    $transaction_type = transaction_types::where('id' , $query->type_id)->where('store_id' , Utility::getStoreId())->first();
                    return $transaction_type["title"];
                }

            })
            ->editColumn('total' , function($query){
                return $query["total"] ." ". $query["currency"];
            })
            ->addColumn('action', function ($query){
                if($query->bank_id != null){
                    $html = '<a href="'.url('adminpanel/orders/offline/'.$query->id.'/show').'" target="_blank" class=" btn  btn-primary" title="'._i('Show').'">
                    <i class="ti ti-eye"></i> '._i('Show').'</a>';
                }else{
                    $html = '<a href="'.url('adminpanel/orders/online/'.$query->id.'/show').'" target="_blank" class=" btn  btn-primary" title="'._i('Show').'">
                    <i class="ti ti-eye"></i> '._i('Show').'</a>';
                }

                return $html;
            })
            ->rawColumns([
                'user',
                'bank',
                'action',
            ]);
    }
    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        $query = Transaction::leftJoin('orders','orders.id','transactions.order_id')
            ->select('transactions.*')
            ->where('transactions.store_id' , Utility::getStoreId())
            ->where('orders.type',"product")
            ->orderByDesc('transactions.id');
//        Transaction::query()->orderByDesc('id')
//            // ->where('type_id' ,"!=", null)
//            // ->where('type' , "online")
//            ->where('store_id' , Utility::getStoreId());
        return $query;
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
//                    ->parameters($this->getBuilderParameters());
            ->parameters([
                'dom' => 'Blfrtip',
                'lengthMenu' => [
                    [10,25,50,100,-1],[10,25,50,trans('admin.all_record')]
                ],
                'buttons' => [
                    [
                        'text' =>  _i('Online Transactions'),
                        'className' => 'btn btn-primary create',
//                        'action' => 'function( e, dt, button, config){
//                             window.location = "../user/add";
//                         }',
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
            ['name'=>'id','data'=>'id','title'=>_i('id')],
            ['name'=>'user','data'=>'user','title'=> _i('user')],
            ['name'=>'transaction_type','data'=>'transaction_type','title'=> _i('transaction type')],
            ['name'=>'total','data'=>'total','title'=> _i('total')],
            ['name'=>'status','data'=>'status','title'=> _i('status')],
            // ['name'=>'type','data'=>'type','title'=> _i('type')],
            ['name'=>'action','data'=>'action','title'=> _i('controll'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
        ];
    }
    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'transactions' . date('YmdHis');
    }


}
