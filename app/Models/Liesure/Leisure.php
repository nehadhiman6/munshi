<?php

namespace App\Models\Liesure;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use Illuminate\Support\Facades\DB;

class Leisure extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "leisures";
    protected $fillable = [
        'file_id',
        'vcode',
        'trans_date',
        'particulars',
        'dr_amount',
        'cr_amount',
        'leisure_id',
        'organization_id',
    ];

    public function setTransDateAttribute($date)
    {
        $this->attributes['trans_date'] = setDateAttribute($date);
    }

    public function getTransDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setHstRateAttribute($rate)
    {
        $this->attributes['hst_rate'] = setAmountAttribute($rate);
    }
    public function setHstAmtAttribute($amt)
    {
        $this->attributes['hst_amt'] = setAmountAttribute($amt);
    }
    public function setVcodeAttribute($vcode)
    {
        $this->attributes['vcode'] = setStringAttribute($vcode);
    }

    public static function getBalance()
    {
        return static::sum(DB::raw("ifnull(dr_amount,0)-ifnull(cr_amount,0)"));
    }
}
