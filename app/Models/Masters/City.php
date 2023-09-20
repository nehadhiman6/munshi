<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class City extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "cities";
    protected $fillable = [
        'city_name',
        'state',
        'country',
        'lro_id'
    ];

    public function departments()
    {
        return $this->hasMany(CityDepartment::class, 'city_id');
    }
}
