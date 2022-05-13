<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefaultImage extends Model
{
    protected $table = 'default_images';
    protected $guarded = [];


    public function getFaviconAttribute($value)
    {
        if(\request()->is('api/*')){
            return url( $value);
        }
        return $value;
    }
    public function getHeaderAttribute($value)
    {
        if(\request()->is('api/*')){
            return url( $value);
        }
        return $value;
    }
    public function getFooterAttribute($value)
    {
        if(\request()->is('api/*')){
            return url( $value);
        }
        return $value;
    }
    public function getNotFoundAttribute($value)
    {
        if(\request()->is('api/*')){
            return url( $value);
        }
        return $value;
    }
}
