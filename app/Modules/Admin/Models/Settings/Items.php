<?php

namespace App\Modules\Admin\Models\Settings;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class Items extends Model
{
	protected $table = 'items';
	protected $guarded = [];

    // public function lists()
    // {
    //     return $this->belongsToMany(ItemsList::class, 'items_list', 'item_id', 'list_id');
    // }

    public function list(){
        return $this->hasOne(ItemsListData::class,'list_id','list_id')->where('lang_id',Lang::getSelectedLangId());
    }
    public function data(){
        return $this->hasOne(ItemsData::class,'item_id','id')->where('lang_id',Lang::getSelectedLangId());
    }
}
