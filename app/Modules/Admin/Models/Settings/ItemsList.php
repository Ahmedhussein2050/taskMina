<?php

namespace App\Modules\Admin\Models\Settings;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class ItemsList extends Model
{
	protected $table = 'lists';
	protected $guarded = [];
	protected $fillable = ['order'];

    public function items()
    {
        return $this->belongsToMany(Items::class, 'items_list', 'list_id', 'item_id');
    }
    public function data(){
        return $this->hasOne(ItemsListData::class,'list_id','id')->where('Lang_id',Lang::getSelectedLangId());
    }

    public function getitems(){
        return $this->hasMany(Items::class,'list_id','id');
    }
}
