<?php

namespace App\Models\Payment;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class Transaction extends Model
{
    use Traits\UserAutoUpdate;
    protected $table = "transactions";
    protected $connection = 'mysql';
    protected $fillable = [
        'liesure_id',
        'transaction_id',
        'transaction_status',
        'transaction_date',
        'currency',
        'amount_received',
        'refund_amount',
        'payment_type',
        'gateway_type',
        'source',
    ];
}
