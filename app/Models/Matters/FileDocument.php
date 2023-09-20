<?php

namespace App\Models\Matters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Resource\Resource;
use App\Traits;

class FileDocument extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;

    protected $table = "file_documents";
    protected $fillable = [
        'file_opening_id',
        'document_date',
        'doc_type',
        'subject',
        'remarks',
    ];

     public function getDocumentDateAttribute($date)
    {
        return getDateAttribute($date);
    }

    public function setDocumentDateAttribute($date)
    {
        $this->attributes['document_date'] = setDateAttribute($date);
    }


    public function resource()
    {
        return $this->hasOne(Resource::class, 'resourceable_id')->where('resourceable_type', FileDocument::class);
    }

}
