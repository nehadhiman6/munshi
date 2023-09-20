<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;
class Attachment extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "attachments";
    protected $connection = 'mysql';
    protected $fillable = [
        'file_name',
        'file_ext',
        'mime_type',
        'year'
    ];
}
