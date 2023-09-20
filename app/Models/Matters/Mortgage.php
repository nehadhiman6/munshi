<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address\Address;
use App\Models\Masters\Solicitor;
use App\Models\Masters\Contact;

use App\Traits;

class Mortgage extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;

    protected $table = "mortgagees";
    protected $fillable = [
        'file_opening_id',
        'instrument_no',
        'instrument_date',
        'instrument_type',
        'obtaining_discharge',
        'mortgagee_reference_number',
        'principal_amount',
        'per_diem',
        'total_mortgage_payable_discharge',
        'mortgagee_id',
        'contact',
        'solicitor_id',
        'phone',
        'fax',
        'email',
        'attention',
        'discharge_no',
        'discharge_date',
        'discharged_on',
        'extra_interest'
    ];

    public function getInstrumentDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setInstrumentDateAttribute($date)
    {
        $this->attributes['instrument_date'] = setDateAttribute($date);
    }


    public function getDischargeDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDischargeDateAttribute($date)
    {
        $this->attributes['discharge_date'] = setDateAttribute($date);
    }

    public function getDischargedOnAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDischargedOnAttribute($date)
    {
        $this->attributes['discharged_on'] = setDateAttribute($date);
    }


    public function mortgagee(){
        return $this->belongsTo(Contact::class,'mortgagee_id');
    }

    public function solicitor(){
        return $this->belongsTo(Solicitor::class,'solicitor_id');
    }

    public function additional_charges(){
        return $this->hasMany(MortgageCharge::class,'mortgage_id');
    }
}
