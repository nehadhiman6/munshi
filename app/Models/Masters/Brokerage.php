<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Brokerage extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;

    protected $table = "brokerages";
    protected $fillable = [
        'name',
        'phone',
        'fax',
        'email',
    ];
}
