<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Organization extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "organizations";
    protected $fillable = [
        'organization',
        'organization_1',
        'url',
        'type',
        'title',
        'account_no',
        'website',
        'organization_email',
        'number',
        'street',
        'continued',
        'city',
        'country',
        'postal_code',
        'province',
        'fax',
        'phone',
        'hst_registration_no',
        'law_society_no',
    ];
}
