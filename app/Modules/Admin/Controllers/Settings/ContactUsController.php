<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\Bll\Utility;
use App\DataTables\ContactDataTable;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Modules\Admin\Models\countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class ContactUsController extends Controller
{

    public function index(ContactDataTable $contact)
    {

        return $contact->render('admin.contacts.all');
    }

    public function show($id)
    {
        $contact = Contact::findOrFail($id);
        $storeId = \App\Bll\Utility::getStoreId();
        if($contact->store_id != $storeId){
            return redirect()->back()->with('error_message', _i('Sorry, this page is not allowed to access'));
        }
        $country = countries::leftJoin('countries_data','countries_data.country_id','countries.id')
            ->select('countries.id as id','countries_data.title as title','countries_data.lang_id')
             ->where('countries_data.lang_id' , Lang::getSelectedLangId())
            ->first();
       // $country = countries::where('id' , $contact->country_id)->first();
        return view('admin.contacts.show' ,compact('contact' , 'country'));
    }

    public function delete($id)
    {
        $sessionStore = session()->get('StoreId');
        if($sessionStore == \App\Bll\Utility::$demoId){
            return redirect()->back()->with('flash_message' , _i('Deleted Successfully'));
        }

        $contact = Contact::findOrFail($id);
        $contact->delete();
        return redirect('/admin/contact/all')->with('success',_i('Deleted Successfully !'));
    }
}
