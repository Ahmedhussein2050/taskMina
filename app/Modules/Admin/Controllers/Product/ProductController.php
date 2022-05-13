<?php

namespace App\Modules\Admin\Controllers\Product;

use App\Bll\Lang;
use App\Bll\Utility;
use App\DataTables\FlyerDataTable;
use App\DataTables\ProductsDataTable;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Admin\Models\Products\Attribute;
use App\Modules\Admin\Models\Products\AttributeValue;
use App\Modules\Admin\Models\Products\Brand;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Products\countries_data;
use App\Modules\Admin\Models\Products\FlyerData;
use App\Modules\Admin\Models\Products\FlyerImages;
use App\Modules\Admin\Models\Products\Product;
use App\Modules\Admin\Models\Products\ProductCategory;
use App\Modules\Admin\Models\Products\ProductData;
use App\Modules\Admin\Models\Products\ProductImages;
use App\Modules\Admin\Models\Products\ProductInfo;
use App\Modules\Admin\Models\Products\products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class ProductController extends Controller
{

    public function image_show($id)
    {
        $product = products::find($id);
        $image_path = 'uploads/products/' . $product->sku;
        $images = File::glob($image_path . '/*');

        return response()->json(['success' => true, 'data' => $images, 'product' => $product]);
    }

    public function image_save(Request $request, $id)
    {
        $id = $request->product_id;
        $imageExtensions = ['jpg', 'jpeg', 'png', 'PNG', 'JPG', 'JPEG'];
        $fileExtensions = ['zip', 'ZIP'];
        $product = products::find($id);
        $last_Product_image = ProductImages::where('product_id', $product->id)->orderBy('id', 'Desc')->first();

        $file = $request->file('file');

        if (in_array($file->getClientOriginalExtension(), $imageExtensions)) {
            // dd('image');
            if ($file->getClientOriginalExtension())
                $filename = time() . '.' . $file->getClientOriginalExtension();
            $request->file->move(public_path('uploads/products/' . $product->sku), $filename);


            //            $product_image = new ProductImages;
            //            $product_image->image = '/uploads/products/' . $product->sku . '/' . $filename;
            //            $product_image->product_id = $product->id;
            //            $product_image->order = ($last_Product_image) ? $last_Product_image->order + 1 : 1;
            //            $product_image->save();

            return response()->json(['success' => $filename]);
        }
        if (in_array($file->getClientOriginalExtension(), $fileExtensions)) {


            if ($file->getClientOriginalExtension())
                $filename = time() . '.' . $file->getClientOriginalExtension();
            $request->file->move(public_path('uploads/products/compressed/' . $id), $filename);

            $file_src = public_path('uploads/products/compressed/' . $id . '/' . $filename);


            $zip = new ZipArchive();
            $x = $zip->open($file_src);
            if ($x === true) {
                $filenames = $zip->extractTo(public_path('uploads/products/' . $id . '/'));

                $files_list = [];
                for ($i = 0; $i < $zip->numFiles; $i++) {
                    $stat = $zip->statIndex($i);
                    $files_list[] = basename($stat['name']);
                }

                foreach ($files_list as $file) {
                    $exts = pathinfo($file, PATHINFO_EXTENSION);
                    if (in_array($exts, $imageExtensions)) {
                        // dd('image');
                        $product_image = new FlyerImages;
                        $product_image->image = '/uploads/flyers/' . $id . '/' . $file;
                        $product_image->product_id = $product->id;
                        $product_image->order = ($last_Product_image) ? $last_Product_image->order + 1 : 1;
                        $product_image->save();
                    }
                }
            }
            // dd($file_src);
            $zip->close();
            @unlink($file_src);
            return response()->json(['success' => $filename]);
        }
    }

    public function index(ProductsDataTable $products)
    {
        //        dd('asas');
        // $flyers=Flyer::all();
        $countries = countries_data::where('lang_id', Lang::getSelectedLangId())->get()->pluck('title', 'country_id');
        $flyers = FlyerData::where('lang_id', Lang::getSelectedLangId())->get()->pluck('title', 'flyer_id');
        // $categories=CategoryData::where('lang_id',getLang())->get()->pluck('title','category_id');
        //        $test = Category::query()->groupBy('level')->get()->pluck('level');
        //        $again = Category::query()->whereIn('level', $test)->get();
        //        dd($test, $again);
        $categories = Category::with('data')
            ->orderBy('level')
            ->get()
            ->groupBy('level')
            ->map(function ($query) {
                return $query->keyBy('id');
            });
        //        $categories = Category::leftJoin('categories_data', 'categories_data.category_id', 'categories.id')
        //            ->select('categories.*', 'categories_data.title as title', 'categories_data.lang_id as lang_id')
        //            ->orderByDesc('categories.id')
        //            ->where('categories_data.lang_id', Lang::getSelectedLangId())
        //            ->where('categories.container_type', 'products')
        //            ->get();
        //$brands=Brand::all();
        $brands = Brand::select('brands.id', 'brands_data.name')
            ->join('brands_data', 'brands.id', 'brands_data.brand_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->get();
        $classifications = DB::table('classifications')
            ->join('classifications_data', 'classifications.id', 'classifications_data.classification_id')
            ->select('classifications.*', 'classifications_data.title', 'classifications_data.lang_id',)
            ->where('classifications_data.lang_id', Lang::getSelectedLangId())
            ->get();

        $stores = User::query()->get()->pluck('name', 'id');
        $attributes = Attribute::query()
            ->with([
                'Data',
                'Options.translation'
            ])->get();
        //dd($attributes);
        //  dd(countries_data::where('lang_id',getLang())->get()->pluck('country_id','title'));
        return $products->render('admin.products.index', ['flyers' => $flyers, 'stores' => $stores, 'categories' => $categories, 'classifications' => $classifications, 'countries' => $countries, 'brands' => $brands, 'attributes' => $attributes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => ['required', 'max:191'],
            'description' => ['required', 'max:700'],
            'price' => ['required'],
            'brand_id' => ['required'],
            'classification_id' => ['required'],
            'category' => ['required', 'exists:categories,id'],
            'status' => ['required'],
            'sku' => ['required', 'unique:products,sku'],
            'refid' => ['required', 'unique:products,refid'],
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',

        ]);
        if ($validator->passes()) {
            $product = products::create([
                'price' => $request->price,
                'hidden' => $request->status == 'available' ? 0 : 1,
                'brand_id' => $request->brand_id,
                'classification_id' => $request->classification_id,
                'tags' => $request->tags,
                'exclusive' => $request->exclusive,
                'video' => $request->video,
                'sku' => $request->sku,
                'refid' => $request->refid,
                'related' => $request->related,
            ]);

            foreach (Lang::getLanguages() as $lang) {
                ProductData::create([
                    'title' => $request->title,
                    'label' => $request->label,
                    'description' => $request->description,
                    'product_id' => $product->id, 'lang_id' => $lang->id
                ]);
            }
            if ($product && $request->category) {
                foreach ($request->category as $category_id)
                    ProductCategory::query()->create([
                        'product_id' => $product->id,
                        'category_id' => $category_id
                    ]);
            }
            $path = public_path() . '/uploads/products/' . $product->sku;
            File::makeDirectory($path, $mode = 0777, true, true);
            if ($request->image) {
                $file = $request->image;

                $imageName = $product->sku . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('uploads/products/' . $product->sku), $imageName);
            }
            if ($request->attribute != null) {
                foreach ($request->attribute as $key => $value) {
                    if ($value != null) {
                        AttributeValue::create([
                            'attribute_id' => $key,
                            'option_id' => $value,
                            'product_id' => $product->id,
                        ]);
                    }
                }
            }
            return response()->json('success');
        } else {
            return response()->json(['errors' => $validator->errors()]);
        }
    }



    public function edit_product($id)
    {
        $product = products::with('categories', 'Images')->find($id);
        $categories = Category::with('data')
            ->orderBy('level')
            ->get()
            ->groupBy('level')
            ->map(function ($query) {
                return $query->keyBy('id');
            });
        $brands = Brand::select('brands.id', 'brands_data.name')
            ->join('brands_data', 'brands.id', 'brands_data.brand_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->get();
        $classifications = DB::table('classifications')
            ->join('classifications_data', 'classifications.id', 'classifications_data.classification_id')
            ->select('classifications.*', 'classifications_data.title', 'classifications_data.lang_id',)
            ->where('classifications_data.lang_id', Lang::getSelectedLangId())
            ->get();
        $prod_cat = ProductCategory::query()->where('product_id', $id)->get()->pluck('category_id');
        $cats = Category::query()->whereIn('id', $prod_cat)->get();
        $attributes = Attribute::query()
            ->with([
                'Data',
                'Options.value' => function ($query) use ($id) {
                    $query->where('product_id', $id);
                }
            ])->get();
        // dd($attributes);

        return view('admin.products.edit', compact('product', 'cats', 'categories', 'brands', 'classifications', 'attributes'));
    }
    public function update(Request $request, $id)
    {
        //dd($request->all());
        $product = products::query()->find($id);
        $rules = [

            'price' => ['required'],
            //            'brand_id' => ['required'],
            //            'classification_id' => ['required'],
            'status' => ['required'],
            //            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            'sku' => 'required|unique:products,sku,' . $product->id,
            'refid' => 'required|unique:products,refid,' . $product->id,
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }
        if ($request->attribute != null) {
            AttributeValue::where('product_id', $id)->delete();
            foreach ($request->attribute as $key => $value) {
                if ($value != null) {
                    AttributeValue::create([
                        'attribute_id' => $key,
                        'option_id' => $value,
                        'product_id' => $product->id,
                    ]);
                }
            }
        }
        $product->price = $request->price;
        $product->tags  = $request->tags ?: '';
        $product->hidden = $request->status == 'available' ? 0 : 1;
        $product->exclusive = $request->exclusive;
        $product->sku = $request->sku;
        $product->brand_id = $request->brand_id;
        $product->classification_id = $request->class_id;
        $product->refid = $request->refid;
        $product->related = $request->related;
        $arr = ['.jpg', '.png', '.svg', '.jpeg'];
        if ($request->image) {
            foreach ($arr as $ar) {
                $image_path = public_path('uploads/products/' . $product->sku . '/' . $product->sku . $ar);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $file = $request->image;
            $imageName = $product->sku . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products/' . $product->sku), $imageName);
        }
        $product->video = $request->video;
        $product->save();
        if ($product->save() && $request->category) {
            ProductCategory::query()->where('product_id', $id)->delete();
            foreach ($request->category as $category_id)
                ProductCategory::query()->create([
                    'product_id' => $product->id,
                    'category_id' => $category_id
                ]);
        }

        //  return redirect()->back();
        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *


     */
    public function destroy($id)
    {
        $prod = products::query()->where('id', $id)->first();
        if ($prod) {
            $path = 'uploads/products/' . $prod->sku;
            if (URL::asset($path)) {
                File::deleteDirectory(public_path($path));
            }
            ProductData::query()->where('product_id', $id)->delete();

            $prod->delete();
            return \response()->json(_i('success'));
        }
    }

    public function destroy_image($id)
    {
        $product_image = ProductImages::findOrFail($id);
        @unlink(public_path($product_image->image));

        if ($product_image->delete()) {
            return response()->json(['data' => true, 'id' => $id]);
        }
    }

    public function info_store(Request $request)
    {
        // dd($request->new_info);
        $request->validate(['new_info.*' => 'required']);
        ProductInfo::where('product_id', $request->product_id)->delete();
        if ($request->new_info) {
            foreach (Lang::getLanguages() as $lang) {
                foreach ($request->new_info[$lang->id] as $info) {
                    if ($info != '' && $info != null) {
                        $inf = new ProductInfo;
                        $inf->title = $info;
                        $inf->product_id = $request->product_id;
                        $inf->lang_id = $lang->id;

                        $inf->save();
                    }
                    // else{
                    //     return Response::json("error");
                    // }
                }
            }
        }


        return Response::json("SUCCESS");
    }


    public function getTranslations(Request $request)
    {
        dd($request->product_id);
        $rowData = ProductData::where('product_id', $request->product_id)
            ->where('lang_id', $request->lang_id)
            ->first(['title', 'description', 'info', 'label']);
        return response()->json(['data' => $rowData]);
    }

    public function getInfo(Request $request)
    {
        //        dd('asdfg');
        $rowData = ProductInfo::where('product_id', $request->product_id)
            ->get();
        //dd($rowData);
        $language = Lang::getLanguages();
        if (!empty($rowData)) {
            return response()->json(['data' => $rowData, 'langs' => $language]);
        } else {
            return response()->json(['data' => false, 'langs' => $language]);
        }
    }


    public function storeTranslation(Request $request)
    {
        $rowData = ProductData::where('product_id', $request->id)
            ->where('lang_id', $request->lang_id)
            ->first();

        if ($rowData != null) {

            $rowData->title = $request->title;
            $rowData->description = $request->description;
            $rowData->info = $request->info;
            $rowData->update();
        } else {
            ProductData::create([
                'title' => $request->title,
                'description' => $request->description,
                'info' => $request->info,
                'lang_id' => $request->lang_id,
                'product_id' => $request->id
            ]);
        }
        return Response::json("SUCCESS");
    }

    public function dropzoneStore(Request $request)
    {
        $image = $request->file('file');

        $imageName = time() . '.' . $image->extension();
        $image->move(public_path('images'), $imageName);

        return response()->json(['success' => $imageName]);
    }
}
