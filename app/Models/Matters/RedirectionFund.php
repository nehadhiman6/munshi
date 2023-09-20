<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class RedirectionFund extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "redirection_funds";
    protected $fillable = [
        'file_opening_id',
        'particulars',
        'amount',
        'fix_var',
        'target_type',
        'target_id',
        'target_field',
        'custom'
    ];
}
