<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class RequisitionResponse extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "requisition_responses";
    protected $fillable = [
        'file_opening_id',
        'date',
        'received_date',
        'precedent',
        'response_sent',
    ];

    public function getDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDateAttribute($date)
    {
        $this->attributes['date'] = setDateAttribute($date);
    }


    public function getReceivedDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setReceivedDateAttribute($date)
    {
        $this->attributes['received_date'] = setDateAttribute($date);
    }
}
