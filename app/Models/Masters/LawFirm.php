<?php

namespace App\Models\Masters;

use App\Models\Address\Address;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class LawFirm extends Model
{
    use HasFactory;
    use Traits\Addressable;
    use Traits\UserAutoUpdate;
    protected $table = "law_firms";
    protected $fillable = [
        'firm_name',
    ];

    public function address()
    {
        return $this->hasOne(Address::class, 'addressable_id')->where('addressable_type', static::class);
    }
}
