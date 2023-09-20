<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class Liesure extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "leisures";
    protected $fillable = [
        'file_id',
        'trans_date',
        'particulars',
        'dr_amount',
        'cr_amount',
        'leisure_id',
        'organization_id',
    ];

}
