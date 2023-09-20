<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class TrustLedger extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "trust_ledgers";
    protected $fillable = [
        'order_no',
        'file_opening_id',
        'particulars',
        'type',
        'amount',
        'fix_var',
        'target_type',
        'target_field',
        'target_id',
        'custom'
    ];
}
