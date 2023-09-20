<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Masters\City;
use App\Traits;

class Property extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "properties";
    protected $fillable = [
        'file_opening_id',
        'customer_no',
        'lro',
        'street_no',
        'unit_no',
        'street_name',
        'city_id',
        'province',
        'country',
        'postal_code',
        'roll_no',
        'survey_available',
        'surveyor_id',
        'surveyor',
        'date',
        'title_search_performed',
        'sale_of',
        'condo_corporation',
        'lot_part',
        'lot',
        'plan',
        'being_part',
        'on_plan',
        'parcel',
        'section',
    ];

    protected $appends = ['addr_line1', 'addr_line2', 'lot_plan'];

    public function pins()
    {
        return $this->hasMany(PropertyPin::class, 'property_id', 'id');
    }

    public function getDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = setDateAttribute($date);
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function getAddrLine1Attribute()
    {
        $addr = $this->street_no ? $this->street_no : '';
        $addr = addString($addr, $this->street_name, ', ');
        return $addr;
    }

    public function getAddrLine2Attribute()
    {
        $addr = $this->unit_no ? $this->unit_no : '';
        $addr = addString($addr, $this->city ? $this->city->city_name : '', ', ');
        $addr = addString($addr, $this->province, ', ');
        $addr = addString($addr, $this->postal_code, '-');
        return $addr;
    }

    public function getLotPlanAttribute()
    {
        $lot_part = $this->lot_part . ' ' . $this->lot . ', Plan ' . $this->on_plan . '; ';
        $lot_part .= 'SUBJECT TO AND TOGETHER WITH EASEMENTS AS SET OUT IN SCHEDULE A AS IN PR3598454, TOWN OF ';
        $lot_part .= $this->city ? $this->city->city_name : '';
        return $lot_part;
    }
}
