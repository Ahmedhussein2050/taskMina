<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Settings\Items;
use App\Modules\Admin\Models\Settings\ItemsList;
use App\Modules\Admin\Models\Settings\ItemsListData;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class ItemsListController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
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
	public function store(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'name' => ['required'],
			'order' => ['required'],
		]);

		if ($validator->passes()) {
			$list = ItemsList::create(['order'=>$request->order]);

            foreach (Lang::getLanguages()  as $lang) {
                ItemsListData::create([
                    'name' => $request->name,
                    'list_id' => $list->id,
                    'lang_id' => $lang->id,
                ]);
            }
            $list->items()->attach($request->items);

			return response()->json(true);
		}

		return response()->json(['errors' => $validator->errors()]);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
        $items = Items::get();
        $list = ItemsList::find($id);
        $list_items = $list->items->pluck('id')->toarray();
        return view('admin.list.ajax.edit_list', compact('items', 'list', 'list_items'));
	}



    public function getTranslation(Request $request)
    {
        $rowData = ItemsListData::where('list_id', $request->list_id)
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
        $rowData = ItemsListData::where('list_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();

        if ($rowData != null) {

            $rowData->name=$request->name;
            $rowData->update();
        }else{
            ItemsListData::create([
                'name' => $request->name,
                'lang_id' => $request->lang_id,
                'list_id' => $request->id
            ]);
        }
        return Response::json("SUCCESS");
    }

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
        $list = ItemsList::findOrFail($id);



		$request->items = $request->items ?? [];

        $list->items()->sync($request->items);

        $list->update(['order' => $request->order]);

        return response()->json(true);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
        $list = ItemsList::findOrFail($id);
        $list->items()->detach();
        $list->delete();
        return response()->json(true);
	}
}
