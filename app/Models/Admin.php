<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    //use Notifiable;
    use HasRoles;
    use Notifiable;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $guard_name = 'admin';
    protected $table = 'users';
    protected $guard = "admin";
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Set connection for tracker package.
     */
    protected $connection = 'mysql';

    public function AauthAcessToken()
    {
        return $this->hasMany('\App\OauthAccessToken');
    }

//    public function groups()
//    {
//        return $this->belongsToMany(Group::class);
//    }

//    public function tickets()
//    {
//        return $this->hasMany(ticket::class, 'agent_id');
//    }

//    public function orders()
//    {
//        return $this->hasMany(orders::class);
//    }


    public function getImageAttribute($value)
    {
        if (\request()->is('api/*')) {
            return url($value);
        }
        return $value;
    }

//    public function addresses()
//    {
//        return $this->hasManyThrough(Shipping::class, orders::class, 'user_id', 'order_id');
//    }
//    public function newQuery($excludeDeleted = true)
//    {
//        return parent::newQuery($excludeDeleted)->where($this->getTable() . '.guard', "admin");
//    }

}
