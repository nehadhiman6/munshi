<?php

namespace App\Models\Masters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class TransactionType extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "transaction_types";
    protected $fillable = [
        'type_name'
    ];
}
