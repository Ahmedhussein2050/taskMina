<?php

namespace App\DataTables;

use App\TicketPriority;
use App\User;
use Yajra\DataTables\Services\DataTable;

class PriorityDataTable extends DataTable
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
		   ->addColumn('display_order', function($query)
		   {
		   		$html = "<label class='label label-success'>".$query->display_order."</label>";
		   		$html .= "<label class='label label-info pointer reorder' data-type='down' data-id='".$query->id."' data-order='".$query->display_order."'><i class='ti-arrow-down'></i></label>";
		   		$html .= "<label class='label label-info pointer reorder' data-type='up' data-id='".$query->id."' data-order='".$query->display_order."'><i class='ti-arrow-up'></i></label>";
		   		return $html;
		   })
			->addColumn('delete', 'admin.ticket.priorities.btn.delete')
			->addColumn('name', function($query){
				return '<span style="color: '.$query->color.';">'.$query->name.'</span>';
			})
			->rawColumns([
				'display_order',
				'delete',
				'name',
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(TicketPriority $priority)
	{
		return $priority
					->select('ticket_priorities.id', 'ticket_priorities.color', 'ticket_priorities.display_order', 'ticket_priorities.created_at', 'ticket_priorities.updated_at', 'ticket_priorities_data.name', 'ticket_priorities_data.description', 'ticket_priorities_data.lang_id')
					->join('ticket_priorities_data', 'ticket_priorities_data.ticket_priority_id', 'ticket_priorities.id')
					->where('ticket_priorities_data.lang_id', getLang())
					->orderBy('ticket_priorities.display_order', 'ASC');
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
			['name'=>'id','data'=>'id','title'=> _i('id')],
			['name'=>'name','data'=>'name','title'=> _i('name')],
			['name'=>'display_order','data'=>'display_order','title'=> _i('Order')],
//            ['name'=>'edit','data'=>'edit','title'=>'edit','printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
			['name'=>'delete','data'=>'delete','title'=>_i('Options'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
		];
	}


	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename()
	{
		return 'priority_' . date('YmdHis');
	}
}
