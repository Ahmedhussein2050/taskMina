<?php

namespace App\DataTables;

use App\Help\Utility;
use App\Orders;
use App\User;
use App\OrderStatus;
use App\Models\countries;
use App\Models\Contact;
use Yajra\DataTables\Services\DataTable;

class OrderRequestDataTable extends DataTable
{
    private function select($key, $value){
        if ($key == $value){
            return 'selected';
        }
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */

    public function dataTable($query)
    {
        return datatables($query)
            ->addColumn('delete', 'admin.order_request.btn.delete')
            ->addColumn('status_update', function ($query) {

                $status =   OrderStatus::where('code','!=','refund')->get();
                $html ='<select id="order_status" data-id="' . $query->id . '"> ' . _i("update") . '   
                                        <option disabled selected> ' . _i("status") . ' </option> ';
                foreach($status as $sta){
                if($query->order_status == $sta->id){
                        $var ="selected";
                }else{
                        $var = '';
                }
                        $html .= '<option value="'.$sta->id.'" '.$var.'> ' . $sta->code . ' </option>';
                        
                
                }
                $html .= '</select>';
                return $html;
               
            })
            ->addColumn('sync', function ($q) {
                
                if ($q->sync == 'success') {
                    return _i('success');
                } else {
                    return '<a href class=" btn btn-info"><i class="fa fa-send"></i>' . _i('re-Sync') . '</a>';
                }
            })
            ->addColumn('name', function ($q) {
                $user = User::query()->find($q->user_id);
                return $user->first_name.' '.$user->last_name;
            })
            ->rawColumns([
                'name', 'sync', 'delete', 'status_update'
            ]);


    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Orders $model)
    {
//        $user = $model->query()
//            ->join('users', 'users.id', 'orders.user_id')
//            ->leftJoin('order_sync', 'order_sync.order_id', 'orders.id')
//            ->select('orders.*', 'users.*', 'order_sync.status as sync')->get();
//        dd($user);
        return $model->query()
            ->join('users', 'users.id', 'orders.user_id')
            ->leftJoin('order_sync', 'order_sync.order_id', 'orders.id')
            ->select('orders.*', 'users.first_name','users.last_name', 'users.email', 'users.phone_number', 'order_sync.status as sync');
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
                    [10, 25, 50, 100, -1], [10, 25, 50, _i('all record')]
                ],
                'buttons' => [
                    ['extend' => 'print', 'className' => 'btn btn-primary', 'text' => '<i class="ti-printer"></i>'],
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
            ['name' => 'id', 'data' => 'id', 'title' => _i('ID')],
            ['name' => 'name', 'data' => 'name', 'title' => _i('Name')],
            ['name' => 'email', 'data' => 'email', 'title' => _i('E-mail')],
            ['name' => 'phone_number', 'data' => 'phone_number', 'title' => _i('Phone')],
            ['name' => 'status', 'data' => 'status', 'title' => _i('status')],
            ['name' => 'sync', 'data' => 'sync', 'title' => _i('sync status')],
            ['name' => 'created_at', 'data' => 'created_at', 'title' => _i('created_at')],
            ['name' => 'delete', 'data' => 'delete', 'title' => _i('Show/Delete'), 'printable' => false, 'exportable' => false, 'orderable' => false, 'searchable' => false],
            ['name' => 'status_update', 'data' => 'status_update', 'title' => _i('status update'),
                'printable' => false,
                'exportable' => false,
                'orderable' => false,
                'searchable' => false],
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Contact_' . date('YmdHis');
    }
}
