<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  App\Models\Masters\Employee;
use  App\Models\Masters\LawFirm;
use  App\Models\Masters\Solicitor;
use App\Traits;

class SolicitorPurchaser extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "purchser_solicitors";
    protected $fillable = [
        'file_opening_id',
        'solicitor_id',
        'solicitor_email',
        'law_firm_id',
        'law_firm_address',
        'law_clerk_id',
        'law_clerk_name',
        'file_number',
        'phone',
        'fax',
        'email',
    ];



    public function law_clerk(){
        return $this->belongsTo(Employee::class, 'law_clerk_id', 'id');
    }

    public function solicitor(){
        return $this->belongsTo(Solicitor::class, 'solicitor_id', 'id');
    }

    public function law_firm(){
        return $this->belongsTo(LawFirm::class, 'law_firm_id', 'id');
    }
}
