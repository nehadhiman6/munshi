<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Purchaser extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "purchasers";
    protected $fillable = [
        'file_opening_id',
        'first_name',
        'middle_name',
        'last_name',
        'dob',
        'title_capacity',
        'salutation',
        'company_name',
        'other_title_capacity'

    ];

    protected $appends = ['name'];

    public function getDobAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDobAttribute($date)
    {
        $this->attributes['dob'] = setDateAttribute($date);
    }

    public function getNameAttribute()
    {
        $name = $this->first_name;
        $name .= $this->middle_name && $this->middle_name != '' ? ' ' . $this->middle_name : '';
        $name .= $this->last_name && $this->last_name != '' ? ' ' . $this->last_name : '';
        return $name;
    }
}
