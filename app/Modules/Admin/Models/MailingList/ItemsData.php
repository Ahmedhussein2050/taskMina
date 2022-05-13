<?php

namespace App\Modules\Admin\Models\MailingList;

use Illuminate\Database\Eloquent\Model;

class ItemsData extends Model
{
	protected $table = 'items_data';
	protected $guarded = [];
	protected $fillable = ['name','item_id','lang_id'];
}
