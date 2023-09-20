<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;

class UserAttachment extends Model
{
    protected $table = "user_attachments";
    protected $fillable = ['user_id',
    'file_name',
    'file_extension',
    'mime_type'];
    protected $connection = 'mysql';

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
}
