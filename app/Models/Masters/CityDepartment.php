<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class CityDepartment extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "city_departments";
    protected $fillable = [
        'city_id',
        'department_type',
        'department_name',
        'city_municipality',
        'service_provider_name',
        'attention',
        'street_no',
        'street_name',
        'province',
        'postal_code',
        'phone',
        'fax',
        'email',
        'website_link'
    ];

    protected $appends = ['addr_line1', 'addr_line2'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getAddrLine1Attribute()
    {
        $addr = '';
        $addr = $this->street_no ? $this->street_no : '';
        $addr = addString($addr, $this->street_name, ', ');
        return $addr;
    }

    public function getAddrLine2Attribute()
    {
        $addr = '';
        $addr = $this->city ? $this->city->city_name : '';
        $addr = addString($addr, $this->province, ', ');
        $addr = addString($addr, $this->postal_code, '-');
        return $addr;
    }
}
