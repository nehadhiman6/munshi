<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Attribute;

class Solicitor extends Model
{
    use HasFactory;
    use Traits\Addressable;
    use Traits\UserAutoUpdate;
    protected $table = "solicitors";
    protected $fillable = [
        'type',
        'first_name',
        'middle_name',
        'last_name',
        'fax',
        'work_phone',
        'cell_phone',
        'email',
        'law_firm_id',
    ];

    protected $appends = ['name'];

    public function law_firm()
    {
        return $this->belongsTo(LawFirm::class, 'law_firm_id');
    }

    public function getNameAttribute()
    {
        $name = $this->first_name;
        $name .= $this->middle_name && $this->middle_name != '' ? ' ' . $this->middle_name : '';
        $name .= $this->last_name && $this->last_name != '' ? ' ' . $this->last_name : '';
        return $name;
    }
}
