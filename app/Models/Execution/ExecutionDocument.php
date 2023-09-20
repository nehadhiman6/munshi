<?php

namespace App\Models\Execution;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class ExecutionDocument extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "executions";
    protected $fillable = [
        'file_opening_id',
        'document_name',
        'document_no',
        'field_name',
        'value'
    ];
}
