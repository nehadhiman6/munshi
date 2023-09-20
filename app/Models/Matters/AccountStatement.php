<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class AccountStatement extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "account_statements";
    protected $fillable = [
        'file_opening_id',
        'total_fees',
        'hst',
        'hst_disbursement_total',
        'hst_disbursement_hst',
        'non_hst_disbursement_total',
        'total_fees_disbursement',
        'total_fees_disbursement_without_hst',
        'total_hst',
    ];

    public function account_statement_details(){
        return $this->hasMany(AccountStatementDetail::class,'account_statement_id');
    }
}
