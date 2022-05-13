<?php

namespace App\Models\Blog;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';
    protected $guarded = [];
    public function data(){
        return $this->hasOne(BlogData::class, 'blog_id', 'id')
            ->where('lang_id', Lang::getSelectedLangId());
    }
    public function data_back(){
        return $this->hasMany(BlogData::class, 'blog_id', 'id');
    }
    public function attachment(){
        return $this->hasOne(BlogAttachment::class, 'blog_id', 'id');
    }

}
