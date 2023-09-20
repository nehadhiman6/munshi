<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StatementAdjustment extends Model
{
    use HasFactory;
    use Traits\Resourceable;
    use Traits\UserAutoUpdate;
    protected $table = "statement_adjustments";
    protected $fillable = [
        'file_opening_id',
        'sale_price',
        'seller_credit',
        'deposit',
        'property_tax',
        'total_taxes',
        'taxes_paid',
        'seller_share',
        'total',
        'balance_due',
        'additional_credit_type',
        'remarks'
    ];
}
