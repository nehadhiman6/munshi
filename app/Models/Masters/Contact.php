<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Contact extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;
    protected $table = "contacts";
    protected $fillable = [
        'type',
        'first_name',
        'middle_name',
        'last_name',
        'fax',
        'work_phone',
        'cell_phone',
        'email',
        'company_name'
    ];
}
