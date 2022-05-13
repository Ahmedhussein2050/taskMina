<?php

namespace App\Modules\Admin\Controllers\Mails;


use App\Bll\Email;
use App\Bll\Lang;
use App\Bll\SMS;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\User;
use App\Modules\Admin\Models\cities;
use App\Modules\Admin\Models\MailingList\Items;
use App\Modules\Admin\Models\MailingList\MailingTemplate;
use App\Modules\Admin\Models\Products\BrandData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class MailingTemplatesController extends Controller
{
    public function index(Request $request)
	{
		$languages = Language::all();
		$templates = MailingTemplate::where('lang_id', Lang::getSelectedLangId())->get();
		return view('admin.mailing_templates.index', compact('templates', 'languages'));
	}

	public function create()
	{
		return view('admin.mailing_templates.create', ['languages' => Language::all()]);
	}

	public function store(Request $request)
	{
		$request->validate([
			'title' => 'required',
			'subject' => 'required',
			'body' => 'required',
		]);

		$source = MailingTemplate::find($request->id);
		$template = MailingTemplate::where('category', $source->category)
			->where('type', $source->type)
			->where('lang_id', $request->lang_id)
			->get()->first();
		if($template == null)
		{
			MailingTemplate::create([
				'title' => $request->title,
				'subject' => $request->subject,
				'body' => $request->body,
				'category' => $source->category,
				'type' => $source->type,
				'lang_id' => $request->lang_id,
			]);
		}
		else
		{
			$source->update([
				'title' => $request->title,
				'subject' => $request->subject,
				'body' => $request->body,
			]);
		}
		return back()->with('success', _i('Updated Successfully !'));
	}


	public function show($id)
	{
		//
	}


	public function edit(Request $request, $id, $lang)
	{
		$template = MailingTemplate::findOrFail($id);
		$template = MailingTemplate::where('category', $template->category)
			->where('type', $template->type)
			->where('lang_id', $lang)
			->get()->first();

		return view('admin.mailing_templates.edit', ['languages' => Language::all(), 'template' => $template]);
	}


	public function update(Request $request, $id)
	{
		$email = Items::findOrFail($id);
		$validator = Validator::make($request->all(), [
			'email' => ['required', Rule::unique('mailing_list')->ignore($id)],
		]);

		if ($validator->passes()) {
			$email->update([
				'email' => $request->email,
				'country_id' => $request->country,
				'city_id' => $request->city,
			]);

			$email->groups()->sync($request->groups);

			return response()->json(true);
		}
		return response()->json(['errors' => $validator->errors()]);
	}


	public function destroy($id)
	{
		$email = Items::findOrFail($id);
		$email->groups()->detach();
		$email->delete();
		return response()->json(true);
	}

	public function cities(Request $request)
	{
		$cities = cities::select('cities.id', 'city_datas.title')
			->join('city_datas', 'cities.id', 'city_datas.city_id')
			->where('lang_id', Lang::getSelectedLangId())
			->where('country_id', $request->country_id)
			->get();
		return $cities;
	}

	public function translate(Request $request)
	{
		$rowData = BrandData::where('brand_id', $request->transRow)
			->where('lang_id', $request->lang_id)
			->first(['name','description']);
		if (!empty($rowData)){
			return response()->json(['data' => $rowData]);
		}else{
			return response()->json(['data' => false]);
		}
	}

	public function storeTranslation(Request $request)
	{
		$rowData = BrandData::where('brand_id', $request->id)
			->where('lang_id' , $request->lang_id)
			->first();
		if ($rowData != null) {
			$rowData->update([
				'name' => $request->name,
				'description' => $request->input('description'),
			]);
		}else{
			BrandData::create([
				'name' => $request->name,
				'description' => $request->input('description'),
				'lang_id' => $request->lang_id,
				'brand_id' => $request->id
			]);
		}
		return response()->json("SUCCESS");
	}
    protected function sendStore(Request $request)
    {
        if ($request->users != null) {
            if (count($request->users) > 0) {
                $model_type = 'customer';
                $message = $request->message;
                $users = $request->users;
                foreach ($users as $item) {
                    $user = User::findOrFail($item);
                    $phone = $user->phone;
                    $user_email = $user->email;
                    $user_id = $user->id;
                    if ($request->type == 'sms') {
                        $sms = new SMS();
                        $data = $sms->smsSave($message, $phone, $user_id, $model_type);
                    } else {
                        $email = new Email();
                        $data = $email->emailSave($message, $user_email, $user_id, $model_type);
                    }
                }
                return response()->json([true]);
            } else {
                return response()->json([false]);
            }
        } else {
            return response()->json([false, 'message' => _i('PLease Select Users')]);
        }
    }

}
