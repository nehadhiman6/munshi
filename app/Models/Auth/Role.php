<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = "roles";
    protected $fillable = ['name'];
    protected $connection = 'mysql';

    public function users()
    {
        return $this->hasMany(User::class,'role_user','user_id','role_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function givePermissionTo($permission)
    {
        return $this->permissions()->save($permission);
    }
}

