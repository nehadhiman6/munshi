<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource\Resource;
use App\Traits;
class SellerId extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "sellers_ids";
    protected $fillable = [
        'seller_id',
        'id_type',
        'expiry_date',
        'number',
        'issuing_jurisdiction',
        'issuing_country',
    ];

    public function resources()
    {
        return $this->hasMany(Resource::class, 'resourceable_id')->where('resourceable_type', SellerId::class);
    }

    public function getExpiryDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setExpiryDateAttribute($date)
    {
        $this->attributes['expiry_date'] = setDateAttribute($date);
    }


}
