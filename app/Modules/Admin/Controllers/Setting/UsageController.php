<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\Settings\SliderData;
use App\Modules\Admin\Models\Settings\Usage;
use App\Modules\Admin\Models\Settings\UsageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class UsageController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query = Usage::leftJoin('usages_data','usages_data.usage_id','usages.id')
                ->select('usages.*','usages_data.name','usages_data.description','usages_data.lang_id')
                ->where('usages_data.lang_id', Lang::getSelectedLangId());
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
                    <form class=" delete"  action="'.route("usages.destroy",$query->id) .'"  method="POST" id="delform"
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
        return view('admin.settings.usages.index' , compact('languages'));
    }

    public function store(Request $request){

        $request['lang_id'] = $request['lang_id'] ?? Language::first()->id;
        $usage = Usage::create([
            'published' => $request->published ?? 0,
        ]);

        $usage_data = UsageData::create([
            'usage_id' => $usage->id,
            'name' => $request->name,
            'description' => $request->description,
            'lang_id' => $request['lang_id']
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/usages/'.$usage->id), $filename);
            $usage->image = '/uploads/usages/'. $usage->id .'/'. $filename;
            $usage->save();
        }
        return \response()->json("SUCCESS");
    }

    public function update(Request $request){
        $usage = Usage::findOrFail($request->slider_id);
        $usage->update([
            'published' => $request->published ?? 0,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (File::exists(public_path($usage->image))) {
                File::delete(public_path($usage->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/usages/'.$usage->id), $filename);
            $usage->image = '/uploads/usages/'. $usage->id .'/'. $filename;
            $usage->save();
        }
        return \response()->json("SUCCESS");
    }

    public function getLangValue(Request $request){
        $rowData = UsageData::where('usage_id',$request->id)
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
        $rowData = UsageData::where('usage_id',$request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null) {
            $rowData->update([
                'name' => $request->name,
                'description' => $request->description,
            ]);
        }else{
            $parentRow = UsageData::where('usage_id',$request->id)->where('lang_id' , $lang_id)->first();
            SliderData::create([
                'name' => $request->name,
                'description' => $request->description,
                'lang_id' => $request->lang_id_data,
                'usage_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return \response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $usage = Usage::findOrFail($id);
        if (File::exists(public_path($usage->image))) {
            File::delete(public_path($usage->image));
        }
        $usage_data = UsageData::where('usage_id', $usage->id)->delete();
        $usage->delete();
        return response(["data" => true]);
    }
}
