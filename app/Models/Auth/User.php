<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{

    protected $connection = 'mysql';
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];



    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }


    public function hasRole($role)
    {
        // if (is_string($role)) {
        //     return $this->roles->contains('name', $role);
        // }

        if (is_string($role)) {
            $collection = $this->roles->filter(function ($item) use ($role) {
                return strtolower($item['role']) == strtolower($role);
            });
            return count($collection) ? true : false;
        }

        return !!$role->intersect($this->roles)->count();
    }

    public function isAdmin()
    {
        if ($this->hasRole('Admin')) {
            return true;
        }
        return false;
    }


}
