<?php

namespace App\Modules\Admin\Controllers\Settings;

use App\Bll\Lang;
use App\Bll\Utility;
use App\DataTables\PagesDataTable;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Modules\Admin\Models\SitePages\Page;
use App\Modules\Admin\Models\SitePages\PageData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class PagesController extends Controller
{
    public function index(PagesDataTable $pages) {
        return $pages->render('admin.pages.index');
    }

    public function create()
    {
        $langs = Language::get();
        return view('admin.pages.create', compact('langs'));
    }

    public function store(Request $request)
    {
        $request['published'] = $request['published'] ?? 0;
        $request['lang_id'] = $request['lang_id'] ?? Language::first()->id;
        $page = Page::create([
            'published' => $request['published'],
        ]);
        $page_data = PageData::create([
                    'page_id' => $page->id,
                    'lang_id' => $request['lang_id'],
                    'source_id' => null,
                    'title' => $request['title'],
                    'content' => $request['content'],
        ]);
        $page->save();
        return redirect()->back()->with('success', _i('Saved Successfully !'));
    }

    public function edit($id)
    {
        $langs = Language::get();
        $page = Page::findOrFail($id);
        $page_data = PageData::where('page_id', $page->id)->where('source_id', null)->first();
        return view('admin.pages.edit', compact('langs', 'page', 'page_data'));
    }

    public function update(Request $request)
    {
        $request['published'] = $request['published'] ?? 0;

        $page = Page::findOrFail($request->id);

        $page->update([
            'published' => $request['published'],
        ]);

        return response()->json('SUCCESS');
    }

    public function pagergetLangvalue(Request $request)
    {
        $rowData = PageData::where('page_id', $request->transRow)
                ->where('lang_id', $request->lang)
                ->first(['title', 'content']);
        if (!empty($rowData)) {
            return \response()->json(['data' => $rowData]);
        } else {
            return \response()->json(['data' => false]);
        }
    }

    public function pagestorelangTranslation(Request $request)
    {
        $rowData = PageData::where('page_id', $request->id)
                ->where('lang_id', $request->lang_id_data)
                ->first();
        if ($rowData != null) {
            $rowData->update([
                'title' => $request->title,
                'content' => $request->input('content'),
            ]);
        } else {
            $parentRow = PageData::where('page_id', $request->id)->where('source_id', null)->first();
            PageData::create([
                'title' => $request->title,
                'content' => $request->input('content'),
                'lang_id' => $request->lang_id_data,
                'page_id' => $request->id,
                'source_id' => $parentRow->id,
            ]);
        }
        return \response()->json("SUCCESS");
    }

    public function delete($id)
    {
        $page = Page::findOrFail($id);
        if ($page == null) {
            return redirect()->back()->with('error_message', _i('Not founds'));
        }

        $page = Page::destroy($id);
        return redirect()->back()->with('success', _i('Deleted Successfully !'));
    }
}
