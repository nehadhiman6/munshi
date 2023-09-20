<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use  App\Models\Masters\RealEstateAgent;
use  App\Models\Masters\Brokerage;

class Commission extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    use Traits\Addressable;
    use Traits\Resourceable;

    protected $table = "commissions";
    protected $fillable = [
        'file_opening_id',
        'brokerage_id',
        'total_commission',
        'gst',
        'total_commission_after_gst',
        'less_deposit',
        'commission_payable',
        'excess_deposit_to_seller',
    ];

    public function real_estate_agent(){
        return $this->belongsTo(RealEstateAgent::class,'real_estate_agent_id');
    }


    public function brokerage(){
        return $this->belongsTo(Brokerage::class,'brokerage_id');
    }

}
