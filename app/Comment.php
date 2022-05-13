<?php

namespace App;

use App\Models\User;
use App\Modules\Admin\Models\Products\products;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
	protected $guarded = [];
	protected $with = ['reply'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}


	public function store()
	{
		return $this->belongsTo('App\Store');
	}

	public function product()
	{
		return $this->belongsTo(products::class);
	}

	public function reply()
	{
		return $this->hasMany(Comment::class, 'comment_id');
	}
}
