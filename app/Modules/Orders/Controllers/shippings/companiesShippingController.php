<?php

namespace App\Modules\Orders\Controllers\shippings;
use App\Bll\MyFatoorah;
use App\DataTables\companiesDataTable;
use App\Http\Controllers\Controller;
use App\Modules\Admin\Models\CityData;
use App\Modules\Admin\Models\countries_data;
use App\Modules\Orders\Models\Shipping\shippingCompanies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;

class companiesShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(companiesDataTable $companies)
    {
        $companies = shippingCompanies::get();
       $countries = countries_data::get();
       $cities = CityData::get();
        return view('admin.shipping.companies.index',["companies" => $companies,"countries" => $countries ,"cities" => $cities]);
        return $companies->render('admin.shipping.companies.index',["companies" => $companies]);
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->request->add([]);
        $data = $this->validate($request, [
            'title' => 'required',
            'description' => 'required',
            'logo' => 'sometimes',

        ]);
        $sessionStore = MyFatoorah::get_store_id();
        if ($sessionStore == \App\Bll\Utility::$demoId) {
            return redirect()->back()->with('flash_message', _i('Added Successfully'));
        }
        if ($request->has('logo')) {
			$request->validate([
				'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

            $logo = $request->logo;
            $numberrand = rand(11111, 99999);
            $randname = time() . $numberrand;
            $imageName = $randname . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/shippingCompany'), $imageName);
            shippingCompanies::create(['title' => $request->title, 'description' => $request->description, 'logo' => 'uploads/shippingCompany/' . $imageName]);
        } else {
            shippingCompanies::create($data);
        }
        return redirect()->back()->with('flash_message', _i('success add'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $shippingCompanies = shippingCompanies::where('id' , $id)->first();
        $sessionStore = MyFatoorah::get_store_id();
        $data = $this->validate($request, [
            'title' => ['required', Rule::unique('shipping_companies', 'id')->where(function ($q) use ($sessionStore) {
                return $q;
            }),
            ],
            'description' => 'sometimes',
            'logo' => 'sometimes',
        ]);

        if ($request->has('logo')) {
			$request->validate([
				'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg',
			]);

            $image_path = $shippingCompanies->logo;  // Value is not URL but directory file path
            if (File::exists(public_path($image_path))) {
                File::delete(public_path($image_path));
            }
            $logo = $request->logo;
            $numberrand = rand(11111, 99999);
            $randname = time() . $numberrand;
            $imageName = $randname . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('uploads/shippingCompany'), $imageName);
            $shippingCompanies->update(['title' => $request->title, 'description' => $request->description, 'logo' => 'uploads/shippingCompany/' . $imageName]);
        } else {
            $shippingCompanies->update($data);
        }
        return redirect()->back()->with('flash_message', _i('success update'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shippingCompanies = shippingCompanies::where('id' , $id)->first();
        $image_path = $shippingCompanies->logo;  // Value is not URL but directory file path
        if (File::exists(public_path($image_path))) {
            File::delete(public_path($image_path));
        }
        $shippingCompanies->delete();
        return redirect()->back()->with('flash_message',_i('success delete'));
    }
}
