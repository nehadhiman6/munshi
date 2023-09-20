<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits;

class AppSettings extends Model
{
    use HasFactory;
    use Traits\UserAutoUpdate;
    protected $table = "app_settings";
    protected $connection = 'mysql';
    protected $fillable = [
        'name',
        'settings',
    ];

    public static function setValue($name, $settings)
    {
        $model = static::firstOrNew(['name' => $name]);
        $model->settings = $settings;
        $model->save();
    }

    public static function getValue($name)
    {
        $model = static::where('name', $name)->first();
        $settings = null;
        if ($model) {
            $settings = $model->settings;
        }
        return $settings;
    }
}
