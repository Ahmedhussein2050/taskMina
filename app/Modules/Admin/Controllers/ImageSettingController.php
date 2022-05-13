<?php

namespace App\Modules\Admin\Controllers;

use App\DefaultImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageSettingController extends Controller
{
    public function index(Request $request)
    {
        $images = DefaultImage::first();
        $images->favicon = asset('/uploads/default_images/' . $images->favicon);
        $images->header = asset('/uploads/default_images/' . $images->header);
        $images->footer = asset('/uploads/default_images/' . $images->footer);
        $images->not_found = asset('/uploads/default_images/' . $images->not_found);
        return view('admin.default_images.index' , compact('images'));
    }

    public function edit( $name, $id, Request $request )
    {
        //dd($request->all());
        if($request->image) {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
            ]);

            $default_images =  DefaultImage::find($id);
            $image_name = 'uploads/default_images/'.$default_images->$name;
            $image_path = public_path($image_name);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = public_path().'/uploads/default_images/';// . get_store_id();
            $image = request('image');
            $image_name = time() . '.' . request('image')->extension();
            $image->move($path , $image_name);
            $image_in_db = $image_name;
            $default_images->$name = $image_in_db;
            $default_images->save();
        }
        return back();
    }
}
