<?php

namespace App\Modules\Admin\Models\MailingList;

use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
	protected $table = 'items';
	protected $guarded = [];

    public function lists()
    {
        return $this->belongsToMany(\App\ItemsList::class, 'items_list', 'item_id', 'list_id');
    }
}
