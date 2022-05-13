<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Settings\Items;
use App\Modules\Admin\Models\Settings\ItemsData;
use App\Modules\Admin\Models\Settings\ItemsList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
 use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ListItemsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (request()->ajax()) {
            if($request->has('list'))
            {
                if($request->list == 0)
                {
//                    $items = Items::get();
                    $items = Items::leftJoin('items_data', 'items_data.item_id', 'items.id')
                        ->select('items.*', 'items_data.name as name','items_data.lang_id as ')
                        ->orderByDesc('items.id')
                        ->where('items_data.lang_id',Lang::getSelectedLangId());
                }
                else
                {
                    $list = ItemsList::find($request->list);
                    $items = $list->items()->get();
                    // dd($emails);
                }
            }
            else
            {
//                $items = Items::get();
                $items = Items::leftJoin('items_data', 'items_data.item_id', 'items.id')
                    ->select('items.*', 'items_data.name as name','items_data.lang_id as ')
                    ->orderByDesc('items.id')
                    ->where('items_data.lang_id',Lang::getSelectedLangId());
            }

  //dd($items->get());
            return DataTables::of($items)
                ->addColumn('list', function ($item) {
                     return $item->list? $item->list->name : '' ;
                })
                ->addColumn('actions', function ($item) {
                      $lists = $item->list->list_id;
                    $lan='';
                    $langs = Language::get();
                    foreach ( $langs  as $lang){
                        $lan.='<li ><a href="#" data-toggle="modal" data-target="#itemlangedit" class="lang_ex_item" data-id="'.$item->id.'" data-lang="'.$lang->id.'" style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
                    }
                    return '<a href="'.route('list_items.update', $item->id).'" class="color-white btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'" data-email="'.$item->name.'" data-lists="'.$lists.'" data-category_id="'.$item->category_id.'" data-link="'.$item->link.'" data-id="'.$item->id.'"  data-toggle="modal" data-target="#edit-email-modal"><i class="ti-pencil-alt center"></i> '._i("Edit").'</a> <a href="'.route('list_items.destroy', $item->id).'" data-remote="'.route('list_items.destroy', $item->id).'" class="color-white btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i> '._i("Delete").'</a>'.
                        '<button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
                             <span class="ti ti-settings"></span>
                         </button>'.
                        '<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >'.


                        $lan


                        .'</ul>'

                        ;
                })
                ->rawColumns([
                    'actions',
                    'list'
                ])
                ->make(true);
        }


        $items = Items::leftJoin('items_data', 'items_data.item_id', 'items.id')
            ->select('items.*', 'items_data.name as name','items_data.lang_id as ')
            ->orderByDesc('items.id')
            ->where('items_data.lang_id',Lang::getSelectedLangId())->get();
        $lists = ItemsList::join('lists_data', 'lists_data.list_id', 'lists.id')
            ->select('lists_data.name', 'lists.id', 'lists.order')
            ->where('lists_data.lang_id', Lang::getSelectedLangId())
            ->get();

         $categories=Category::leftJoin('categories_data', 'categories_data.category_id', 'categories.id')
            ->select('categories.*', 'categories_data.title as title','categories_data.lang_id as lang_id')
            ->orderByDesc('categories.id')
             ->where('categories_data.lang_id',Lang::getSelectedLangId())
            ->get();
          return view('admin.settings.list.index', compact('items', 'lists','categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function getTranslation(Request $request)
    {
        $rowData = ItemsData::where('item_id', $request->item_id)
            ->where('lang_id', $request->lang_id)
            ->first(['name']);


        if (!empty($rowData)){
            return response()->json(['data' => $rowData]);
        }else{
            return response()->json(['data' => false]);
        }
    }



    public function storeTranslation(Request $request)
    {
        $rowData = ItemsData::where('item_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {

            $rowData->name=$request->name;
            $rowData->update();
        }else{
            ItemsData::create([
                'name' => $request->name,
                'lang_id' => $request->lang_id,
                'item_id' => $request->id
            ]);
        }
        return Response::json("SUCCESS");
    }


    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => ['required'],
             'link' => 'required_if:type,==,link',
         ]);

        if ($validator->passes()) {
            $item = Items::create([
                'order' => $request->order,
                'type' => $request->type,
                'list_id' => $request->lists,

            ]);
            if ($request->type == 'link')
            {
                $item->link = $request->link;
            }
            elseif ($request->type == 'category')
            {
                $item->category_id = $request->category_id;
            }
            $langs =Language::get();
            $item->save();
            foreach ($langs  as $lang) {
                ItemsData::create([
                    'name' => $request->name,
                    'lang_id' => $lang->id,
                    'item_id' => $item->id,
                ]);
            }
            // $item->lists()->sync($request->lists);

            return response()->json(true);
        }
        return response()->json(['errors' => $validator->errors()]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request)
    {
        //dd($request->all());
        $item = Items::findOrFail($request->id);
        $validator = Validator::make($request->all(), [
            'title' => 'required',
             'link' => 'required_if:type,==,link',
             'category_id' => 'required_if:type,==,category'
        ]);

        if ($validator->passes()) {


            if ($request->category_id != null)
            {
                $item->category_id = $request->category_id;
            }
            if ($request->link != null)
            {
                $item->link = $request->link;
            }

            $item->lists()->sync($request->lists);
            $item->save();
          $data =  ItemsData::where('item_id',$request->id)->where('lang_id',getLang())->first();
          $data->update(['name'=>$request->title]);
            return response()->json(true);
        }
        return response()->json(['errors' => $validator->errors()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Items::findOrFail($id);
        $item->delete();
        return response()->json(true);
    }


}
