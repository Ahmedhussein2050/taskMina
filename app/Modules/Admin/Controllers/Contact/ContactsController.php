<?php

namespace App\Modules\Admin\Controllers\Contact;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\Language;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContactsController extends Controller
{
    protected function index(){
        $contacts = Contact::all();
        if (request()->ajax()) {
            return DataTables::of($contacts)
                ->addColumn('option', function ($query){
                    $html = '<a class="btn btn-info mx-1" href="'.route('contacts.show', $query->id).'"> <i class="fa fa-eye"></i></a>';
                    $html .= '<a  class="btn btn-danger mx-1" href="'.route('contacts.delete', $query->id).'"><i class="ti-trash"></i></a>';
                    return $html;
                })
                ->rawColumns([
                    'option'
                ])
                ->make(true);
        }
        return view('admin.contacts.index');
    }
    protected function show($id){
        $contact = Contact::query()->find($id);
        return view('admin.contacts.show', compact('contact'));
    }
    protected function delete($id){
        Contact::query()->find($id)->delete();
        session()->flash('message', _i('deleted successfully'));
        return redirect('admin/contacts');
    }
}
