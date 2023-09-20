<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class CardDetail extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "card_details";
    protected $fillable = [
        'card_name',
        'card_no',
        'cvc',
        'expiry',
    ];

}
