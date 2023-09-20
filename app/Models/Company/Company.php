<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Masters\City;
use App\Models\Masters\Employee;

class Company extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "companies";
    protected $fillable = [
        'name',
        'street',
        'continued',
        'city_id',
        'country',
        'postal_code',
        'province',
        'defult_solicitor_id'
    ];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function solicitor()
    {
        return $this->belongsTo(Employee::class, 'default_solicitor_id');
    }
}
