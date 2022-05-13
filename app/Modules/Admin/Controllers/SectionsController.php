<?php

namespace App\Modules\Admin\Controllers;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Models\Language;
use App\Modules\Admin\Models\CategoryMaster;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\product_details;
use App\Modules\Admin\Models\Section;
use App\Modules\Admin\Models\SectionCategory;
use App\Modules\Admin\Models\SectionData;
use App\Modules\Admin\Models\SectionProducts;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Settings\SuccessPartner;
use App\Service;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Yajra\DataTables\Facades\DataTables;

class SectionsController extends Controller
{
	public function index($section)
	{
		if (request()->ajax()) {

			$query = Section::leftJoin('sections_data', 'sections_data.section_id', 'sections.id')
				->select('sections.*', 'sections_data.title', 'sections_data.description', 'sections_data.lang_id')
				->where('sections_data.lang_id', Lang::getSelectedLangId());

			if ($section == 'home_sections') :
				$query = $query->where('sections.page', 'home');
			elseif ($section == 'categories_sections') :
				$query = $query->where('sections.page', 'categories');
			endif;


			return DataTables::eloquent($query)
				->editColumn('published', function ($query) {
					if ($query->published == 0) {
						return '<div class="badge badge-warning">' . _i('Not Publish') . '</div>';
					} else {
						return '<div class="badge badge-info">' . _i('Published') . '</div>';
					}
				})
				->addColumn('master', function ($query) {

					$master = CategoryMaster::where('section_id', $query->id)->first();
					if ($master != null) {
						$cat = $master->category->title;
					}
					return $cat ?? '';
				})
				// ->addColumn('created_at', function($query){
				// 	return $query->creared_at;
				// })
				->addColumn('action', function ($query) {
					$master = CategoryMaster::where('section_id', $query->id)->first();

					$categories = $query->categories->pluck('id')->toJson();
					$banners = $query->banners->pluck('id')->toJson();
					$services = $query->services->pluck('id')->toJson();
					$partners = $query->partners->pluck('id')->toJson();

					if ($master != null) {
						$html = '<a href ="' . route('settings.sections.edit', $query->id) . '"
						class="btn waves-effect waves-light btn-primary   text-center" title="' . _i("Edit") . '"
						data-id="' . $query->id . '" data-title="' . $query->title . '" data-description="' . $query->description . '" data-type="' . $query->type . '" . data-master ="' . $master->category_id . '".
						data-lang_id="' . $query->lang_id . '" data-total="' . $query->total . '" data-display_order="' . $query->display_order . '" data-published="' . $query->published . '" data-image="' . $query->image . '" data-video="' . $query->video . '" data-categories="' . $categories . '" data-banners="' . $banners . '" data-services="' . $services . '" data-partners="' . $partners . '" data-is_title_displayed="' . $query->is_title_displayed . '"><i class="ti-pencil-alt"></i></a>  &nbsp;' . '
					<form class=" delete"  action="' . route("section.destroy", $query->id) . '"  method="POST" id="delform"
					style="display: inline-block; right: 50px;" >
					<input name="_method" type="hidden" value="DELETE">
					<input type="hidden" name="_token" value="' . csrf_token() . '">
					<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="ti-trash"></i></span></button>
					 </form>
					</div>';
					} else {
						$html = '<a href ="' . route('settings.sections.edit', $query->id) . '"
						class="btn waves-effect waves-light btn-primary   text-center" title="' . _i("Edit") . '"
						data-id="' . $query->id . '" data-title="' . $query->title . '" data-description="' . $query->description . '" data-type="' . $query->type . '"  .
						data-lang_id="' . $query->lang_id . '" data-total="' . $query->total . '" data-display_order="' . $query->display_order . '" data-published="' . $query->published . '" data-image="' . $query->image . '" data-video="' . $query->video . '" data-categories="' . $categories . '" data-banners="' . $banners . '" data-services="' . $services . '" data-partners="' . $partners . '" data-is_title_displayed="' . $query->is_title_displayed . '"><i class="ti-pencil-alt"></i></a>  &nbsp;' . '
					<form class=" delete"  action="' . route("section.destroy", $query->id) . '"  method="POST" id="delform"
					style="display: inline-block; right: 50px;" >
					<input name="_method" type="hidden" value="DELETE">
					<input type="hidden" name="_token" value="' . csrf_token() . '">
					<button type="submit" class="btn btn-danger" title=" ' . _i('Delete') . ' "> <span> <i class="ti-trash"></i></span></button>
					 </form>
					</div>';
					}

					$langs = Language::get();
					$options = '';
					foreach ($langs as $lang) {
						$options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="' . $query->id . '" data-lang="' . $lang->id . '"
						style="display: block; padding: 5px 10px 10px;">' . $lang->title . '</a></li>';
					}
					$html = $html . '
					 <div class="btn-group">
					   <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" ' . _i('Translation') . ' ">
						 <span class="ti ti-settings"></span>
					   </button>
					   <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
						 ' . $options . '
					   </ul>
					 </div> ';

					return $html;
				})
				->rawColumns([
					'action',
					'published',
					'master',
					// 'created_at'
				])
				->make(true);
		}

		$query = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$categories = [];
		Utility::getCategories($query, $categories);


		$banners = Banner::select('banners.*', 'title')
			->join('banners_data', 'banners.id', 'banners_data.banner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('published', 1)
			->get();

		$success_partners = SuccessPartner::select('success_partners.*', 'title')
			->join('success_partners_data', 'success_partners.id', 'success_partners_data.success_partner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();

		$services = Service::select('services.*', 'title')
			->join('services_data', 'services.id', 'services_data.service_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();


		$products = product_details::select('product_details.product_id', 'product_details.title', "categories_data.title as cat")
			->leftJoin('categories_products', 'categories_products.product_id', 'product_details.product_id')
			->leftJoin('categories_data', 'categories_products.category_id', 'categories_data.category_id')
			->where('product_details.lang_id', Lang::getSelectedLangId())
			->where('categories_data.lang_id', Lang::getSelectedLangId())
			->groupBy('product_details.product_id')
			->get();
		//dd($products);
		//return $products;

		// dd($products);
		$languages = Language::get();
		$page_section = $section == 'home_sections' ? 'home' : 'categories';
		return view('admin.settings.sections.' . $section . '.index', compact('products', 'languages', 'categories', 'banners', 'success_partners', 'services', 'page_section'));
	}

	public function create($section)
	{
		$query = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();
		$categories = [];
		Utility::getCategories($query, $categories);
		$parent_cats = $query->pluck('title' ,'id');
//		dd($categories, $parent_cats);
		$banners = Banner::select('banners.*', 'title')
			->join('banners_data', 'banners.id', 'banners_data.banner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('published', 1)
			->get();

		$success_partners = SuccessPartner::select('success_partners.*', 'title')
			->join('success_partners_data', 'success_partners.id', 'success_partners_data.success_partner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();

		$services = Service::select('services.*', 'title')
			->join('services_data', 'services.id', 'services_data.service_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();

		$page_section = $section == 'home_sections' ? 'home' : 'categories';


		return view('admin.settings.sections.include.create', compact('parent_cats', 'categories', 'banners', 'success_partners', 'services', 'page_section'));

	}

	public function edit($id)
	{
		//dd($id);
		$query = Category::select('categories.*', 'title')
			->join('categories_data', 'categories.id', 'categories_data.category_id')
			->where('lang_id', Lang::getSelectedLangId())
			->orderBy('number', 'asc')
			->get();

		$categories = [];
		Utility::getCategories($query, $categories);
		$parent_cats = $query->pluck('title' ,'id');
		$banners = Banner::select('banners.*', 'title')
			->join('banners_data', 'banners.id', 'banners_data.banner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('published', 1)
			->get();

		$success_partners = SuccessPartner::select('success_partners.*', 'title')
			->join('success_partners_data', 'success_partners.id', 'success_partners_data.success_partner_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();

		$services = Service::select('services.*', 'title')
			->join('services_data', 'services.id', 'services_data.service_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('status', 1)
			->get();

		$section = Section::with('sectionProducts.detailes')->find($id);
		//dd($section);
		$bannerss = DB::table('banner_section')->where('section_id', $id)->whereNotNull('banner_id')->get();
		$master = CategoryMaster::where('section_id', $id)->first();
        $SectionCategory = SectionCategory::where('section_id', $id)->pluck('category_id')->toArray();

		return view('admin.settings.sections.include.edit', compact('SectionCategory', 'parent_cats', 'services', 'success_partners', 'banners', 'categories', 'section', 'bannerss', 'master'));
	}

    public function getlang(Request $request)
    {
        $lang = Language::where('id', $request->lang_id)->first();
        if ($lang) {
            return Response::json($lang->title);
        }
    }
	public function store(Request $request, $section)
	{
		// dd($section);
//		  dd($request->all());
		//return $request;
		if (isset($request->video)) {
			$video = str_replace("watch?v=", "/embed" . '/', $request->video);
		}

		if ($section == 'categories') {
			$section = Section::create([

				'is_title_displayed' => $request->is_title_displayed ?? 0,
				'type' => $request->type,
				'total' => $request->total,
				'display_order' => $request->display_order ?? 1,
				'published' => $request->published ?? 0,
				'page' => 'categories',
				'video' => $video ?? null,
			]);
			$section_data = SectionData::create([

				'section_id' => $section->id,
				'title' => $request->title,
				'description' => $request->description,
				'lang_id' => Lang::getSelectedLangId()
			]);

			CategoryMaster::create([
				'section_id' => $section->id,
				'category_id' => $request->mastercategory,
			]);
		} else {
			$section = Section::create([

				'is_title_displayed' => $request->is_title_displayed ?? 0,
				'type' => $request->type,
				'total' => $request->total,
				'display_order' => $request->display_order ?? 1,
				'published' => $request->published ?? 0,
				'page' => 'home',
				'video' => $video ?? null,
			]);
			$section_data = SectionData::create([

				'section_id' => $section->id,
				'title' => $request->title,
				'description' => $request->description,
				'lang_id' => Lang::getSelectedLangId()
			]);
		}

		$section->sectionProducts()->attach($request->products);

		$section->categories()->attach($request->categories);

		try {
			$section->banners()->attach($request->banners);
		} catch (Exception $ex) {
		}
		$section->services()->attach($request->services);
		$section->partners()->attach($request->success_partners);

		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

			$image = $request->file('image');
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$request->image->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->image = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}

		// if ($request->hasFile('video')) {
		// 	$request->validate([
		// 		'video' => 'required|mimes:mp4',
		// 	]);

		// 	$video = $request->file('video');
		// 	$filename = time() . '.' . $video->getClientOriginalExtension();
		// 	$request->video->move(public_path('uploads/sections/' . $section->id), $filename);
		// 	$section->video = '/uploads/sections/' . $section->id . '/' . $filename;
		// 	$section->save();
		// }
		return response()->json("SUCCESS");
	}

	public function update(Request $request)
	{
		//dd($request->all());
		$section = Section::where('id', $request->section_id)->first();
		$section->update([

			'is_title_displayed' => $request->has("is_title_displayed") ? 1 : 0,
			'total' => $request->total,
			'display_order' => $request->display_order,
			'published' => $request->published ?? 0,
			'video' => $request->video ?? null,
		]);
		//	dd($section);
		// save section category master
		if ($section->page == 'categories') {
			$master = CategoryMaster::where('section_id', $request->section_id)->first();
			if ($master != null) {
				$master->update([
					'category_id' => $request->mastercategory,
				]);
			} else {
				CategoryMaster::create([
					'section_id' => $request->section_id,
					'category_id' => $request->mastercategory,
				]);
			}
		}
		if ($request->products != null) {
			SectionProducts::where('section_id', $section->id)->delete();
		}
		$section->sectionProducts()->attach($request->products);

		$section->categories()->sync($request->categories);
		DB::table('banner_section')->where('section_id', $request->section_id)->delete();
        // dd($request->banners);
		$section->banners()->attach($request->banners);
		$section->services()->sync($request->services);
		$section->partners()->sync($request->success_partners);

		if ($request->hasFile('image')) {
			$request->validate([
				'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

			$image = $request->file('image');
			if (File::exists(public_path($section->image))) {
				File::delete(public_path($section->image));
			}
			$filename = time() . '.' . $image->getClientOriginalExtension();
			$request->image->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->image = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}
		if ($request->hasFile('video')) {
			$request->validate([
				'video' => 'required|mimes:mp4',
			]);

			$video = $request->file('video');
			if (File::exists(public_path($section->video))) {
				File::delete(public_path($section->video));
			}
			$filename = time() . '.' . $video->getClientOriginalExtension();
			$request->video->move(public_path('uploads/sections/' . $section->id), $filename);
			$section->video = '/uploads/sections/' . $section->id . '/' . $filename;
			$section->save();
		}
		return response()->json("SUCCESS");
	}

	public function getLangValue(Request $request)
	{
		$rowData = SectionData::where('section_id', $request->id)
			->where('lang_id', $request->lang_id)
			->first(['title', 'description']);
		if (!empty($rowData)) {
			return response()->json(['data' => $rowData]);
		} else {
			return response()->json(['data' => false]);
		}
	}
	// public function autocomplete(Request $request)
	// {
	//     //dd($request->all());
	// 	$products = [];
	// 	// $search = $request->q;
	// 	//  $products = CategoryData::select("id","title")
	// 	// 		 ->where('title','LIKE',"%$search%")
	// 	// 		 ->get();
	// 	$products = category_product::select('categories_products.*')
	// 		->get();
	// 	foreach ($products as $product) {
	// 		$data = product_details::where('product_id', $product->product_id)->where('lang_id', Lang::getSelectedLangId())->select('title')->get();
	// 		$da = CategoryData::where('category_id', $product->category_id)->where('lang_id', Lang::getSelectedLangId())->first();

	// 		$product->product_name = $data  ? $data : '';
	// 		$product->category_name = $da ? $da->title : '';
	// 	}

	// 	if (!empty($products)) {
	// 		return response()->json(['data' => $products]);
	// 	} else {
	// 		return response()->json(['data' => false]);
	// 	}
	// }
	public function autocomplete(Request $request)
	{
		//dd($request->all());
		$products = [];
		if ($request->has('q')) {

			$search = $request->q;
			// $products = product_details::select("product_id","title")
			// ->where('title','LIKE',"%$search%")
			// ->get();

			$products = product_details::select('product_details.product_id', 'product_details.title', "categories_data.title as cat")
				->leftJoin('categories_products', 'categories_products.product_id', 'product_details.product_id')
				->leftJoin('categories_data', 'categories_products.category_id', 'categories_data.category_id')
				->where('product_details.lang_id', Lang::getSelectedLangId())
				->where('categories_data.lang_id', Lang::getSelectedLangId())
				->groupBy('product_details.product_id')
				->where('product_details.title', 'LIKE', "%$search%")
				->get();

		}
		if (!empty($products)) {
			return response()->json($products);
		} else {
			return response()->json(['data' => false]);
		}
	}


	public function storelangTranslation(Request $request)
	{
		$lang_id = Lang::getSelectedLangId();
		$rowData = SectionData::where('section_id', $request->id)
			->where('lang_id', $request->lang_id_data)
			->first();
		if ($rowData !== null) {
			$rowData->update([
				'title' => $request->title,
				'description' => $request->description,
			]);
		} else {
			$parentRow = SectionData::where('section_id', $request->id)->where('lang_id', $lang_id)->first();
			SectionData::create([

				'title' => $request->title,
				'description' => $request->description,
				'lang_id' => $request->lang_id_data,
				'section_id' => $request->id,
			]);
		}
		return response()->json("SUCCESS");
	}

	public function delete($id)
	{
		$section = Section::where('id', $id)->first();
		if (File::exists(public_path($section->image))) {
			File::delete(public_path($section->image));
		}
		$section_data = SectionData::where('section_id', $section->id)->delete();
		$section->categories()->detach();
		CategoryMaster::where('section_id', $id)->delete();
		$section->delete();
		return response(["data" => true]);
	}
}
