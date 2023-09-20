<?php

namespace App\Models\Auth;
use App\Traits;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use Traits\UserAutoUpdate;
    protected $table = 'preferences';
    protected $fillable = ['user_id', 'para_name','para_value'];
    protected $connection = 'mysql';

}
