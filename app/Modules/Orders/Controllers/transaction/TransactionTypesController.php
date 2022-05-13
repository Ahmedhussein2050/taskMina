<?php

namespace App\Modules\Orders\Controllers\transaction;

use App\Bll\Lang;
use App\Bll\MyFatoorah;
use App\DataTables\transactionTypeDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Orders\Models\transaction_types;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionTypesController extends Controller
{
    public function index(transactionTypeDataTable $transactionType){
        return $transactionType->render('admin.transaction.transactionType.index');
    }
    public function create(){
        return view('admin.transaction.transactionType.create');
    }
    public function store(Request $request){
        $request->request->add([]);
        $data = $this->validate($request,[
            'title' => 'required',
            'code' => 'sometimes',
            'main' => 'required',
            'status' => 'required',

        ]);
        $sessionStore = MyFatoorah::get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Added Successfully'));
        }
        $type = transaction_types::create($data);
        $type->lang_id = Lang::getLang(session('adminlang'));
        $type->save();
        return redirect()->back()->with('flash_message','success add');
    }
    public function edit(Request $request,$id){
        $transaction_types = transaction_types::where('id' , $id)->first();
        $data = $this->validate($request,[
            'title' => 'required|'.Rule::unique('transaction_types')->ignore($transaction_types->id),
            'code' => 'sometimes',
            'main' => 'required',
            'status' => 'required',
        ]);
        $sessionStore = MyFatoorah::get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Updated Successfully'));
        }
        $transaction_types->update($data);
        return redirect()->back()->with('flash_message',_i('success update'));
    }
    public function destroy(Request $request){

        $sessionStore = MyFatoorah::get_store_id();
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Deleted Successfully'));
        }

        $id = $request->id;
        $transaction_types = transaction_types::where('id' , $id)->first();
        $transaction_types->delete();
        return redirect()->back()->with('flash_message',_i('success delete'));
    }
}
