<?php

namespace App\Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Response;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class LanguageController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('admin.language.index', ['title' => _i('Language')]);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
				$rules = [
						'title' =>  array('required', 'max:255', 'unique:languages'),
						'code' =>  array('required', 'max:10', 'unique:languages'),
						'flag' =>  array('required', 'max:10', 'unique:languages'),
				];
				$validator = validator()->make($request->all(), $rules);

				if($validator->fails()){
						return redirect()->back()->withErrors($validator)->withInput();
				}else{
						$permission = Language::create(['title' => $request->title, 'code' => $request->code, 'flag' => $request->flag]);
						return redirect()->back()->with('success' ,_i('Added Successfully !'));
				}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$language = Language::findOrFail($request->id);

		$rules = [
			'title' =>  array('required', 'max:255', Rule::unique('languages')->ignore($request->id)),
			'code' =>  array('required', 'max:10', Rule::unique('languages')->ignore($request->id)),
			'flag' =>  array('required', 'max:10', Rule::unique('languages')->ignore($request->id)),
		];

		$validator = validator()->make($request->all() , $rules);
		if($validator->fails()){
			return redirect()->back()->withErrors($validator)->withInput();
		}else{
			$language->update(['title' => $request->title, 'code' => $request->code, 'flag' => $request->flag]);
		}
		session()->flash('success',_i('Updated Successfully'));
		return redirect()->back()->with('success' ,_i('Updated Successfully !'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$language = Language::findOrFail($id);
		$language->delete();
		session()->flash('success',_i('Deleted Successfully !'));
		return redirect('/admin/language')
			->with('success',_i('Deleted Successfully !'));
	}

	public function dataTable()
	{
		$language = Language::select(['id', 'title', 'code', 'flag' ,'created_at', 'updated_at']);

		return DataTables::of($language)
			->addColumn('action', function ($language) {
				return'<button class="btn waves-effect waves-light btn-primary edit text-center" data-id ="'.$language->id.'" data-title ="'.$language->title.'" data-code ="'.$language->code.'" data-flag ="'.$language->flag.'" data-toggle="modal" data-target="#edit"  title="'._i("Edit").'"><i class="ti-pencil-alt"></i> </button>' ."&nbsp;&nbsp;&nbsp;".
					'<a href="'.route('language.destroy', $language->id).'" data-remote="'.route('language.destroy', $language->id).'" class="btn btn-delete waves-effect waves-light btn btn-danger text-center" title="'._i("Delete").'"><i class="ti-trash center"></i> </a>';
			})
			->make(true);
	}

	public function getLang(Request $request)
	{
		$lang = Language::where('id', $request->input('lang_id'))->first();
		if ($lang){
			return response()->json($lang->title);
		}
	}
}
