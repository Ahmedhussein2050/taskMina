<?php

namespace App\Modules\Orders\Controllers;


use App\Modules\Orders\Models\PaymentGate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class PaymentGetwaysController extends Controller
{



    public function index()
    {

		$getways =PaymentGate::where('status', 1)->get();
        return view('admin.gateways.index', compact('getways'));
    }
    public function updateLogo(Request $request){
		$geteway = PaymentGate::where('id',$request->id)->first();

		$image   = $request->file("image");
 		$imageName = time() . '.' . $image->getClientOriginalExtension();

 		$request->file("image")->move(public_path('uploads/site/payment_gates'), $imageName);
		$geteway->update([
			'image' => '/uploads/site/payment_gates/' . $imageName,
		]);

		return redirect()->back()->with('success', _i('Updated Successfully !'));
	}


}
