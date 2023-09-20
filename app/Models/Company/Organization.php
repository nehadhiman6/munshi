<?php

namespace App\Models\Company;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
use App\Models\Masters\City;
use App\Models\Masters\Employee;

class Organization extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "organizations";
    protected $fillable = [
        'organization', 'title', 'website',
        'organization_1',
        'url',
        'type',
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
