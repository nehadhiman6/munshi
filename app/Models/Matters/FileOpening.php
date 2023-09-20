<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Masters\Employee;
use  App\Models\Masters\RealEstateAgent;
use App\Models\Matters\Mortgage;
use App\Models\Matters\TrustLedger;
use App\Models\Auth\User;
use App\Models\Execution\ExecutionDocument;
use App\Models\Resource\Resource;
use App\Traits;

class FileOpening extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;


    protected $table = "file_openings";
    protected $fillable = [
        'file_no',
        'record_no',
        'client_name',
        'closing_date',
        'agreement_of_ps_date',
        'requisition_date',
        'law_clerk_id',
        'client_reference',
        'real_estate_agent_id',
        'solicitor_id',
        'closed_file_no',
        'box_no',
        'special_notes',
        'rate'
    ];


    public function getClosingDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setClosingDateAttribute($date)
    {
        $this->attributes['closing_date'] = setDateAttribute($date);
    }

    public function getRequisitionDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setRequisitionDateAttribute($date)
    {
        $this->attributes['requisition_date'] = setDateAttribute($date);
    }

    public function getAgreementOfPsDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setAgreementOfPsDateAttribute($date)
    {
        $this->attributes['agreement_of_ps_date'] = setDateAttribute($date);
    }

    public function sellers(){
        return $this->hasMany(Seller::class, 'file_opening_id', 'id');
    }


    public function law_clerk(){
        return $this->belongsTo(Employee::class, 'law_clerk_id', 'id');
    }

    public function solicitor(){
        return $this->belongsTo(Employee::class, 'solicitor_id', 'id');
    }

    public function real_estate_agent(){
        return $this->belongsTo(RealEstateAgent::class, 'real_estate_agent_id', 'id');
    }


    public function purchasers(){
        return $this->hasMany(Purchaser::class, 'file_opening_id', 'id');
    }

    public function purchaser_solicitor(){
        return $this->hasOne(SolicitorPurchaser::class, 'file_opening_id', 'id');
    }

    public function property(){
        return $this->hasOne(Property::class, 'file_opening_id', 'id');
    }

    public function mortgages(){
        return $this->hasMany(Mortgage::class, 'file_opening_id', 'id');
    }

    public function condo_corporation(){
        return $this->hasOne(CondoCorporation::class, 'file_opening_id', 'id');
    }

    public function commission(){
        return $this->hasOne(Commission::class, 'file_opening_id', 'id');
    }

    public function statement_adjustment(){
        return $this->hasOne(StatementAdjustment::class, 'file_opening_id', 'id');
    }

    public function statement_adjustment_details(){
        return $this->hasMany(StatementAdjustmentDetail::class, 'file_opening_id', 'id');
    }

    public function requisition_responses(){
        return $this->hasMany(RequisitionResponse::class, 'file_opening_id', 'id');
    }

    public function trust_ledgers(){
        return $this->hasMany(TrustLedger::class, 'file_opening_id', 'id')->orderBy('order_no','asc');
    }


    public function redirection_funds(){
        return $this->hasMany(RedirectionFund::class, 'file_opening_id', 'id')->orderBy('order_no','asc');
    }

    public function account_statement(){
        return $this->hasOne(AccountStatement::class, 'file_opening_id', 'id');
    }

    public function documents(){
        return $this->hasMany(FileDocument::class, 'file_opening_id', 'id');
    }

    public function executions(){
        return $this->hasMany(ExecutionDocument::class, 'file_opening_id', 'id');
    }

    public function execution_docs()
    {
        return $this->hasMany(Resource::class, 'resourceable_id')->where('resourceable_type', FileOpening::class)->where('doc_type','execution_docs');
    }
}
