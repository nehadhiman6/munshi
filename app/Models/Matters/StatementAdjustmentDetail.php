<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class StatementAdjustmentDetail extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "statement_adjustments_details";
    protected $fillable = [
        'file_opening_id',
        'additional_credit_to',
        'additional_credit_type',
        'additional_credit_amount',
        'from_date',
        'to_date',
        'remarks',
    ];

    public function getFromDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setFromDateAttribute($date)
    {
        $this->attributes['from_date'] = setDateAttribute($date);
    }


    public function getToDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setToDateAttribute($date)
    {
        $this->attributes['to_date'] = setDateAttribute($date);
    }
}
