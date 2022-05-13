<?php

namespace App\Modules\Admin\Models\SitePages;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $table = 'pages';
    protected $guarded = [];
    public function data(){
        return $this->hasOne(PageData::class, 'page_id', 'id')
            ->where('lang_id', Lang::getSelectedLangId());
    }
}
