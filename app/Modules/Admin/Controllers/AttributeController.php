<?php

namespace App\Modules\Admin\Controllers;

use Exception;
use App\Bll\Lang;
use App\Bll\Utility;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\Products\Attribute;
use Illuminate\Contracts\View\Factory;
use Yajra\DataTables\Facades\DataTables;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use App\Modules\Admin\Models\Products\AttributeData;
use App\Modules\Admin\Models\Products\AttributeValue;
use App\Modules\Admin\Models\Products\AttributeOption;
use App\Modules\Admin\Models\Products\AttributeOptionData;
use App\Modules\Admin\Models\Products\Category;

class AttributeController extends Controller
{
    /**
     * @param Request $request
     * @return Application|Factory|View
     * @throws Exception
     */
    protected function index(Request $request)
    {
        $category = Category::query()
            ->with('Data')
            ->where('id', $request->id)
            ->first();
        $languages = Language::all();
        $attributes = Attribute::query()
            ->with([
                'Data',
                'Options.Data',
            ])

            ->get();
        if ($request->ajax()) {
            return DataTables::of($attributes)
                ->addColumn('title', function ($query) {
                    $data = $query->Data->where('lang_id', Lang::getSelectedLangId())->first();
                    if ($data == null) {
                        $data = $query->Data->first();
                    }
                    return $data->title;
                })
                ->addColumn('type', function ($query) {
                    $type = null;
                    if ($query->type == 'select') {
                        $type = _i('Options');
                    }
                    if ($query->type == 'text') {
                        $type = _i('Text');
                    }
                    if ($query->type == 'number') {
                        $type = _i('Numerical');
                    }
                    return $type;
                })
                ->addColumn('created_at', function ($query) {
                    return Utility::dates($query->created_at);
                })
                ->addColumn('require', function ($query) {
                    if ($query->required == 0) {
                        return '<input type="checkbox" data-id="' . $query->id . '"   class="js-switch-table" name="status"/>';
                    } else {
                        return '<input type="checkbox" data-id="' . $query->id . '"   class="js-switch-table" name="status" checked/>';
                    }
                })
                ->addColumn('placeholder', function ($query) {
                    $data = $query->Data->where('lang_id', Lang::getSelectedLangId())->first();
                    if ($data == null) {
                        $data = $query->Data->first();
                    }
                    return $data->placeholder;
                })
                ->editColumn('options', function ($query) {
                    $html = '<a href="#" class="btn btn-info mr-1 ml-1" id="edit-attribute" data-toggle="modal" data-target="#attribute-edit" data-id="' . $query->id . '" data-action="edit">' . _i('Edit') . '</a>';

                    $html = $html . "<a href='#' class='btn mr-1 ml-1 btn-danger btn-delete datatable-delete' data-url='" . route('category.attributes.delete', $query->id) . "'>" . _i('Delete') . "</a>";

                    // $html = $html . "<a href='#' data-toggle='modal' data-target='#image' class='btn mr-1 ml-1 btn-primary btn-delete images' data-id='" . $query->id . "' data-icon='" . asset($query->icon) . "' data-button='icon'>" . _i('Icon') . "</a>";

                    // if ($query->type == 'select') {
                    $html = $html . "<a href='#' data-toggle='modal' data-target='#options-edit' class='btn mr-1 ml-1 btn-warning images' data-id='" . $query->id . "' data-action='options'>" . _i('Options') . "</a>";
                    // }
                    return $html;
                })
                ->rawColumns([
                    'name',
                    'category',
                    'options',
                    'type',
                    'values',
                    'require',
                    'created_at'
                ])->make([true]);
        }
        return view('admin.attributes.index', compact('languages', 'category'));
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function store(Request $request)
    {
        $langs = Language::all();
        $lang_ids = $langs->pluck('id')->toArray();
        $attribute = Attribute::create([
            'type' => $request->type,
            'required' => $request->required ? 1 : 0,
            'front' => $request->front ? 1 : 0,
        ]);
        // CategoryAttribute::create([
        //     'attribute_id' => $attribute->id,
        //     'category_id' => $request->category_id,
        // ]);
        foreach ($request->title as $key => $value) {
            if (in_array($key, $lang_ids)) {
                AttributeData::create([
                    'lang_id' => $key,
                    'attribute_id' => $attribute->id,
                    'title' => $value,

                ]);
            }
        }
        // if ($request->type == 'select') {
        foreach ($request->option as $key => $option_element) {
            $option = AttributeOption::create([
                'attribute_id' => $attribute->id,
            ]);
            foreach ($option_element as $lang_code => $option_title) {
                $lang = $langs->where('code', $lang_code)->first();
                if ($lang != null) {
                    AttributeOptionData::create([
                        'option_id' => $option->id,
                        'title' => $option_title,
                        'lang_id' => $lang->id,
                    ]);
                }
            }
            //  }
        }
        return response(['fail' => false, 'message' => _i('Attribute added successfully')], 200);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function edit(Request $request)
    {
        $attribute = Attribute::query()
            ->with('Data')
            ->where('id', $request->id)
            ->first();
        $languages = Language::get();
        if ($attribute != null) {
            return response(['fail' => false, 'attribute' => $attribute, 'languages' => $languages], 200);
        } else {
            return response(['fail' => true, 'attribute' => null, 'message' => _i('Error Happened')], 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function update(Request $request)
    {
        $lang_ids = Language::pluck('id')->toArray();
        $attribute = Attribute::find($request->id);
        if ($attribute != null) {
            Attribute::where('id', $request->id)
                ->update([
                    'required' => $request->required == 1 ? 1 : 0,
                    'front' => $request->front == 1 ? 1 : 0,
                ]);
            foreach ($request->title as $key => $value) {
                if (in_array($key, $lang_ids)) {
                    AttributeData::query()
                        ->updateOrCreate([
                            'attribute_id' => $request->id,
                            'lang_id' => $key,
                        ], [
                            'title' => $value,

                        ]);
                }
            }
            return response(['fail' => false, 'message' => _i('Attribute Updated Successfully')], 200);
        } else {
            return response(['fail' => true, 'message' => _i('Error Happened')], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return Application|ResponseFactory|Response
     */
    protected function delete(Request $request, $id)
    {
        $attribute_values = AttributeValue::where('attribute_id', $id)->get();

        if ($attribute_values->isEmpty()) {
            Attribute::where('id', $id)->delete();
            if ($request->id != null) {
                AttributeOption::where('id', $request->id)->delete();
            }
            return response(['fail' => false], 200);
        } else {
            return response(['fail' => true], 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function getOptions(Request $request)
    {
        $options = AttributeOption::query()
            ->with('Data')
            ->where('attribute_id', $request->id)
            ->get();
        $languages = Language::get();
        if ($options->isNotEmpty()) {
            $response = [
                'fail' => false,
                'message' => null,
                'options' => $options,
                'languages' => $languages
            ];
            return response($response, 200);
        } else {
            $response = [
                'fail' => true,
                'message' => _i('Error Happened'),
                'options' => null,
                'languages' => null
            ];
            return response($response, 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function storeOption(Request $request)
    {
        $option = AttributeOption::create([
            'attribute_id' => $request->id,
        ]);
        $languages = Language::all();
        foreach ($request->values as $key => $value) {
            AttributeOptionData::create([
                'option_id' => $option->id,
                'lang_id' => $languages->where('code', $key)->first()->id,
                'title' => $value,
            ]);
        }
        return response(['fail' => false, 'message' => _i('Option added successfully')], 200);
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function updateOption(Request $request)
    {
        $option = AttributeOption::find($request->option_id);
        if ($option != null) {
            $languages = Language::all();
            foreach ($request->values as $key => $value) {
                AttributeOptionData::query()
                    ->updateOrCreate([
                        'option_id' => $option->id,
                        'lang_id' => $languages->where('code', $key)->first()->id,
                    ], [
                        'title' => $value,
                    ]);
            }
            return response(['fail' => false, 'message' => _i('Option Updated Successfully')], 200);
        } else {
            return response(['fail' => true, 'message' => _i('Error Happened')], 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function DeleteOption(Request $request)
    {
        $option_values = AttributeValue::where('option_id', $request->id)->get();
        if ($option_values->isEmpty()) {
            AttributeOption::where('id', $request->id)->delete();
            return response(['fail' => false, 'message' => _i('Option Deleted Successfully')], 200);
        } else {
            return response(['fail' => true, 'message' => _i('Option Can\'t Be Deleted!')], 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function uploadIcon(Request $request)
    {
        $attribute = Attribute::find($request->id);
        if ($attribute != null) {
            if ($request->hasFile('icon')) {
                $image = $request->file('icon');
                $filename = time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/attributes/' . $attribute->id), $filename);

                $attribute->icon = 'uploads/attributes/' . $attribute->id . '/' . $filename;
                $attribute->save();
            }
            return response(['fail' => false, 'message' => _i('Icon Uploaded Successfully')], 200);
        } else {
            return response(['fail' => true, 'message' => _i('Error Happened')], 200);
        }
    }

    /**
     * @param Request $request
     * @return Application|ResponseFactory|Response
     */
    protected function getIcon(Request $request)
    {
        $attribute = Attribute::find($request->id);
        if ($attribute != null) {
            return response(['fail' => false, 'icon' => $attribute->icon], 200);
        } else {
            return response(['fail' => true, 'icon' => null], 200);
        }
    }
}
