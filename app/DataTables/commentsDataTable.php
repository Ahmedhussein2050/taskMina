<?php

namespace App\DataTables;

use App\Comment;
use App\Bll\Utility;
use App\Models\rating\userRating;
use App\User;
use Yajra\DataTables\Services\DataTable;

class commentsDataTable extends DataTable
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
			->addColumn('username',function ($query){
				return $query->user !== null ? $query->user->name : _i('Visitor');
			})
			->editColumn('published',function ($query){
				$url = route('comments.approve', $query->id);
				return $query->published == 0 ? "<label class='label label-default btn approve' data-url='".$url."'>" . _i('Approve') . "</label>" : "<label class='label label-info btn approve' data-url='".$url."'><i class='ti-check'> </i>" . _i('Approved') . "</label>";
			})
			/*->addColumn('rating', function($query) {
				if ($query->rating != null){
					return '<div class="star-ratings-css">
					  <div class="star-ratings-css-top" style="width: '.$query->rating * 20 .'%"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
					  <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
					</div>';
				}else{
					return '<div class="star-ratings-css">
					  <div class="star-ratings-css-top" style="width: 0"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
					  <div class="star-ratings-css-bottom"><span>★</span><span>★</span><span>★</span><span>★</span><span>★</span></div>
					</div>';
				}
			})*/
			->addColumn('comment', function ($query){
				return $query->comment;
			 })
			->addColumn('delete', 'admin.settings.comments.btn.delete')
			->rawColumns([
				'username',
				'published',
				'comment',
				'delete',
			]);
	}

	/**
	 * Get query source of dataTable.
	 *
	 * @param \App\User $model
	 * @return \Illuminate\Database\Eloquent\Builder
	 */
	public function query(Comment $model)
	{
		return Comment::query()->whereNull('comment_id')->orderByDesc('id');
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
							[10,25,50,100,-1],[10,25,50, 100,trans('admin.all_record')]
						],
						'buttons' => [
							['extend' => 'print','className' => 'btn btn-primary' , 'text' => '<i class="ti-printer"></i>', 'exportOptions' => ['columns' => [ 0, 1, 2 ]]],
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
			['name'=>'username','data'=>'username','title'=>_i('username')],
			//['name'=>'rating','data'=>'rating','title'=>_i('rating')],
			['name'=>'published','data'=>'published','title'=>_i('approve')],
			['name'=>'comment','data'=>'comment','title'=>_i('comment')],
			['name'=>'delete','data'=>'delete','title'=>_i('delete'),'printable'=>false,'exportable'=>false,'orderable'=>false,'searchable'=>false],
		];
	}

	/**
	 * Get filename for export.
	 *
	 * @return string
	 */
	protected function filename()
	{
		return 'comments_' . date('YmdHis');
	}
}
