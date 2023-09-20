<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Contacts\Client;
use App\Models\Masters\City;
use App\Traits;

class Address extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "addresses";
    protected $fillable = [
        'type',
        'is_primary',
        'number',
        'suite',
        'street',
        'city_id',
        'country',
        'postal_code',
        'province',
        'addressable_type',
        'addressable_id',
    ];

    protected $appends = ['addr_line1', 'addr_line2'];

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getAddrLine1Attribute()
    {
        $addr = '';
        $addr = $this->number ? $this->number : '';
        $addr = addString($addr, $this->street, ', ');
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
