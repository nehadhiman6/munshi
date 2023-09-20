<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PropertyPin extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "property_pins";
    protected $fillable = [
        'pin'
    ];



}
