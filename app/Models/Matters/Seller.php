<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Address\Address;
use App\Traits;

class Seller extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "sellers";
    protected $fillable = [
        'file_opening_id',
        'type',
        'salutation',
        'first_name',
        'middle_name',
        'last_name',
        'company_name',
        'signing_officer_title',
        'marital_status',
        'spouse_name',
        'phone',
        'email',
        'business_name',
        'business_address',
        'occupation',
        'id_verified_by',
        'meeting_date',
        'file_review_date',
        'is_current_address_subject_property'
    ];

    protected $appends = ['name'];


    public function seller_ids()
    {
        return $this->hasMany(SellerId::class, 'seller_id');
    }

    public function current_address()
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'current');
    }

    public function closing_address()
    {
        return $this->morphOne(Address::class, 'addressable')->where('type', 'closing');
    }

    public function getFileReviewDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setFileReviewDateAttribute($date)
    {
        $this->attributes['file_review_date'] = setDateAttribute($date);
    }

    public function getMeetingDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setMeetingDateAttribute($date)
    {
        $this->attributes['meeting_date'] = setDateAttribute($date);
    }

    public function getNameAttribute()
    {
        $name = $this->first_name;
        $name .= $this->middle_name && $this->middle_name != '' ? ' ' . $this->middle_name : '';
        $name .= $this->last_name && $this->last_name != '' ? ' ' . $this->last_name : '';
        return $name;
    }
}
