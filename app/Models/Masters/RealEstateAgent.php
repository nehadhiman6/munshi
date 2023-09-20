<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class RealEstateAgent extends Model
{
    use HasFactory;
    use Traits\Addressable;
    use Traits\UserAutoUpdate;
    protected $table = "real_estate_agents";
    protected $fillable = [
        'is_active',
        'first_name',
        'middle_name',
        'last_name',
        'gender',
        'fax',
        'home_phone',
        'work_phone',
        'cell_phone',
        'email',
    ];

    protected $appends = ['name'];

    public function getNameAttribute()
    {
        $name = $this->first_name;
        $name .= $this->middle_name && $this->middle_name != '' ? ' ' . $this->middle_name : '';
        $name .= $this->last_name && $this->last_name != '' ? ' ' . $this->last_name : '';
        return $name;
    }
}
