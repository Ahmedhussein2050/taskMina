<?php

namespace App\Modules\Admin\Models\Imports;

use App\Modules\Admin\Models\MailingList\Items;
use Maatwebsite\Excel\Concerns\ToModel;

class MailingListImport implements ToModel
{
	public $request;
	public function __construct($request)
	{
		$this->request = $request;
	}
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $email = Items::create([
            'email' => $row[0],
            'country_id' => $this->request->country,
            'city_id' => $this->request->city
        ]);

        $email->groups()->attach($this->request->groups);
    }
}
