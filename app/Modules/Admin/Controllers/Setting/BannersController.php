<?php

namespace App\Modules\Admin\Controllers\Setting;

use App\Bll\Lang;
use App\Bll\Utility;
use App\Http\Controllers\Controller;

use App\Models\Language;
use App\Modules\Admin\Models\Settings\Banner;
use App\Modules\Admin\Models\Settings\BannerData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class BannersController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $query =  Banner::leftJoin('banners_data','banners_data.banner_id','banners.id')
                ->select('banners.*','banners_data.title','banners_data.description','banners_data.lang_id')
                ->where('banners_data.lang_id', Lang::getSelectedLangId());
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
                        data-id="'.$query->id.'" data-title="'.$query->title.'" data-description="'.$query->description.'"
                        data-lang_id="'.$query->lang_id.'" data-link="'.$query->link.'" data-place="'.$query->place.'" data-published="'.$query->published.'" data-image="'.$query->image.'"
                        ><i class="ti-pencil-alt"></i></a>  &nbsp;'.'
                    <form class=" delete"  action="'.route("banner.destroy",$query->id) .'"  method="POST" id="delform"
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
        return view('admin.settings.banners.index' , compact('languages'));
    }

    public function store(Request $request){
        $request['lang_id'] = $request['lang_id'] ?? Language::first()->id;
        $banner = Banner::create([
            'place' => $request->place,
            'link' => $request->link,
            'published' => $request->published ?? 0,
        ]);
        foreach ( Lang::getLanguages()  as $lang) {
        $banner_data = BannerData::create([
            'banner_id' => $banner->id,
            'title' => $request->title,
            'description' => $request->description,
            'lang_id' =>$lang->id
        ]);
        }

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/banners/'.$banner->id), $filename);
            $banner->image = '/uploads/banners/'. $banner->id .'/'. $filename;
            $banner->save();
        }
        return response()->json("SUCCESS");
    }

    public function update(Request $request){
        $banner = Banner::findOrFail($request->banner_id);
        $banner->update([
            'place' => $request->place,
            'link' => $request->link,
            'published' => $request->published ?? 0,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            if (File::exists(public_path($banner->image))) {
                File::delete(public_path($banner->image));
            }
            $filename = time() . '.' . $image->getClientOriginalExtension();
            $request->image->move(public_path('uploads/banners/'.$banner->id), $filename);
            $banner->image = '/uploads/banners/'. $banner->id .'/'. $filename;
            $banner->save();
        }
        return response()->json("SUCCESS");
    }

    public function getLangValue(Request $request){
        $rowData = BannerData::where('banner_id',$request->id)
            ->where('lang_id',$request->lang_id)
            ->first(['title','description']);
        if (!empty($rowData)){
            return response()->json(['data' => $rowData]);
        }else{
            return response()->json(['data' => false]);
        }
    }

    public function storelangTranslation(Request $request){
        $lang_id = Lang::getSelectedLangId();
        $rowData = BannerData::where('banner_id',$request->id)
            ->where('lang_id', $request->lang_id_data)
            ->first();
        if ($rowData !== null) {
            $rowData->update([
                'title' => $request->title,
                'description' => $request->description,
            ]);
        }else{
            $parentRow = BannerData::where('banner_id',$request->id)->where('lang_id' , $lang_id)->first();
            BannerData::create([
                'title' => $request->title,
                'description' => $request->description,
                'lang_id' => $request->lang_id_data,
                'banner_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $banner = Banner::findOrFail($id);
        if (File::exists(public_path($banner->image))) {
            File::delete(public_path($banner->image));
        }
        $banner_data = BannerData::where('banner_id', $banner->id)->delete();
        $banner->delete();
        return response(["data" => true]);
    }
}
