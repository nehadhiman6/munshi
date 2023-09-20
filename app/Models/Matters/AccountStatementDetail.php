<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class AccountStatementDetail extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "account_statements_details";
    protected $fillable = [
        'account_statement_id',
        'type',
        'sub_type',
        'particulars',
        'amount',
    ];
}
