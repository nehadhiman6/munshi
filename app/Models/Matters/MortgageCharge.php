<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class MortgageCharge extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "mortgage_charges";
    protected $fillable = [
        'mortgage_id',
        'particulars',
        'amount'
    ];
}
