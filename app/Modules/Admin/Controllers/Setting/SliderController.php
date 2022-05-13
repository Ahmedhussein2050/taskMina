<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Settings\Slider;
use App\Modules\Admin\Models\Settings\SliderData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            $query = Slider::leftJoin('sliders_data','sliders_data.slider_id','sliders.id')
                ->select('sliders.*','sliders_data.name','sliders_data.description','sliders_data.lang_id')
                ->where('sliders_data.lang_id', Lang::getSelectedLangId());
            return DataTables::eloquent($query)
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
                ->addColumn('action' ,function($query) {
                    $html = '<a href ="#" data-toggle="modal" data-target="#modal-edit"
                        class="btn waves-effect waves-light btn-primary edit text-center" title="'._i("Edit").'"
                        data-id="'.$query->id.'" data-name="'.$query->name.'" data-description="'.$query->description.'"
                        data-lang_id="'.$query->lang_id.'" data-url="'.$query->url.'" data-published="'.$query->published.'" data-image="'.$query->image.'"
                        ><i class="ti-pencil-alt"></i></a>  &nbsp;'.'
                    <form class=" delete"  action="'.route("admin_slider.destroy",$query->id) .'"  method="POST" id="delform"
                    style="display: inline-block; right: 50px;" >
                    <input name="_method" type="hidden" value="DELETE">
                    <input type="hidden" name="_token" value="' . csrf_token() . '">
                    <button type="submit" class="btn btn-danger" title=" '._i('Delete').' "> <span> <i class="ti-trash"></i></span></button>
                     </form>
                    </div>';

                    $langs = Language::get();
                    $options = '';
                    foreach ($langs as $lang) {
                        $options .= '<li ><a href="#" data-toggle="modal" data-target="#langedit" class="lang_ex" data-id="'.$query->id.'" data-lang="'.$lang->id.'"
                        style="display: block; padding: 5px 10px 10px;">'.$lang->title.'</a></li>';
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
                    'published',
                ])
                ->make(true);
        }

        $languages = Language::get();
        return view('admin.settings.sliders.index' , compact('languages'));
    }

    public function store(Request $request){
        $request['lang_id'] = $request['lang_id'] ?? Language::first()->id;
        $slider = Slider::create([
            'url' => $request->url,
            'published' => $request->published ?? 0,
            'store_id' => Utility::getStoreId()
        ]);
        foreach ( Lang::getLanguages()  as $lang) {
            $slider_data = SliderData::create([
                'slider_id' => $slider->id,
                'name' => $request->name,
                'description' => $request->description,
                'lang_id' => $lang->id
            ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/sliders/'.$slider->id), $filename);
            $slider->image = '/uploads/sliders/'. $slider->id .'/'. $filename;
            $slider->save();
        }
        return \response()->json("SUCCESS");
    }

    public function update(Request $request){
        $slider = Slider::findOrFail($request->slider_id);
        $slider->update([
            'url' => $request->url,
            'published' => $request->published ?? 0,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (File::exists(public_path($slider->image))) {
                File::delete(public_path($slider->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/sliders/'.$slider->id), $filename);
            $slider->image = '/uploads/sliders/'. $slider->id .'/'. $filename;
            $slider->save();
        }
        return \response()->json("SUCCESS");
    }

    public function getLangValue(Request $request){
        $rowData = SliderData::where('slider_id',$request->id)
            ->where('lang_id',$request->lang_id)
            ->first(['name','description']);
        if (!empty($rowData)){
            return \response()->json(['data' => $rowData]);
        }else{
            return \response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request){
        $lang_id = Lang::getSelectedLangId();
        $rowData = SliderData::where('slider_id',$request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null) {
            $rowData->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        }else{
            $parentRow = SliderData::where('slider_id',$request->id)->where('lang_id' , $lang_id)->first();
            SliderData::create([
                'name' => $request->name,
                'description' => $request->description,
                'lang_id' => $request->lang_id_data,
                'slider_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return \response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $slider = Slider::findOrFail($id);
        if (File::exists(public_path($slider->image))) {
            File::delete(public_path($slider->image));
        }
        $slider_data = SliderData::where('slider_id', $slider->id)->delete();
        $slider->delete();
        return response(["data" => true]);
    }
}
