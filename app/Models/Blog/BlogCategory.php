<?php

namespace App\Models\Blog;

use App\Bll\Lang;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    protected $table = 'blog_categories';
    protected $guarded = [];
    public function data(){
        return $this->hasOne(BlogCategoryData::class, 'blog_id', 'id')
            ->where('lang_id', Lang::getSelectedLangId());
    }
    public function data_back(){
        return $this->hasMany(BlogCategoryData::class, 'blog_id', 'id');
    }
    public function attachment(){
        return $this->hasOne(BlogCatAttachment::class, 'blog_id', 'id');
    }
    public function blog()
    {
        return $this->hasMany(Blog::class ,'blog_category_id','id');
    }
    public function blogs()
	{
		return $this->hasMany(Blog::class ,'blog_category_id','id')->where('status',1);
	}
}
