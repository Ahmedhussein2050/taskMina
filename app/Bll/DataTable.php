<?php

namespace App\Bll;

use http\Env\Request;
use Illuminate\Support\Facades\DB;

class DataTable
{
    public function __construct($elequent)
    {
        $this->elequent = $elequent;
    }
    private $columns = null, $search_columns=[];
    public function columns($cols)
    {
        $this->columns = $cols;
    }
    public function search($cols)
    {
        $this->search_columns = $cols;
    }
    public function response()
    {
        $request = request();
        $limit = $request->length;
        $draw = $request->draw;
        $offset = ($request->start);
        //search[value]: pendi
        $search = $request->search;
        $search = $search["value"];
        if ($search != null)
            $this->elequent->Where(function ($q) use ($search, $request) {
                foreach ($request->columns as $column) {

                    if ($column["searchable"] != null && ($column["searchable"]) === "true") {

                        if ($this->columns != null) {
                            $result = preg_grep('~' . $column["data"] . '~', $this->columns);

                            foreach ($result as $item) {

                                //  dd($item);
                                //    $this->elequent->orWhere($item, "like", "%" . $search . "%");
                                $q->orWhere($item, "like", "%" . $search . "%");
                            }
                        } else {
                            $q->orWhere($column["data"], "like", "%" . $search . "%");
                        }
                    }
                }
                //  $q->where($column["data"], "like", "%" . $search . "%");
            });



        // if ($search != null)
        // DB::enableQueryLog(); // Enable query log

        // Your Eloquent query executed by using get()

//        $total = $this->elequent->get();
        $result = $this->map();
        $total = $result['total'];

        // if ($search != null)
        // dd(DB::getQueryLog()); // Show results of log

        //order[0][column]: 1
        //order[0][dir]: asc
        $arr = ($request->order)[0];
        $colIndex = $arr["column"];
        $by = $arr["dir"];
        //columns[0][data]
        $column = $request->columns[$colIndex]["data"];

//        $query = $this->elequent->orderBy($column, $by)->offset($offset)->limit($limit)->get();
        $query = $result['query'];
        $total = count($total);

        return  response()->json([
            "draw" => $draw,
            "recordsTotal" => $total,
            "recordsFiltered" => $total,
            "data" => ($query),
        ], 200);
    }
    
    public function map(): array
    {
        $request = request();
        $total = $this->elequent->get();
        $query = $this->elequent
            ->orderBy($request->columns[($request->order)[0]["column"]]["data"], ($request->order)[0]['dir'])
            ->offset($request->start)->limit($request->length)->get();
        return [
            'query' => $query,
            'total' => $total
        ];
    }
}