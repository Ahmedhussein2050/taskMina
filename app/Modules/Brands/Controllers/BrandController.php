<?php


namespace App\Modules\Brands\Controllers;
use App\Bll\Lang;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Products\Brand;
use App\Modules\Admin\Models\Products\BrandData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;


class BrandController extends Controller

{

	public function index()
	{


		if (request()->ajax()) {
			$brands = Brand::leftJoin('brands_data' ,'brands_data.brand_id','brands.id')
				->select('brands.*','brands_data.brand_id','brands_data.lang_id', 'brands_data.name','brands_data.description')
				->where('brands_data.lang_id' , Lang::getSelectedLangId())->get();

			return DataTables::of($brands)
				->addColumn('image', function ($query) {
					$url = asset($query->image);
					return '<img src=' . $url . ' border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />';
				})
				->editColumn('published', function($query) {
					if ($query->published == 0){
						return '<div class="badge badge-warning">'. _i('Not Publish') .'</div>';
					}else {
						return '<div class="badge badge-info">'. _i('Published') .'</div>';
					}
				})
				->addColumn('action', function ($brands) {
					$html = '<a href ='. route('brands.edit', $brands->id) .' class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"><i class="ti-pencil-alt"></i></a>  &nbsp;'.'
						<a href="'.route('brands.destroy', $brands->id).'" data-remote="'.route('brands.destroy', $brands->id).'" class="btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i></a>
					</div>';

				$languages = Language::get();
				$options = '';
				foreach ($languages as $lang) {
					$options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$brands->id.'" data-lang="'.$lang->id.'" style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
				}
				$html = $html.'
				<div class="btn-group">
				   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
						<span class="ti ti-settings"></span>
					</button>
					<ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >'.$options.'</ul>
				 </div> ';
				 return $html;
			})
			->rawColumns([
				'action',
				'image',
				'published',
			])
			->make(true);
		}

        return view('brands.index');
	//	return view('admin.brands.index');
	}

	public function create()
	{
         return view('brands.create',['languages' => Language::all()]);
		//return view('admin.brands.create', ['languages' => Language::all()]);
	}

	public function store(Request $request)
	{
		$rules = [
			'name' => ['required', 'string', 'max:150'],
		    //'link' => ['required', 'max:191'],
			'image' => ['image', 'mimes:jpeg,jpg,png,bmp,gif,svg'],
		];

		$validator = validator()->make($request->all(), $rules);
		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		} else {
			$brand = Brand::create([

		//	    'link' => $request->link,
				'published' => $request->published??0,
			]);

			if ($request->hasFile('image')) {
				$request->validate([
					'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
				]);

				$image = $request->file('image');
				$filename = time() . '.' . $image->getClientOriginalExtension();
				$request->image->move(public_path('uploads/brands/'.$brand->id), $filename);
				$brand->image = '/uploads/brands/'. $brand->id .'/'. $filename;
				$brand->save();
			}

			$brand_data = BrandData::create([

				'brand_id' => $brand->id,
				'name' => $request->name,
				'description' => $request->description,
				'lang_id' => $request->lang_id,
			]);

			$brand->save();

			return redirect(route('brands.index'))->with('success', _i('Added Successfully !'));
		}
	}

	public function show($id)
	{

	}

	public function edit($id)
	{
		$brand = Brand::where('id' , $id)->first();
		$brand_data = BrandData::where('brand_id' , $brand->id)->where('lang_id', Lang::getSelectedLangId())->first();
		if($brand_data){
			$brand_data = BrandData::where('brand_id' , $brand->id)->where('lang_id', Lang::getSelectedLangId())->first();
		}else{
			$brand_data = BrandData::where('brand_id' , $brand->id)->first();
		}
		$languages = Language::get();

        return view('brands.edit',compact('brand','brand_data','languages'));
		//return view('admin.brands.edit',compact('brand','brand_data','languages'));
	}

	public function update(Request $request, $id)
	{
		$brand = Brand::where('id', $id)->first();
		$rules = [
		//	'link' => 'sometimes|max:191',
			'image' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg',
		];

		$validator = validator()->make($request->all(), $rules);
		if ($validator->fails())
		{
			return redirect()->back()->withErrors($validator)->withInput();
		}

		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

			$image = $request->file('image');
			if (File::exists(public_path($brand->image))) {
				File::delete(public_path($brand->image));
			}

			$filename = time() . '.' . $image->getClientOriginalExtension();
			$request->image->move(public_path('uploads/brands/'.$brand->id), $filename);
			$brand->image = '/uploads/brands/'. $brand->id .'/'. $filename;
			$brand->save();
		}

		if ($request->has('published')) {
			$brand->published = $request->published;
		} else {
			$brand->published = 0;
		}

		$brand->link = $request->link;

		$brand->save();
		return redirect()->back()->with('success', _i('Updated Successfully !'));
	}


	public function destroy($id)
	{
        $brand = Brand::where('id' , $id)->first();
        $brand->delete();
        $brand_data = BrandData::where('brand_id',$id)->delete();
        return redirect()->back()->with('success', _i('Deleted Successfully !'));
	}

	public function getTranslation(Request $request)
	{
		$rowData = BrandData::where('brand_id', $request->transRow)
			->where('lang_id', $request->lang_id)

			->first(['name','description']);
		if (!empty($rowData)){
			return response()->json(['data' => $rowData]);
		}else{
			return response()->json(['data' => false]);
		}
	}

	public function storeTranslation(Request $request)
	{
		$rowData = BrandData::where('brand_id', $request->id)
			->where('lang_id' , $request->lang_id)

			->first();
		if ($rowData != null) {
			$rowData->update([
				'name' => $request->name,
				'description' => $request->input('description'),
			]);
		}else{
			BrandData::create([

				'name' => $request->name,
				'description' => $request->input('description'),
				'lang_id' => $request->lang_id,
				'brand_id' => $request->id
			]);
		}
		return response()->json("SUCCESS");
	}

}
