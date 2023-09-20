<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class PrecedentFormat extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "precedent_formats";
    protected $fillable = [
        'name',
        'format_text',
    ];


}
