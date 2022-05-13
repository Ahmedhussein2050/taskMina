<?php

namespace App\Modules\Admin\Models\MailingList;

use Illuminate\Database\Eloquent\Model;

class ItemsList extends Model
{
	protected $table = 'lists';
	protected $guarded = [];
	protected $fillable = ['order'];

    public function items()
    {
        return $this->belongsToMany(\App\Items::class, 'items_list', 'list_id', 'item_id');
    }
}
