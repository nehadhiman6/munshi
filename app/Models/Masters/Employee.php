<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Employee extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;

    protected $table = "employees";
    protected $fillable = [
        'type',
        'first_name',
        'middle_name',
        'last_name',
        'fax',
        'work_phone',
        'cell_phone',
        'email',
        'name_initials', 'teraview'
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
