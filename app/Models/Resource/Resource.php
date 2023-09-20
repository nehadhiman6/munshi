<?php

namespace App\Models\Resource;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class Resource extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "resources";
    protected $connection = 'mysql';
    protected $fillable = [
        'resourceable_type',
        'resourceable_id',
        'attachment_id',
        'remarks',
        'doc_type',
        'doc_description',
        'year'
    ];

    public function attachment(){
        return $this->belongsTo(Attachment::class,'attachment_id');
    }
}

