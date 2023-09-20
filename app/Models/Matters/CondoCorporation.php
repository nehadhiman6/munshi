<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class CondoCorporation extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;

    protected $table = "condo_corporations";
    protected $fillable = [
        'file_opening_id',
        'condo_corporation_name',
        'type',
        'management_company',
        'attention',
        'phone',
        'fax',
        'email',
        'status_certificate_fees',
    ];

}
