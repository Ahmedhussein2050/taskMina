<?php

namespace App\Modules\Admin\Controllers\Setting;
use App\Bll\Lang;
use App\BLL\Utility;

use App\DataTables\homepageDataTable;
use App\Http\Controllers\Controller;

use App\Models\Language;
use App\Modules\Admin\Models\Products\Category;
use App\Modules\Admin\Models\Settings\Counter;
use App\Modules\Admin\Models\Settings\Currency;
use App\Modules\Admin\Models\Settings\homepage;
use App\Modules\Admin\Models\Settings\Setting;
use App\Modules\Admin\Models\Settings\SettingsData;
use App\Modules\Admin\Models\Settings\Slider;
use App\Modules\Admin\Models\Settings\SliderData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class  SettingsController extends Controller
{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function getlang(Request $request)
    {
        $lang = Language::where('id',$request->lang_id)->first();
        if ($lang){
            return Response::json($lang->title);
        }
    }

    public function get_settings()
    {
        $site_settings = Setting::leftJoin('settings_data', 'settings.id', '=', 'settings_data.setting_id')
            ->select('settings.*', 'settings_data.title as title', 'settings_data.address as address', 'settings_data.description as description', 'settings_data.lang_id as lang_id')
            ->where('settings_data.lang_id', 1)->first();
        $categories = Category::select('categories.*', 'title')
            ->join('categories_data', 'categories.id', 'categories_data.category_id')
            ->where('lang_id', Lang::getSelectedLangId())
            ->orderBy('number', 'asc')
            ->get();
        $languages = Language::all();
        return view('admin.settings.edit', compact('site_settings', 'categories', 'languages'));
    }

    public function updateSettings(Request $request)
    {
        $settings = Setting::first();
        if ($settings) {
            if ($request->has('logo')) {
                $image = $request->file('logo');

                if ($image && $file = $image->isValid()) {
                    $destinationPath = public_path('uploads/settings/site_settings');
                    $fileName = $image->getClientOriginalName();
                    $image->move($destinationPath, $fileName);
                //    $fileName=  $request->logo  ;

                    if (!empty($settings->logo)) {
                        $file = public_path('uploads/settings/site_settings/') . $settings->logo;

                        @unlink($file);
                    }
                }
                $settings->logo = '/uploads/settings/site_settings/'.$fileName;
            }
            $settings->email = $request->email;
            $settings->phone1 = $request->phone1;
            $settings->phone2 = $request->phone2;
            $settings->facebook_url = $request->facebook_url;
            $settings->instagram_url = $request->instagram_url;
            $settings->twitter_url = $request->twitter_url;
            $settings->youtube_url = $request->youtube_url;
            $settings->app_store_url = $request->app_store_url;
            $settings->google_play_url = $request->google_play_url;
            $settings->work_time = $request->work_time;
            $settings->address = $request->address;
            $settings->location_code = $request->location_code;
            $settings->tax_on_product = $request->product_tax;
            $settings->whats_app = $request->whats_app;
            $settings->contact_us_text = $request->contact_us_text;
            $settings->chat_mode = $request->chat_mode ?? 0;

            $settings->chat_code = $request->chat_code;
            $settings->save();
            Cache::forget('setting');

            return redirect()->back()->with('flash_message', _i('Updated Successfully !'));
        }
    }

    public function getSettingsTranslation(Request $request)
    {
        $rowData = SettingsData::where('lang_id', $request->lang_id)
            ->first(['title','description', 'keywords','address','header_description']);
        if (!empty($rowData)){
            return Response::json(['data' => $rowData]);
        }else{
            return Response::json(['data' => false]);
        }
    }

    public function updateSettingsTranslation(Request $request)
    {
        $rowData = SettingsData::where('lang_id', $request->lang_id)
            ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'address' => $request->address,
                'header_description' => $request->header_description,
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords'),
            ]);
        }else{
            TypeData::create([
                'title' => $request->title,
                'address' => $request->address,
                'header_description' => $request->header_description,
                'description' => $request->input('description'),
                'keywords' => $request->input('keywords'),
                'lang_id' => $request->lang_id,
            ]);
        }
        Cache::forget('setting');

        return \response()->json("SUCCESS");
    }

    //slider

    public function get_sliders()
    {
        $sliders = Slider::leftJoin('sliders_data' ,'sliders_data.slider_id','sliders.id')
        ->select('sliders.*','sliders_data.slider_id','sliders_data.lang_id','sliders_data.source_id',
        'sliders_data.name','sliders_data.description')
        ->where('sliders_data.source_id',null)
        ->where('store_id', session()->get('StoreId'))->get();
        $langs = Language::get();
        return view('allStore.settings.sliders.index', compact('sliders','langs'));
    }


    public function store_slider(Request $request)
    {
        $sessionStore = \App\Bll\Utility::getStoreId();
        if($sessionStore== \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Added Successfully'));
        }

        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'link' => 'required|max:191',
            'description' => 'required|string',
            'image' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg',
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $slider = Slider::create([
                'status'     => $request->status,
                'url'        => $request->link,
                'published'  => $request->published,
                'store_id'   => session('StoreId'),
            ]);

            $image = $request->file('image');

            if ($image && $file = $image->isValid()) {
                $destinationPath = public_path('uploads/settings/sliders/' . $slider->id . '/');
                $extension = $image->getClientOriginalExtension();
                $fileName = $image->getClientOriginalName();
                $image->move($destinationPath, $fileName);
                $request->image = $fileName;
            }

            $slider->image = $request->image;

            $slider_data = SliderData::create([
                'slider_id' => $slider->id,
                'name' => $request->name,
                'description' => $request->description,
                'lang_id' => $request->lang_id,
                'source_id' => null,
            ]);

            $slider->save();
            return redirect()->back()->with('flash_message', _i('Added Successfully !'));
        }

    }

    // make datatable for slider
    public function getDatatableSlider()
    {
        $sliders = Slider::leftJoin('sliders_data' ,'sliders_data.slider_id','sliders.id')
        ->select('sliders.*','sliders_data.slider_id','sliders_data.lang_id','sliders_data.source_id',
        'sliders_data.name','sliders_data.description')
        ->where('sliders_data.source_id',null)
        ->where('store_id', session()->get('StoreId'))->get();
      return DataTables::of($sliders)
        ->addColumn('image', function ($query) {
            $url = asset('/uploads/settings/sliders'.'/'. $query->id .'/'. $query->image);
            return '<img src=' . $url . ' border="0" style=" width: 80px; height: 80px;" class="img-responsive img-rounded" align="center" />';
        })

        ->addColumn('action', function ($sliders) {

         $html = '<a href ='.'/adminpanel/settings/slider/'. $sliders->id . '/edit'.' target="blank"
         class="btn waves-effect waves-light btn-primary edit text-center" title="{{_i("Edit")}}"><i class="ti-pencil-alt"></i></a>  &nbsp;'.'
            <form class=" delete"  action="'.route("slider.destroy",$sliders->id) .'"  method="POST" id="deleteRow"
            style="display: inline-block; right: 50px;" >
            <input name="_method" type="hidden" value="DELETE">
            <input type="hidden" name="_token" value="' . csrf_token() . '">
            <button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="ti-trash"></i></span></button>
             </form>
            </div>';

         $langs = Language::get();
         $options = '';
         foreach ($langs as $lang) {
             if ($lang->id != $sliders->lang_id){
                 $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$sliders->id.'" data-lang="'.$lang->id.'"
             style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
             }
         }
         $html = $html.'
         <div class="btn-group">
           <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown"  title=" '._i('Translation').' ">
             <span class="ti ti-settings"></span>
           </button>
           <ul class="dropdown-menu" style="right: auto; left: 0; width: 5em; " >
             '.$options.'
           </ul>
         </div> ';

         return $html;
        })

        ->rawColumns([
            'action',
            'image',
        ])
        ->make(true);
    }


    public function edit_slider($id)
    {
        $slider = Slider::findOrFail($id);

        $slider_data = SliderData::where('slider_id' , $slider->id)->where('source_id',null)->first();

        $langs = Language::get();



        return view('allStore.settings.sliders.edit_slider', compact('slider_data','langs','slider'));
    }

    public function update_slider(Request $request, $id)
    {

        $sessionStore = \App\Bll\Utility::getStoreId();
        if($sessionStore== \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Added Successfully'));
        }

        $slider = Slider::findOrFail($id);
        $rules = [
            'name' => ['required', 'string', 'max:150'],
            'link' => 'sometimes|max:191',
            'description' => 'sometimes|string',
            'image' => 'image|mimes:jpeg,jpg,png,bmp,gif,svg',
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        if ($request->has('image')) {
            $image = $request->file('image');
            if ($image && $file = $image->isValid()) {
                $destinationPath = public_path('uploads/settings/sliders/' . $slider->id . '/');
                $fileName = $image->getClientOriginalName();
                $image->move($destinationPath, $fileName);
                $request->image = $fileName;
            }
            $slider->image = $request->image;
        }
        if ($request->has('published')) {
            $slider->published = $request->published;
        } else {
            $slider->published = 0;
        }
        $slider->url = $request->link;
        $slider->sort_order = $request->sort_order;
        $slider->status = $request->status;
        $slider->store_id = $sessionStore;
        $slider_data = SliderData::where('slider_id' , $slider->id)->where('source_id',null);
        $slider_data->update([
            'slider_id' => $slider->id,
            'lang_id' => $request['lang_id'],
            'source_id' => null,
            'name' => $request['name'],
            'description' => $request['description'],
        ]);
        $slider->save();
        return redirect('/adminpanel/settings/sliders')->with('flash_message', _i('Updated Successfully !'));
    }

    public function slider_destroy($id)
    {
        $sessionStore = session()->get('StoreId');
        if ($sessionStore == \App\Bll\Utility::$demoId)
            return redirect()->back()->with('success', _i('Deleted Successfully !'));

        $slider = Slider::findOrFail($id);
        $slider->delete();
        $slider_data = SliderData::where('slider_id',$id)->delete();
        return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
    }

    public function slidergetLangvalue(Request $request)
    {

        $rowData = SliderData::where('slider_id',$request->transRow)
        ->where('source_id',"=" , null)
        ->first(['name','description']);
        if (!empty($rowData)){
            return \response()->json(['data' => $rowData]);
        }else{
            return \response()->json(['data' => false]);
        }
    }


    public function sliderstorelangTranslation(Request $request)
    {

        $rowData = SliderData::where('slider_id',$request->id)
            ->where('source_id',"=" , null)
            ->first();
        if ($rowData != null) {

            $rowData->update([
                'name' => $request->name,
                'description' => $request->input('description'),
                'lang_id' => $request->lang_id_data,
            ]);

        }else{
            $parentRow = SliderData::where('slider_id',$request->id)->where('source_id',null)->first();
            SliderData::create([
                'name' => $request->name,
                'description' => $request->input('description'),
                'lang_id' => $request->lang_id_data,
                'slider_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return \response()->json("SUCCESS");
    }



    // make datatable
    public function getDatatableCounter()
    {
        $query = Counter::select(['id', 'title', 'counter']);

        return datatables($query)
            ->addColumn('delete', 'admin.settings.counter.delete')
            ->rawColumns([
                'delete'
            ])
            ->make(true);
    }


    public function store_counter(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:150',
            'counter' => 'required',
            'icon' => 'required|image|mimes:jpeg,jpg,png,bmp,gif,svg',
        ];
        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $counter = Counter::create([
                'title' => $request->title,
                'counter' => $request->counter,
            ]);
            $icon = $request->file('icon');

            if ($icon && $file = $icon->isValid()) {
                $destinationPath = public_path('uploads/settings/counter/' . $counter->id . '/');
                $extension = $icon->getClientOriginalExtension();
                $fileName = $icon->getClientOriginalName();
                $icon->move($destinationPath, $fileName);
                $request->icon = $fileName;
            }

            $counter->icon = $request->icon;
            $counter->save();
            return redirect()->back()->with('flash_message', _i('Added Successfully !'));
        }

    }

    public function edit_counter($id)
    {
        $counter = Counter::findOrFail($id);
        return view('admin.settings.counter.edit_counter', compact('counter'));

    }

    public function update_counter(Request $request, $id)
    {
        $counter = Counter::findOrFail($id);
        $rules = [
            'title' => 'required|string|max:150',
            'counter' => 'required',
            'icon' => 'required|image|mimes:jpeg,jpg,png,bmp,gif,svg',
        ];

        $validator = validator()->make($request->all(), $rules);
        if ($validator->fails())
            return redirect()->back()->withErrors($validator)->withInput();

        if ($request->has('icon')) {
            $image = $request->file('icon');

            if ($image && $file = $image->isValid()) {
                $destinationPath = public_path('uploads/settings/counter/' . $counter->id . '/');
                $fileName = $image->getClientOriginalName();
                $image->move($destinationPath, $fileName);
                $request->icon = $fileName;

                if (!empty($counter->icon)) {
                    //delete old image
                    $file = public_path('uploads/settings/counter/' . $counter->id . '/') . $counter->icon;
                    @unlink($file);
                }
            }
            $counter->icon = $request->icon;
        }
        $counter->title = $request->title;
        $counter->counter = $request->counter;
        $counter->save();
        return redirect()->back()->with('flash_message', _i('Updated Successfully !'));
    }


    public function counter_destroy($id)
    {
        $slider = Counter::findOrFail($id);
        $slider->delete();
        return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
    }

//        end counter



    //currency

    public function get_currency()
    {
        $currency = Currency::where('lang_id', 1)->get();
        return view('allStore.settings.currency.index', compact('currency'));
    }



    public function addCurrency(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $add = new Currency();
        $add->title = $request->title;
        $add->store_id = session()->get('StoreId');
        $add->lang_id = 1;
        $add->save();

        return redirect('/adminpanel/settings/currency')->with('flash_message', _i('added Successfully !'));


    }




    public function editCurrency($id)
    {
        $cuurency = Currency::findOrFail($id);

        return view('allStore.settings.currency.edit_currency', compact('cuurency'));

    }


    public function update_Currency(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ]);

        $add = Currency::findOrFail($request->id);
        $add->title = $request->title;
        $add->save();

        return redirect('adminpanel/settings/currency')->with('flash_message', _i('edited Done'));
    }


    public function currency_destroy($id)
    {
        $currency = Currency::findOrFail($id);
        $currency->delete();
        return redirect()->back()->with('flash_message', _i('Deleted Successfully !'));
    }


    public function currency_active(Request $request)
    {
        if ($request->id) {
            $active = Currency::findOrFail($request->id);
            $active->show = 1;

            $unacive = Currency::where('id', '!=', $request->id)->get();

            foreach ($unacive as $un) {
                $un->show = 0;
                $un->save();
            }
            $active->save();

            session()->flash('flash_message', _i('active updated successfully'));
        }
    }


//    homepage

    public function homepageTable(homepageDataTable $homepageDataTable)
    {
        $categories = Category::where('store_id', session('StoreId'))->pluck('title', 'id');
        return $homepageDataTable->render('admin.settings.homepage.index', compact('categories'));
    }

    public function homepagestore(Request $request)
    {
        $request->request->add(['store_id' => session('StoreId')]);
        $data = $this->validate($request, [
            'category_id' => 'required',
            'sort' => 'required',
            'template' => 'required',
            'store_id' => 'required',
        ]);
        homepage::create($data);
        return back()->with('flash_message', _i('success save'));
    }

    public function homepageupdate(Request $request, $id)
    {
        $homepage = homepage::findOrFail($id);
        $data = $this->validate($request, [
            'category_id' => 'required',
            'sort' => 'required',
            'template' => 'required',
        ]);
        $homepage->update($data);
        return back()->with('flash_message', _i('success update'));
    }

    public function homepagedelete(Request $request, $id)
    {
        $homepage = homepage::findOrFail($id);
        $homepage->delete();
        return back()->with('flash_message', _i('success delete'));
    }

    public function connectServices()
    {
        return view('admin.settings.connectServices.index');
    }

    public function products()
    {
        $settings = Setting::findOrFail(1);
        $settings_data = SettingsData::where('lang_id', Lang::getSelectedLangId())->get()->first();
        return view('admin.settings.products.index', compact('settings', 'settings_data'));
    }

    public function updateProducts(Request $request, $id)
    {
        $request->validate([
            'products_per_page_admin' => 'required',
            'products_per_page_website' => 'required',
        ]);

        $settings = Setting::findOrFail(1);

        Setting::where('id', 1)->update([
            'products_per_page_admin' => $request->products_per_page_admin,
            'products_per_page_website' => $request->products_per_page_website,
        ]);

        return response()->json('SUCCESS');
    }

    public function chat()
    {
        $settings = Setting::findOrFail(1);
        $settings_data = SettingsData::where('lang_id', Lang::getSelectedLangId())->get()->first();
        return view('admin.settings.chat.index', compact('settings', 'settings_data'));
    }

    public function updateChat(Request $request, $id)
    {
        $request->validate([
            'products_per_page_admin' => 'required',
            'products_per_page_website' => 'required',
        ]);

        $settings = Setting::findOrFail(1);

        Setting::where('id', 1)->update([
            'products_per_page_admin' => $request->products_per_page_admin,
            'products_per_page_website' => $request->products_per_page_website,
        ]);

        return response()->json('SUCCESS');
    }
}
