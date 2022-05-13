<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\ImageAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ImageAccountController extends Controller
{
    public function edit(Request $request )
    {
        if($request->image) {
            $image_account =  ImageAccount::find($request->id);
            $image_name = 'uploads/image_accounts/'.$image_account->image_account;
            $image_path = public_path($image_name);
            if(File::exists($image_path)) {
                File::delete($image_path);
            }
            $path = public_path().'/uploads/image_accounts/' ;
            $image = request('image');
            $image_name = time() . '.' . request('image')->extension();
            $image->move($path , $image_name);
            $image_in_db = $image_name;
            $image_account->image_account = $image_in_db;
            $image_account->save();
        }
        return back();
    }

}
