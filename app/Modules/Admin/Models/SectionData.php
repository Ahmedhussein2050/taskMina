<?php

namespace App\Modules\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SectionData extends Model
{
    protected $table = 'sections_data';
    public $timestamps = true;
    protected $guarded = [];
	public function section()
	{
		return $this->hasOne(Section::class, "id",'section_id');
	}
}
