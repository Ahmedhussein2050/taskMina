<?php

namespace App\Modules\Admin\Controllers\Categories;

use App\Bll\Lang;
use App\Bll\Utility;

use App\DataTables\categoryDataTable;
use App\DataTables\DiscountCodeDataTable;
use App\DataTables\OfferDataTable;
use App\Http\Controllers\Controller;

use App\Models\User;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\CategoryData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
	public function index(categoryDataTable $categoryDataTable) {
 		$categories = $category_tree = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('type', 'main_Category')
			->where('lang_id', Lang::getSelectedLangId())
            ->select('categories.*', 'categories_data.title')
			->orderBy('number', 'asc')
			->get();
        $categories_of_sub_categories = $category_tree = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('container_type', 'sub_categories')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();
      //  dd($categories_of_sub_categories );
        $categories_of_brands = $category_tree = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('container_type', 'brands')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();



		$users = User::get();

		return $categoryDataTable->render('admin.category.index' , compact('categories','categories_of_sub_categories','categories_of_brands','users'));
	}

	public function store(Request $request) {
 		if($request->ajax()) {
			$validator = Validator::make($request->all(), [
				'title' => 'required',
                'level' => 'required',
                'cover' => ['required_if:type,==,brand','image','mimes:jpeg,jpg,png,bmp,gif,svg,jfif'],
            ]);
			if ($validator->fails()) {
				return Response::json([false,'errors'=>$validator->errors()->all()]);
			} else {
				$category = Category::create([
					'type' => $request->type,
					'level' => $request->level,
					'container_type' => $request->container_type,

				]);
//                if ($request->type == 'main_category'){
//                    $category->parent_id=null;
//                }
//                if ($request->type == 'sub_category'){
//                    $category->parent_id=$request->sub_parent_id;
//                }
//                if ($request->type == 'brand'){
//                    $category->parent_id=$request->brand_parent_id;
//                }
                if ($request->hasFile('cover')) {

                    $image_file = $request->file('cover');
                    $filename = time() . '.' . $image_file->getClientOriginalExtension();
                    $request->cover->move(public_path('uploads/categories/' . $category->id), $filename);
                    $category->icon = '/uploads/categories/' . $category->id . '/' . $filename;
                    $category->save();
                }
                $categories_data = CategoryData::create([
                    'category_id' => $category->id,
                    'title' => $request->title,
                    'lang_id' => Lang::getSelectedLangId(),
                ]);
				return Response::json(true);
			}
		}
	}

	public function update(Request $request,$id) {
		if($request->ajax()) {
			$category =  Category::findOrFail($id);
            $validator = Validator::make($request->all(), [

            ]);
			if ($validator->fails()) {
				return Response::json([false,'errors'=>$validator->errors()->all()]);
			}
			else
			{
                $category->type = $request->type;
                $category->container_type = $request->container_type;
//                if ($request->type == 'main_category'){
//                    $category->parent_id=null;
//                }
//                if ($request->type == 'sub_category'){
//                    $category->parent_id=$request->sub_parent_id;
//                }
//                if ($request->type == 'brand'){
//                    $category->parent_id=$request->brand_parent_id;
//                }
                if ($request->hasFile('cover')) {
                    $file = public_path($category->cover);
                    @unlink($file);
                    $image_file = $request->file('cover');
                    $filename = time() . '.' . $image_file->getClientOriginalExtension();
                    $request->cover->move(public_path('uploads/categories/' . $category->id), $filename);
                    $category->icon = '/uploads/categories/' . $category->id . '/' . $filename;
                    $category->save();
                }
                $category->save();
				return Response::json(true);
			}
		}
	}

	public function destroy ($id)
	{
		$category =  Category::findOrFail($id);
		$data = CategoryData::where('category_id', $category->id)->delete();
        $file = public_path($category->icone);
        @unlink($file);


        $category->delete();
		return redirect()->back()->with('flash_message',  _i('Deleted Succesfully'));
	}


    public function getTranslation(Request $request)
    {
        $rowData = CategoryData::where('category_id', $request->category_id)
            ->where('lang_id', $request->lang_id)
            ->first(['title']);

        if (!empty($rowData)){
            return response()->json(['data' => $rowData]);
        }else{
            return response()->json(['data' => false]);
        }
    }



    public function storeTranslation(Request $request)
    {
        $rowData = CategoryData::where('category_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();

        if ($rowData != null) {

            $rowData->title=$request->title;
            $rowData->update();
        }else{
            CategoryData::create([
                'title' => $request->title,
                'lang_id' => $request->lang_id,
                'category_id' => $request->id
            ]);
        }
        return Response::json("SUCCESS");
    }

}
